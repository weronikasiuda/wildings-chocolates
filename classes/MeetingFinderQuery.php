<?php

declare(strict_types=1);

namespace Castlegate\AlcoholicsAnonymous;

class MeetingFinderQuery
{
    private ?float $latitude = null;
    private ?float $longitude = null;
    private ?array $days = null;
    private array $timeRanges = [];
    private ?bool $inPerson = null;
    private ?bool $online = null;
    private ?bool $wheelchairAccess = null;
    private ?bool $signLanguage = null;
    private ?bool $hearingAidLoop = null;
    private ?bool $chitSystem = null;
    private ?int $intergroupId = null;
    private ?int $intergroupApiId = null;
    private ?string $orderBy = null;
    private ?int $limit = null;
    private int $offset = 0;

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return void
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return void
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * Set days
     *
     * @param array $days
     * @return void
     */
    public function setDays(array $days): void
    {
        $this->days = array_intersect($days, array_keys(MeetingFinder::getDays()));
        sort($this->days);
    }

    /**
     * Set time ranges
     *
     * Each range must be an array with two items and each item must be a string
     * representation of a time, e.g. "07:00" or "14:15".
     *
     * @param array $ranges
     * @return void
     */
    public function setTimeRanges(array $ranges): void
    {
        $this->timeRanges = [];
        $pattern = '/\d{1,2}:\d{2}/';

        foreach ($ranges as $range) {
            $start = $range[0] ?? null;
            $end = $range[1] ?? null;

            if (
                !is_string($start) ||
                !is_string($end) ||
                !preg_match($pattern, $start) ||
                !preg_match($pattern, $end)
            ) {
                trigger_error('Invalid time format');
                continue;
            }

            $this->timeRanges[] = [$start, $end];
        }
    }

    /**
     * Set in person
     *
     * @param bool
     * @return void
     */
    public function setInPerson(bool $value): void
    {
        $this->inPerson = $value;
    }

    /**
     * Set online
     *
     * @param bool
     * @return void
     */
    public function setOnline(bool $value): void
    {
        $this->online = $value;
    }

    /**
     * Set wheelchair access
     *
     * @param bool
     * @return void
     */
    public function setWheelchairAccess(bool $value): void
    {
        $this->wheelchairAccess = $value;
    }

    /**
     * Set sign language
     *
     * @param bool
     * @return void
     */
    public function setSignLanguage(bool $value): void
    {
        $this->signLanguage = $value;
    }

    /**
     * Set hearing aid loop
     *
     * @param bool
     * @return void
     */
    public function setHearingAidLoop(bool $value): void
    {
        $this->hearingAidLoop = $value;
    }

    /**
     * Set chit system
     *
     * @param bool
     * @return void
     */
    public function setChitSystem(bool $value): void
    {
        $this->chitSystem = $value;
    }

    /**
     * Set intergroup ID
     *
     * @param int
     * @return void
     */
    public function setIntergroupId(int $id): void
    {
        $this->intergroupId = $id;
    }

    /**
     * Set intergroup API ID
     *
     * @param int
     * @return void
     */
    public function setIntergroupApiId(int $id): void
    {
        $this->intergroupApiId = $id;
    }

    /**
     * Set sort order
     *
     * @param string
     * @return void
     */
    public function setSort(string $sort): void
    {
        $this->orderBy = null;

        if (!array_key_exists($sort, MeetingFinder::getSortOptions())) {
            trigger_error('Invalid sort order');
            return;
        }

        $this->orderBy = $sort;
    }

    /**
     * Set limit
     *
     * @param int $limit
     * @return void
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * Set offset
     *
     * @param int $offset
     * @return void
     */
    public function setOffset(int $offset): void
    {
        if ($offset < 0) {
            $offset = 0;
        }

        $this->offset = $offset;
    }

    /**
     * Return paginated results
     *
     * @return array
     */
    public function getResults(): array
    {
        return $this->getGenericResults(true);
    }

    /**
     * Return all results
     *
     * @return array
     */
    public function getAllResults(): array
    {
        return $this->getGenericResults(false);
    }

    /**
     * Return results (all or paginated)
     *
     * @param bool $limit
     * @return array
     */
    private function getGenericResults(bool $limit = false): array
    {
        global $wpdb;

        $query = $this->getQuery($limit);
        $results = $wpdb->get_results($query);

        if (is_array($results)) {
            return $results;
        }

        return [];
    }

    /**
     * Return total number of results
     *
     * @return int
     */
    public function getResultsCount(): int
    {
        return count($this->getAllResults());
    }

    /**
     * Return MySQL query
     *
     * @param bool $limit Include limit and offset parameters
     * @return string
     */
    private function getQuery(bool $limit = false): string
    {
        $clauses = [
            $this->getSelectClause(),
            $this->getWhereClause(),
            $this->getHavingClause(),
            $this->getOrderByClause(),
        ];

        if ($limit) {
            $clauses[] = $this->getLimitClause();
        }

        return implode(' ', $clauses);
    }

    /**
     * Return MySQL SELECT clause
     *
     * @return string
     */
    private function getSelectClause(): string
    {
        global $wpdb;

        $columns = '*';

        $args = [
            MeetingFinder::getTableName(),
        ];

        // Distance in kilometres (if latitude and longitude are available)
        // https://www.geodatasource.com/resources/tutorials/how-to-calculate-the-distance-between-2-locations-using-php/
        if (is_float($this->latitude) && is_float($this->longitude)) {
            $columns .= ', (
                ACOS(
                    SIN(RADIANS(%f)) *
                    SIN(RADIANS(latitude)) +
                    COS(RADIANS(%f)) *
                    COS(RADIANS(latitude)) *
                    COS(RADIANS(%f - longitude))
                ) * 6371
            ) AS distance';

            $args = array_merge([
                $this->latitude,
                $this->latitude,
                $this->longitude,
            ], $args);
        }

        // Date and time of the next available meeting, which can be later on
        // the same day or on a subsequent day within the next week. Note that
        // days are stored as integers in the database, where 1 = Monday, 2 =
        // Tuesday, etc. A meeting is assumed to take place on the same day and
        // time every week.
        $columns .= ', CASE
            WHEN WEEKDAY(CURRENT_DATE()) + 1 = `day`
                THEN IF(CURRENT_TIME() > `start_time`, CURRENT_DATE() + INTERVAL 7 DAY, CURRENT_DATE())
            WHEN WEEKDAY(CURRENT_DATE()) + 1 > `day`
                THEN (CURRENT_DATE() + INTERVAL (6 - WEEKDAY(CURRENT_DATE())) DAY) + INTERVAL `day` DAY
            ELSE (CURRENT_DATE() + INTERVAL (0 - WEEKDAY(CURRENT_DATE())) DAY) + INTERVAL (`day` - 1) DAY
        END AS meeting_date';

        return $wpdb->prepare("SELECT $columns FROM %i", ...$args);
    }

    /**
     * Return MySQL WHERE clause
     *
     * @return string
     */
    private function getWhereClause(): string
    {
        $parts = [];

        // Days
        if (is_array($this->days)) {
            $days = array_intersect($this->days, array_keys(MeetingFinder::getDays()));

            if ($days) {
                $parts[] = '`day` IN (' . implode(', ', $days) . ')';
            }
        }

        // Times
        $times = $this->getTimeRangeClause();

        if ($times) {
            $parts[] = $times;
        }

        // In person and/or online
        $in_person = $this->getInPersonOnlineClause();

        if ($in_person) {
            $parts[] = $in_person;
        }

        // Access
        if ($this->wheelchairAccess) {
            $parts[] = 'wheelchair_access = 1';
        } elseif ($this->wheelchairAccess === false) {
            $parts[] = 'wheelchair_access != 1';
        }

        if ($this->signLanguage) {
            $parts[] = 'sign_language = 1';
        } elseif ($this->signLanguage === false) {
            $parts[] = 'sign_language != 1';
        }

        if ($this->hearingAidLoop) {
            $parts[] = 'hearing_aid_loop = 1';
        } elseif ($this->hearingAidLoop === false) {
            $parts[] = 'hearing_aid_loop != 1';
        }

        if ($this->chitSystem) {
            $parts[] = 'chit_system = 1';
        } elseif ($this->chitSystem === false) {
            $parts[] = 'chit_system != 1';
        }

        if (is_int($this->intergroupId)) {
            $parts[] = 'intergroup_id = ' . $this->intergroupId;
        }

        if (is_int($this->intergroupApiId)) {
            $parts[] = 'intergroup_api_id = ' . $this->intergroupApiId;
        }

        // Exclude invalid records
        $parts[] = 'start_time IS NOT NULL';

        // Assemble WHERE clause
        if ($parts) {
            return 'WHERE ' . implode(' AND ', $parts);
        }

        return '';
    }

    /**
     * Return time range part of MySQL WHERE clause
     *
     * @return string
     */
    private function getTimeRangeClause(): string
    {
        global $wpdb;

        $parts = [];

        foreach ($this->timeRanges as $range) {
            $start = $range[0] ?? null;
            $end = $range[1] ?? null;

            if (!is_string($start) || !is_string($end)) {
                continue;
            }

            $parts[] = $wpdb->prepare(
                '(start_time BETWEEN %s AND %s OR end_time BETWEEN %s AND %s)',
                $start,
                $end,
                $start,
                $end
            );
        }

        if ($parts) {
            return '(' . implode(' OR ', $parts) . ')';
        }

        return '';
    }

    /**
     * Return in person and/or online clause
     *
     * @return string
     */
    private function getInPersonOnlineClause(): string
    {
        $parts = [];

        if ($this->inPerson) {
            $parts[] = 'in_person = 1';
        } elseif ($this->inPerson === false) {
            $parts[] = 'in_person != 1';
        }

        if ($this->online) {
            $parts[] = 'online = 1';
        } elseif ($this->online === false) {
            $parts[] = 'online != 1';
        }

        if ($parts) {
            return '(' . implode(' AND ', $parts) . ')';
        }

        return '';
    }

    /**
     * Return MySQL HAVING clause
     *
     * @return string
     */
    private function getHavingClause(): string
    {
        global $wpdb;

        $distance = $this->getMaxDistance();

        if (is_float($this->latitude) && is_float($this->longitude) && is_int($distance)) {
            return $wpdb->prepare('HAVING distance < %d', $distance);
        }

        return '';
    }

    /**
     * Return maximum distance (km)
     *
     * @return int|null
     */
    private function getMaxDistance(): ?int
    {
        return 40;
    }

    /**
     * Return MySQL ORDER BY clause
     *
     * @return string
     */
    private function getOrderByClause(): string
    {
        $sort = $this->orderBy;

        if (is_string($sort)) {
            $sort = strtolower($sort);
        }

        // Cannot sort by distance if no latitude or longitude
        if ($sort === 'distance' && (!is_float($this->latitude) || !is_float($this->longitude))) {
            $sort = 'date';
        }

        // Default sort order is by date
        switch ($sort) {
            case 'distance':
                return 'ORDER BY distance ASC, meeting_date ASC, start_time ASC';
            case 'az':
                return 'ORDER BY meeting_name ASC';
            case 'za':
                return 'ORDER BY meeting_name DESC';
            default:
                return 'ORDER BY meeting_date ASC, start_time ASC';
        }
    }

    /**
     * Return MySQL LIMIT and OFFSET clause
     *
     * @return string
     */
    private function getLimitClause(): string
    {
        global $wpdb;

        if (is_int($this->limit)) {
            return $wpdb->prepare('LIMIT %d OFFSET %d', $this->limit, $this->offset);
        }

        return '';
    }
}
