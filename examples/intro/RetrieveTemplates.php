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

// Get a list of all templates
$templates = $sw->getWaiverTemplates();

echo 'List all waiver templates:' . PHP_EOL;
foreach ($templates as $template) {
    echo $template->templateId . ': ' . $template->title . PHP_EOL;
}

// Get a specific template
$template = $sw->getWaiverTemplate($templateId);

// Access properties of the template
echo PHP_EOL . 'List single template:' . PHP_EOL;
echo $template->templateId . ': ' . $template->title . PHP_EOL;
