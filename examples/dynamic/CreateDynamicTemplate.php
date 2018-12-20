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

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// We are going to create a basic template
$templateConfig = new SmartwaiverTemplateConfig();

// Set the title of our template
$templateConfig->meta->title = 'Dynamic Template';

// Set the body of our template to our legal language
$templateConfig->body->text = 'Lots of legal language here!';

// Allow our template to have adults
$templateConfig->participants->adults = true;

// Add the emergency contact standard field
$templateConfig->standardQuestions->emergencyContactEnabled = true;

// Now we are going to create some data to prefill this template with
$data = new SmartwaiverTemplateData();

// Add a participant
$data->addParticipant('Kyle', 'Smith');

// One final piece, how long do we want our template to last if nobody fills it in (this is in seconds)
$expiration = 300;

// Now it's time to make our API call.
$dynamicTemplate = $sw->createDynamicTemplate($templateConfig, $data, $expiration);

// Access our created template
echo 'Successfully created dynamic template.' . PHP_EOL;
echo 'Template ID: ' . $dynamicTemplate->uuid . ' expires in ' . $dynamicTemplate->expiration . ' seconds...' . PHP_EOL;
echo 'Please go to ' . $dynamicTemplate->url . ' to fill it out!' . PHP_EOL;
