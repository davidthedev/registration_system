<?php

namespace App\Services;

/**
 * Sanitization service sanitizes and cleans data before (if) it hits
 * validation class. It accepts an array of data
 * and another array of rules on how to to clean the data.
 */
class SanitizationService {

    protected $filteredData = [];
    protected $unfilteredData = [];

    public function filter($data, $filtersAndFields)
    {
        $this->unfilteredData = $data;
        foreach ($filtersAndFields as $field => $params) {
            $filters = explode(',', $params);
            foreach ($filters as $key => $filter) {
                $filtered = $this->$filter($data[$field]);
                $data[$field] = $filtered;
            }
            $this->filteredData[$field] = $data[$field];
        }
        return $this;
    }

    public function getFilteredData()
    {
        foreach ($this->unfilteredData as $key => $value) {
            if (!array_key_exists($key, $this->filteredData)) {
                $this->filteredData[$key] = $value;
            }
        }
        return $this->filteredData;
    }

    protected function trim($data)
    {
        return trim($data);
    }

    protected function sanitize($data)
    {
        return filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    protected function email($data)
    {
        return filter_var($data, FILTER_SANITIZE_EMAIL);
    }
}
