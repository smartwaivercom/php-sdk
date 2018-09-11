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

// Get the current webhook queue information
$queues = $sw->getWebhookQueues();

// Access the webhook information
if (is_null($queues->accountQueue)) {
    echo 'Account Queue: N/A' . PHP_EOL;
} else {
    echo 'Account Queue:' . PHP_EOL;
    echo "\tTotal Messages: " . $queues->accountQueue->messagesTotal . PHP_EOL;
    echo "\tMessages Not Visible: " . $queues->accountQueue->messagesNotVisible . PHP_EOL;
    echo "\tMessages Delayed: " . $queues->accountQueue->messagesDelayed . PHP_EOL;
}

// Access the template level webhook information
foreach ($queues->templateQueues as $templateId => $templateQueue) {
    echo 'Template Queue (' . $templateId . '):' . PHP_EOL;
    echo "\tTotal Messages: " . $queues->accountQueue->messagesTotal . PHP_EOL;
    echo "\tMessages Not Visible: " . $queues->accountQueue->messagesNotVisible . PHP_EOL;
    echo "\tMessages Delayed: " . $queues->accountQueue->messagesDelayed . PHP_EOL;
}
