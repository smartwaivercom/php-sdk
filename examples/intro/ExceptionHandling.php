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
use Smartwaiver\Exceptions\SmartwaiverHTTPException;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// The Waiver ID to access
$waiverId = 'InvalidWaiverId';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

try
{
    // Try to get the waiver object
    $waiver = $sw->getWaiver($waiverId);
}
catch (SmartwaiverHTTPException $se)
{
    // SmartwaiverHTTPException will be thrown for any errors returned by the
    // API in a RESTful way.
    // Examples include: 404 Not Found, 401 Not Authorized, etc.
    echo 'Error retrieving waiver from API server...' . PHP_EOL . PHP_EOL;

    // The code will be the HTTP Status Code returned
    echo 'Error Code: ' . $se->getCode() . PHP_EOL;
    // The message will be informative about what was wrong with the request
    echo 'Error Message: ' . $se->getMessage() . PHP_EOL . PHP_EOL;

    // Also included in the exception is the header information returned about
    // the response.
    $responseInfo = $se->getResponseInfo();
    echo 'API Version: ' . $responseInfo['version'] . PHP_EOL;
    echo 'UUID: ' . $responseInfo['id'] . PHP_EOL;
    echo 'Timestamp: ' . $responseInfo['ts'] . PHP_EOL;
}
