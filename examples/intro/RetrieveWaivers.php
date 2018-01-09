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

// Get a list of all signed waivers for this account
$summaries = $sw->getWaiverSummaries();

// List waiver ID and title for each summary returned
echo 'List all waivers:' . PHP_EOL;
foreach ($summaries as $summary) {
    echo $summary->waiverId . ': ' . $summary->title . PHP_EOL;
}

// Get details for a specific waiver (include participants)
if(count($summaries) > 1) {
    // Pull out waiver ID from summary
    $waiverId = $summaries[0]->waiverId;

    // Get the waiver object
    $waiver = $sw->getWaiver($waiverId);

    // Access properties of waiver
    echo PHP_EOL . 'List single waiver:' . PHP_EOL;
    echo $waiver->waiverId . ': ' . $waiver->title . PHP_EOL;

    // List all participants
    foreach($waiver->participants as $participant) {
        echo 'Participant: ' . $participant->firstName
            . ', ' . $participant->middleName
            . ', ' . $participant->lastName
            . ' - ' . $participant->dob . PHP_EOL;
    }
}
