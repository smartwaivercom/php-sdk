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

namespace Smartwaiver\Tests;

use GuzzleHttp\Psr7\Response;
use Smartwaiver\SmartwaiverRawResponse;

/**
 * Class SmartwaiverRawResponseTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverRawResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that response object is properly created
     */
    public function testResponseCreation()
    {
        $guzzleResponse = new Response(200, [], 'TestingResponseBody');

        $response = new SmartwaiverRawResponse($guzzleResponse);
        $this->assertEquals(200, $response->statusCode);
        $this->assertEquals('TestingResponseBody', $response->body);
    }
}