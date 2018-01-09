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

require_once __DIR__ . '/../../../../autoload.php';

use Smartwaiver\Smartwaiver;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

echo 'Performing search for all waiver signed after 2017-01-01 00:00:00...' . PHP_EOL;
// Request all waivers signed in 2017
$search = $sw->search('', '2017-01-01 00:00:00');

// Print out some information about the result of the search
echo 'Search Complete:' . PHP_EOL;
echo "\t" . 'Search ID: ' . $search->guid . PHP_EOL;
echo "\t" . 'Waiver Count: ' . $search->count . PHP_EOL;
echo "\t" . $search->pages . ' pages of size ' . $search->pageSize . PHP_EOL . PHP_EOL;

// We're going to create a list of all the first names on all the waivers
// First we set up our list
$nameList = [];

// Loop through all the pages in the search result
for($i = 0; $i < $search->pages; $i++) {
    echo 'Requesting page: ' . $i . '/' . $search->pages . '...' . PHP_EOL;

    // Request each page from the server
    $waivers = $sw->searchResult($search, $i);

    echo 'Processing page: ' . $i . '/' . $search->pages . '...' . PHP_EOL;

    // Loop through the waivers and add them to the list
    foreach ($waivers as $waiver) {
        array_push($nameList, $waiver->firstName);

        // View all accessible properties of a waiver object in:
        // examples/waivers/WaiverProperties.php
    }
}

echo 'Finished processing...' . PHP_EOL;

// Print out the list
echo implode(', ', $nameList);
