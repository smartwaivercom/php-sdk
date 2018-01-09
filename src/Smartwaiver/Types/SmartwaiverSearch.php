<?php
/**
 * Copyright 2018 Smartwaiver
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Smartwaiver\Types;

/**
 * Class SmartwaiverSearch
 *
 * This class represents all the data for the result of a search
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverSearch extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'guid',
        'count',
        'pages',
        'pageSize'
    ];

    /**
     * @var string The guid of the search result
     */
    public $guid;

    /**
     * @var string The number of waivers in the search results
     */
    public $count;

    /**
     * @var string The number of pages in the search results
     */
    public $pages;

    /**
     * @var string The number of waivers in each page of results
     */
    public $pageSize;

    /**
     * Create a SmartwaiverSearch object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $search  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $search)
    {
        // Check for required keys
        parent::__construct($search, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->guid = $search['guid'];
        $this->count = $search['count'];
        $this->pages = $search['pages'];
        $this->pageSize = $search['pageSize'];
    }
}