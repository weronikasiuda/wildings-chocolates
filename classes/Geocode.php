<?php

declare(strict_types=1);

namespace Castlegate\AlcoholicsAnonymous;

use DateTime;

class Geocode
{
    /**
     * Address
     *
     * @var string
     */
    private string $address = '';

    /**
     * Latitude and longitude
     *
     * @var object|null
     */
    private ?object $location = null;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->resetLocation();
    }

    /**
     * Reset location
     *
     * @return void
     */
    public function resetLocation(): void
    {
        $this->location = (object) [
            'lat' => null,
            'lng' => null,
        ];
    }

    /**
     * Install
     *
     * @return void
     */
    public static function install(): void
    {
        static::createTable();
    }

    /**
     * Create database table
     *
     * @return void
     */
    public static function createTable(): void
    {
        global $wpdb;

        $wpdb->query($wpdb->prepare('CREATE TABLE IF NOT EXISTS %i (
            `location_id` INT AUTO_INCREMENT PRIMARY KEY,
            `address` VARCHAR(256),
            `lat` FLOAT,
            `lng` FLOAT,
            `updated` DATETIME
        )', static::getTableName()));
    }

    /**
     * Return database table name
     *
     * @return string
     */
    public static function getTableName(): string
    {
        global $wpdb;

        return $wpdb->base_prefix . 'aa_locations';
    }

    /**
     * Set address
     *
     * @param string
     * @return void
     */
    public function setAddress(string $address): void
    {
        $address = static::sanitizeAddress($address);

        if ($address !== $this->address) {
            $this->resetLocation();
        }

        $this->address = $address;
    }

    /**
     * Sanitize address
     *
     * @param string $address
     * @return string
     */
    private static function sanitizeAddress(string $address): string
    {
        $address = strtolower($address);
        $address = trim($address);
        $address = preg_replace('/\s{2,}/', ' ', $address);

        return $address;
    }

    /**
     * Return latitude and longitude
     *
     * @return object|null
     */
    public function getLatitudeLongitude(): ?object
    {
        // Cannot return a location without an address
        if (!$this->address) {
            return null;
        }

        // Location already assigned to property?
        if (is_float($this->location->lat) && is_float($this->location->lng)) {
            return $this->location;
        }

        // Return location from API (via database cache)
        return $this->getLatitudeLongitudeFromDatabase();
    }

    /**
     * Return latitude and longitude from API (via database cache)
     *
     * @return object|null
     */
    private function getLatitudeLongitudeFromDatabase(): ?object
    {
        global $wpdb;

        $location = $wpdb->get_row($wpdb->prepare(
            'SELECT * FROM %i WHERE `address` = %s',
            static::getTableName(),
            $this->address
        ));

        // Location not found in database?
        if (!is_object($location)) {
            return $this->getLatitudeLongitudeFromApi();
        }

        // Location not updated in the last week?
        $threshold = new DateTime('-1 week');
        $updated = DateTime::createFromFormat('Y-m-d H:i:s', $location->updated);

        if ($updated < $threshold) {
            return $this->getLatitudeLongitudeFromApi((int) $location->location_id);
        }

        // Location found and has valid latitude and longitude?
        if (is_numeric($location->lat) && is_numeric($location->lng)) {
            $this->location->lat = (float) $location->lat;
            $this->location->lng = (float) $location->lng;

            return $this->location;
        }

        // Location does not exist
        return null;
    }

    /**
     * Return latitude and longitude from API
     *
     * @param int|null $location_id
     * @return object|null
     */
    private function getLatitudeLongitudeFromApi(int $location_id = null): ?object
    {
        global $wpdb;

        // Address and Google Maps API key (not restricted by referrer) are
        // required for geocoding.
        if (!$this->address || !defined('GOOGLE_MAPS_GEOCODE_API_KEY')) {
            return null;
        }

        // Request data from Google Maps API
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, add_query_arg([
            'address' => urlencode($this->address),
            'key' => GOOGLE_MAPS_GEOCODE_API_KEY,
        ], 'https://maps.googleapis.com/maps/api/geocode/json'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'php');

        $result = curl_exec($ch);
        $curl_error = curl_error($ch);

        curl_close($ch);

        // Parse JSON response from API
        $data = json_decode($result);
        $lat = $data->results[0]->geometry->location->lat ?? null;
        $lng = $data->results[0]->geometry->location->lng ?? null;

        // Errors?
        $api_error = $data->error_message ?? null;
        $api_status = $data->status ?? null;

        if ($curl_error || $api_error || $api_status !== 'OK') {
            error_log(json_encode([
                'errors' => [
                    'curl' => $curl_error,
                    'api' => $api_error,
                ],
                'response' => $data,
            ]));
        }

        // error_log(json_encode($data));

        // Set properties
        $this->location->lat = $lat;
        $this->location->lng = $lng;

        $address = $this->address;
        $updated = date('Y-m-d H:i:s');

        $data = compact('address', 'lat', 'lng', 'updated');

        // Save to database
        if ($location_id) {
            $wpdb->update(static::getTableName(), $data, compact('location_id'));
        } else {
            $wpdb->insert(static::getTableName(), $data);
        }

        // Return location or null
        if (is_null($lat) || is_null($lng)) {
            return null;
        }

        return $this->location;
    }
}
