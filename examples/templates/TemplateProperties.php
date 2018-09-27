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

// The unique ID of the template to be retrieved
$templateId = '[INSERT TEMPLATE ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Retrieve a specific template (SmartwaiverTemplate object)
$template = $sw->getWaiverTemplate($templateId);

// Access properties of the template
// These are all the available properties for a SmartwaiverTemplate
echo 'Template Id: ' . $template->templateId . PHP_EOL;
echo 'Title: ' . $template->title . PHP_EOL;
echo 'Published On: ' . $template->publishedOn . PHP_EOL;
echo 'Published Version: ' . $template->publishedVersion . PHP_EOL;
echo 'Web URL: ' . $template->webUrl . PHP_EOL;
echo 'Kiosk URL: ' . $template->kioskUrl . PHP_EOL;
echo 'Vanity URLs: ' . PHP_EOL;
foreach ($template->vanityUrls as $vanityUrl) {
    echo "\t" . $vanityUrl . PHP_EOL;
}
