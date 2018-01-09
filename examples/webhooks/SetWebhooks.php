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
use Smartwaiver\Types\SmartwaiverWebhook;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Set the webhook to new values
$webhook = $sw->setWebhookConfig('http://example.org', SmartwaiverWebhook::WEBHOOK_AFTER_EMAIL_ONLY);

// Access the new webhook config
echo 'Successfully set new configuration.' . PHP_EOL;
echo 'Endpoint: ' . $webhook->endpoint . PHP_EOL;
echo 'EmailValidationRequired: ' . $webhook->emailValidationRequired . PHP_EOL;

// You can also just provide a SmartwaiverWebhook object to set the new values
$webhook->endpoint = 'http://new.example.org';
$webhook->emailValidationRequired = SmartwaiverWebhook::WEBHOOK_BEFORE_AND_AFTER_EMAIL;

$newWebhook = $sw->setWebhook($webhook);

// And double check to make sure the new settings are correct
echo 'Successfully set new configuration.' . PHP_EOL;
echo 'Endpoint: ' . $newWebhook->endpoint . PHP_EOL;
echo 'EmailValidationRequired: ' . $newWebhook->emailValidationRequired . PHP_EOL;
