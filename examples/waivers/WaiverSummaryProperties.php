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

// Access waiver summary properties
// These are all the available properties for a SmartwaiverWaiverSummary
if(count($waiverSummaries) > 1) {
    $waiverSummary = $waiverSummaries[0];
    echo 'Waiver Id: ' . $waiverSummary->waiverId . PHP_EOL;
    echo 'Template Id: ' . $waiverSummary->templateId . PHP_EOL;
    echo 'Title: ' . $waiverSummary->title . PHP_EOL;
    echo 'Created On: ' . $waiverSummary->createdOn . PHP_EOL;
    echo 'Expiration Date: ' . $waiverSummary->expirationDate . PHP_EOL;
    echo 'Expired: ' . ($waiverSummary->expired ? 'true' : 'false') . PHP_EOL;
    echo 'Verified: ' . ($waiverSummary->verified ? 'true' : 'false') . PHP_EOL;
    echo 'Kiosk: ' . ($waiverSummary->kiosk ? 'true' : 'false') . PHP_EOL;
    echo 'First Name: ' . $waiverSummary->firstName . PHP_EOL;
    echo 'Middle Name: ' . $waiverSummary->middleName . PHP_EOL;
    echo 'Last Name: ' . $waiverSummary->lastName . PHP_EOL;
    echo 'Dob: ' . $waiverSummary->dob . PHP_EOL;
    echo 'Is Minor: ' . ($waiverSummary->isMinor ? 'true' : 'false') . PHP_EOL;
    echo 'Tags: ' . implode(',', $waiverSummary->tags) . PHP_EOL;
    echo 'Flags: (Display Text, Reason)' . PHP_EOL;
    foreach ($waiver->flags as $flag) {
        echo '    ' . $flag->displayText . ', ' . $flag->reason . PHP_EOL;
    }
}
