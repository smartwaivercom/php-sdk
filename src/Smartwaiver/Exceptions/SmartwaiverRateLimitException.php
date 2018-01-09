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

use GuzzleHttp\Psr7\Response;

/**
 * Class SmartwaiverRateLimitException
 *
 * @package Smartwaiver\Exceptions
 */
class SmartwaiverRateLimitException extends SmartwaiverHTTPException
{
    /**
     * @var int $requests The number of requests made in the current window
     */
    public $requests;

    /**
     * @var int $max The maximum number of requests allowed in the current window
     */
    public $max;

    /**
     * @var int $retryAfter How many seconds until the rate limit will expire
     */
    public $retryAfter;

    /**
     * SmartwaiverRateLimitException constructor.
     *
     * @param Response $guzzleResponse The guzzle response object from the bad request
     * @param string $guzzleBody The body of the guzzle response from the bad request
     * @param string $content The processed content of the API response
     */
    public function __construct(Response $guzzleResponse, $guzzleBody, $content)
    {
        $rateLimit = $content['rate_limit'];
        $this->requests = $rateLimit['requests'];
        $this->max = $rateLimit['max'];
        $this->retryAfter = $rateLimit['retryAfter'];
        $content['message'] = 'Retry After ' . $this->retryAfter . ' seconds...';

        parent::__construct($guzzleResponse, $guzzleBody, $content);
    }
}