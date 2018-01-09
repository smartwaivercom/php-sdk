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

// Get a list of summaries of waivers
$waiverSummaries = $sw->getWaiverSummaries();

// Loop through the waivers and access their properties
echo 'List all waivers:' . PHP_EOL;
foreach ($waiverSummaries as $waiverSummary) {
    echo $waiverSummary->waiverId . ': ' . $waiverSummary->title . PHP_EOL;
}

// Specify parameters for listing signed waivers

// These are the default values
$limit = 20;            // Limit number of waivers returned to twenty (Allowed values: 1-100)
$verified = null;       // Do not care about whether the waiver has been verified by email or not (Allowed values: true, false, null)
$templateId = '';       // Do not limit the waivers returned to a specific template (Allowed values: Valid template ID)
$fromDts = '';          // Do not enforce a date range on the query for waivers (Allowed values: ISO 8601 Date) (Requires toDts parameter)
$toDts = '';            // Used in conjunction with 'fromDts' to provide the date range (Allowed values: ISO 8601 Date) (Requires fromDts parameter)
$firstName = '';        // Only waivers with a participant having this first name.
$lastName = '';         // Only waivers with a participant having this last name.
$tag = '';              // Only waivers with this as the primary tag.

// This will return the the same as the above query because these are the default values
$waiverSummaries = $sw->getWaiverSummaries($limit, $verified, $templateId, $fromDts, $toDts, $firstName, $lastName, $tag);

// An example limiting the parameters
$limit = 5;                                     // Limit number returned to 5
$verified = true;                               // Limit only to waivers that were signed at a kiosk or verified over email
$templateId = '[INSERT TEMPLATE ID]';           // Limit query to waivers of this template ID
$fromDts = date('c', strtotime('2016-11-01'));  // Limit to waivers signed in November of 2016
$toDts = date('c', strtotime('2016-12-01'));
$firstName = 'Kyle';                            // Limit to waivers with a participant named Kyle Smith
$lastName = 'Smith';
$tag = 'testing';                               // Only waivers with 'testing' as the primary tag.

$waiverSummaries = $sw->getWaiverSummaries($limit, $verified, $templateId, $fromDts, $toDts, $firstName, $lastName, $tag);

// View all accessible properties of a waiver summary object in:
// examples/waivers/WaiverSummaryProperties.php
