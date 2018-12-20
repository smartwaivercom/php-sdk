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
use Smartwaiver\Types\Data\SmartwaiverTemplateData;
use Smartwaiver\Types\Template\SmartwaiverTemplateConfig;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// The transaction ID fr the waiver that was filled out
$transactionId = '[INSERT TRANSACTION ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Now it's time to make our API call.
$dynamicProcess = $sw->processDynamicTemplate($transactionId);

// Now we have a waiver ID we can use to query the API
echo 'Successfully processed dynamic template.' . PHP_EOL;
echo 'Transaction ID: ' . $dynamicProcess->transactionId . PHP_EOL;
echo 'Waiver ID: ' . $dynamicProcess->waiverId . PHP_EOL;
