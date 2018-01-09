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

// The unique ID of the template to search for
$templateId = '[INSERT TEMPLATE ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// This will demonstrate all the different searches that you could run

// Request all waivers signed for this template
$search = $sw->search($templateId);

// Request all waivers signed for this template after the given date
//$search = $sw->search($templateId, '2017-01-01 00:00:00');

// Request all waivers signed for this template before the given date
//$search = $sw->search($templateId, '', '2017-01-01 00:00:00');

// Request all waivers signed for this template with a participant name Kyle
//$search = $sw->search($templateId, '', '', 'Kyle');

// Request all waivers signed for this template with a participant name Kyle Smith
//$search = $sw->search($templateId, '', '', 'Kyle', 'Smith');

// Request all waivers signed with a participant name Kyle that have been email verified
//$search = $sw->search('', '', '', 'Kyle', '', true);

// Request all waivers signed in ascending sorted order
//$search = $sw->search($templateId, '', '', '', '', null, false);

// Request all waivers with a primary tag of 'testing'
//$search = $sw->search($templateId, '', '', '', '', null, true, 'testing');

// Print out some information about the result of the search
echo 'Search Complete:' . PHP_EOL;
echo "\t" . 'Search ID: ' . $search->guid . PHP_EOL;
echo "\t" . 'Waiver Count: ' . $search->count . PHP_EOL;
echo "\t" . $search->pages . ' pages of size ' . $search->pageSize . PHP_EOL . PHP_EOL;
