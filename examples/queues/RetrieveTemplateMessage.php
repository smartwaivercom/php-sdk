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

// The Unique ID of the waiver template
$templateId = '[INSERT TEMPLATE ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Retrieve a message from the template queue
$message = $sw->getWebhookQueueAccountMessage($templateId);

// Access the message information
if (is_null($message)) {
    echo 'No messages in template queue.' . PHP_EOL;
    exit;
}

echo 'Message in Template Queue' . PHP_EOL;
echo "\tMessage ID: " . $message->messageId . PHP_EOL;
echo "\tMessage Payload: " . PHP_EOL;
echo "\t\tWaiver ID: " . $message->payload->uniqueId . PHP_EOL;
echo "\t\tEvent: " . $message->payload->event . PHP_EOL;

// Now that we have retrieved the message we can delete it
$delete = $sw->deleteWebhookQueueTemplateMessage($templateId, $message->messageId);

echo 'Deletion Success: ' . ($delete->success ? 'true' : 'false') . PHP_EOL;

// Optionally we can delete the message when we retrieve it, by passing a delete flag
// $message = $sw->getWebhookQueueTemplateMessage($templateId, true);