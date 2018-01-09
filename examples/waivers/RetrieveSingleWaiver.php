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

// The unique ID of the signed waiver to be retrieved
$waiverId = '[INSERT WAIVER ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Get a specific waiver
$waiver = $sw->getWaiver($waiverId);

// Access properties of waiver
echo PHP_EOL . 'List single waiver:' . PHP_EOL;
echo $waiver->waiverId . ': ' . $waiver->title . PHP_EOL;

// Optionally include the Base64 encoded PDF
$pdf = true;

// Get the waiver object
$waiver = $sw->getWaiver($waiverId, $pdf);

echo PHP_EOL . 'PDF: ' . $waiver->pdf . PHP_EOL;

// View all accessible properties of a waiver object in:
// examples/waivers/WaiverProperties.php
