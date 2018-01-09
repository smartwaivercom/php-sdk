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

namespace Smartwaiver;

use GuzzleHttp\Psr7\Response;

/**
 * Class SmartwaiverRawResponse
 *
 * This class provides a simple response from the API server containing the
 * status code and raw body.
 *
 * @package Smartwaiver
 */
class SmartwaiverRawResponse
{
    /**
     * @var integer The status code of the HTTP request to the API server
     */
    public $statusCode;

    /**
     * @var string The raw unprocessed body of the response from the server
     */
    public $body;

    /**
     * Pulls out the appropriate information from the Guzzle Response
     *
     * @param Response $guzzleResponse The entire Guzzle HTTP Response from the request
     */
    public function __construct(Response $guzzleResponse)
    {
        // Save the status code
        $this->statusCode = $guzzleResponse->getStatusCode();

        // Save the response contents
        $this->body = $guzzleResponse->getBody()->getContents();
    }
}