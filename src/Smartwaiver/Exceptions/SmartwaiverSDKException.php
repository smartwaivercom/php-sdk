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

namespace Smartwaiver\Exceptions;

use Exception;
use GuzzleHttp\Psr7\Response;

/**
 * Class SmartwaiverSDKException
 *
 * This class handles all exceptions that have to do with communicating with
 * the API and interpreting the responses.
 *
 * @package Smartwaiver\Exceptions
 */
class SmartwaiverSDKException extends Exception
{
    /**
     * @var Response The Guzzle Psr7 Response object for the request that
     * generated the exception
     */
    private $guzzleResponse;

    /**
     * @var string The body from the guzzle response.
     */
    private $guzzleBody;

    /**
     * SmartwaiverSDKException constructor.
     *
     * @param Response $guzzleResponse
     * @param string $guzzleBody
     * @param string $message
     * @param int $code
     */
    public function __construct(Response $guzzleResponse, $guzzleBody, $message, $code = 0)
    {
        $this->guzzleResponse = $guzzleResponse;
        $this->guzzleBody = $guzzleBody;
        parent::__construct($message, $code);
    }

    /**
     * Access the Guzzle Response object from the request that generated this
     * exception.
     *
     * @return Response The response object
     */
    public function getGuzzleResponse()
    {
        return $this->guzzleResponse;
    }

    /**
     * Access the body of the guzzle response. This is provided since the body
     * is a stream that will be empty in the $guzzleResponse object.
     *
     * @return string The body contents of the response
     */
    public function getGuzzleBody()
    {
        return $this->guzzleBody;
    }
}