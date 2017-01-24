<?php
/**
 * Copyright 2017 Smartwaiver
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

namespace Smartwaiver\Exceptions;

use GuzzleHttp\Psr7\Response;

/**
 * Class SmartwaiverHTTPException
 *
 * @package Smartwaiver\Exceptions
 */
class SmartwaiverHTTPException extends SmartwaiverSDKException
{
    /**
     * @var array Stores the JSON response information that was given back by
     * the API server when it generated the error response.
     */
    private $response;

    /**
     * SmartwaiverHTTPException constructor.
     *
     * @param Response $guzzleResponse The guzzle response object from the bad request
     * @param string $guzzleBody The body of the guzzle response from the bad request
     * @param string $content The processed content of the API response
     */
    public function __construct(Response $guzzleResponse, $guzzleBody, $content)
    {
        $this->response = [];
        $this->response['version'] = $content['version'];
        $this->response['id'] = $content['id'];
        $this->response['ts'] = $content['ts'];
        $this->response['type'] = $content['type'];
        parent::__construct($guzzleResponse, $guzzleBody, $content['message'], $guzzleResponse->getStatusCode());
    }

    /**
     * This method provides access to the parsed information from the API error
     * response. This includes the version, timestamp, and UUID of the response
     *
     * @return array The response header information
     *
     */
    public function getResponseInfo()
    {
        return $this->response;
    }
}