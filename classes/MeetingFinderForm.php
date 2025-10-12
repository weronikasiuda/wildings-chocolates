<?php

declare(strict_types=1);

namespace Castlegate\AlcoholicsAnonymous;

class MeetingFinderForm
{
    /**
     * Query instance
     *
     * @var MeetingFinderQuery|null
     */
    private ?MeetingFinderQuery $query = null;

    /**
     * Default sort
     *
     * @var string
     */
    private string $defaultSort = 'date';

    /**
     * Posts per page
     *
     * @var int
     */
    private int $postsPerPage = 12;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->query = new MeetingFinderQuery();
    }

    /**
     * Has the form been submitted?
     *
     * @return bool
     */
    public function submitted(): bool
    {
        $form = $_GET['form'] ?? null;

        return $form && in_array($form, ['in_person', 'online']);
    }

    /**
     * Return results
     *
     * @return array|null
     */
    public function getResults(): ?array
    {
        if (!$this->submitted()) {
            return null;
        }

        $this->parseGetArgs();

        return $this->query->getResults();
    }

    /**
     * Return results without pagination
     *
     * @return array|null
     */
    public function getAllResults(): ?array
    {
        if (!$this->submitted()) {
            return null;
        }

        $this->parseGetArgs();

        return $this->query->getAllResults();
    }

    /**
     * Check for and parse GET parameters
     *
     * @return void
     */
    public function parseGetArgs(): void
    {
        $this->parseLocationGetArgs();
        $this->parseDayGetArgs();
        $this->parseTimeGetArgs();
        $this->parseAccessGetArgs();
        $this->parseFormatGetArgs();
        $this->parseIntergroupGetArgs();
        $this->parseSortGetArgs();
        $this->parsePaginationGetArgs();
    }

    /**
     * Parse location GET parameters
     *
     * @return void
     */
    private function parseLocationGetArgs(): void
    {
        $location = $this->getSubmittedLatLng();

        if (is_null($location)) {
            return;
        }

        $this->query->setLatitude($location->lat);
        $this->query->setLongitude($location->lng);

        $this->defaultSort = 'distance';
    }

    /**
     * Return latitude and longitude from form
     *
     * @return object|null
     */
    private function getSubmittedLatLng(): ?object
    {
        // Latitude and longitude from latitude and longitude inputs
        $lat = $_GET['lat'] ?? '';
        $lng = $_GET['lng'] ?? '';

        if ($lat !== '' && $lng !== '') {
            return static::sanitizeLatLng($lat, $lng);
        }

        // Latitude and longitude from address and geocoding API
        $address = $_GET['location'] ?? null;

        if (!$address) {
            return null;
        }

        $geocode = new Geocode();
        $geocode->setAddress($address);
        $location = $geocode->getLatitudeLongitude();

        $lat = $location->lat ?? '';
        $lng = $location->lng ?? '';

        return static::sanitizeLatLng($lat, $lng);
    }

    /**
     * Sanitize latitude and longitude
     *
     * @param mixed $lat
     * @param mixed $lng
     * @return object|null
     */
    private static function sanitizeLatLng($lat, $lng): ?object
    {
        if (!is_numeric($lat) || !is_numeric($lng)) {
            return null;
        }

        return (object) array_map('floatval', compact('lat', 'lng'));
    }

    /**
     * Parse day GET parameters
     *
     * @return void
     */
    private function parseDayGetArgs(): void
    {
        $days = $_GET['days'] ?? null;

        if (!is_array($days)) {
            return;
        }

        $days = array_map('intval', $days);
        $days = array_intersect($days, array_keys(MeetingFinder::getDays()));

        if ($days) {
            $this->query->setDays($days);
        }
    }

    /**
     * Parse time GET parameters
     *
     * @return void
     */
    private function parseTimeGetArgs(): void
    {
        $times = $_GET['times'] ?? null;
        $ranges = [];

        if (!is_array($times)) {
            return;
        }

        foreach (MeetingFinder::getTimeRanges() as $key => $time) {
            if (in_array($key, $times)) {
                $ranges[] = $time['range'];
            }
        }

        if ($ranges) {
            $this->query->setTimeRanges($ranges);
        }
    }

    /**
     * Parse access GET parameters
     *
     * @return void
     */
    private function parseAccessGetArgs(): void
    {
        $wheelchair_access = $_GET['wheelchair_access'] ?? false;
        $sign_language = $_GET['sign_language'] ?? false;
        $hearing_aid_loop = $_GET['hearing_aid_loop'] ?? false;
        $chit_system = $_GET['chit_system'] ?? false;

        if ($wheelchair_access) {
            $this->query->setWheelchairAccess(true);
        }

        if ($sign_language) {
            $this->query->setSignLanguage(true);
        }

        if ($hearing_aid_loop) {
            $this->query->setHearingAidLoop(true);
        }

        if ($chit_system) {
            $this->query->setChitSystem(true);
        }
    }

    /**
     * Parse format GET parameters
     *
     * @return void
     */
    private function parseFormatGetArgs(): void
    {
        $form = $_GET['form'] ?? null;
        $hybrid = $_GET['hybrid'] ?? null;

        if (!$form || !in_array($form, ['in_person', 'online'])) {
            $form = 'in_person';
        }

        // Online meetings
        if ($form === 'online') {
            $this->query->setInPerson(false);
            $this->query->setOnline(true);

            return;
        }

        // In person meetings (online optional)
        if ($hybrid) {
            $this->query->setInPerson(true);

            return;
        }

        // In person meetings only
        $this->query->setInPerson(true);
        $this->query->setOnline(false);
    }

    /**
     * Parse intergroup GET parameters
     *
     * @return void
     */
    private function parseIntergroupGetArgs(): void
    {
        $intergroup_id = (int) ($_GET['intergroup_id'] ?? 0);
        $intergroup_api_id = (int) ($_GET['intergroup_api_id'] ?? 0);

        if ($intergroup_id) {
            $this->query->setIntergroupId($intergroup_id);
        }

        if ($intergroup_api_id) {
            $this->query->setIntergroupApiId($intergroup_api_id);
        }
    }

    /**
     * Parse sort GET parameters
     *
     * @return void
     */
    private function parseSortGetArgs(): void
    {
        $sort = $_GET['sort'] ?? null;

        if (!$sort || !array_key_exists($sort, MeetingFinder::getSortOptions())) {
            $sort = $this->defaultSort;
        }

        $this->query->setSort($sort);
    }

    /**
     * Parse pagination GET parameters
     *
     * @return void
     */
    private function parsePaginationGetArgs(): void
    {
        if (!$this->hasPagination()) {
            return;
        }

        $current = $this->getCurrentPage();

        $this->query->setLimit($this->postsPerPage);
        $this->query->setOffset($this->postsPerPage * ($current - 1));
    }

    /**
     * Return current page number
     *
     * @return int|null
     */
    public function getCurrentPage(): ?int
    {
        if (!$this->hasPagination()) {
            return null;
        }

        $page = $_GET['meeting_page'] ?? null;
        $last = $this->getLastPage();

        if (is_numeric($page)) {
            $page = (int) $page;
        } else {
            $page = 1;
        }

        if ($page > $last) {
            return $last;
        }

        return $page;
    }

    /**
     * Return last page number
     *
     * @return int|null
     */
    public function getLastPage(): ?int
    {
        if (!$this->hasPagination()) {
            return null;
        }

        return (int) ceil($this->query->getResultsCount() / $this->postsPerPage);
    }

    /**
     * Results have pagination?
     *
     * @return bool
     */
    private function hasPagination(): bool
    {
        $view = $_GET['view'] ?? null;

        if ($view === 'map' || $this->postsPerPage < 1) {
            return false;
        }

        return true;
    }

    /**
     * Return list of page numbers
     *
     * @return array|null
     */
    public function getPages(): ?array
    {
        if (!$this->hasPagination()) {
            return null;
        }

        $last = $this->getLastPage();

        if (!$last) {
            return null;
        }

        return range(1, $last);
    }
}
