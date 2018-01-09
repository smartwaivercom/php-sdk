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

use Smartwaiver\Exceptions\SmartwaiverHTTPException;
use Smartwaiver\Exceptions\SmartwaiverRateLimitException;
use Smartwaiver\Exceptions\SmartwaiverSDKException;
use Smartwaiver\SmartwaiverResponse;
use Smartwaiver\Tests\Factories\APIErrorResponses;
use Smartwaiver\Tests\Factories\APISuccessResponses;

/**
 * Class SmartwaiverResponseTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * API Key used for tests
     */
    const TEST_API_KEY = 'TestApiKey';

    /**
     * Test that an empty response throws an error
     */
    public function testConstructEmptyBody()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('Malformed JSON response from API server');

        $response = new Response();
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that unexpected JSON throws an error
     */
    public function testConstructInvalidJson()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('Malformed JSON response from API server');

        $response = new Response(200, [], '{"testing":}');
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that missing the version fields throw an error
     */
    public function testMissingFieldVersion()
    {
        $this->expectException(SmartwaiverSDKException::class);

        $template = APISuccessResponses::templateArray();
        unset($template['version']);
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that missing the id field throws an error
     */
    public function testMissingFieldId()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('API server response missing expected field: id');

        $template = APISuccessResponses::templateArray();
        unset($template['id']);
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that missing the timestamp field throws an error
     */
    public function testMissingFieldTimestamp()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('API server response missing expected field: ts');

        $template = APISuccessResponses::templateArray();
        unset($template['ts']);
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that missing the type field throws an error
     */
    public function testMissingFieldType()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('API server response missing expected field: type');

        $template = APISuccessResponses::templateArray();
        unset($template['type']);
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that a proper response set's all information correctly
     */
    public function testSuccess()
    {
        $template = APISuccessResponses::templateArray();
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);

        $this->assertEquals($template['version'], $swResponse->version);
        $this->assertEquals($template['id'], $swResponse->id);
        $this->assertEquals($template['ts'], $swResponse->ts);
        $this->assertEquals($template['type'], $swResponse->type);
        $this->assertEquals($template['template'], $swResponse->responseData);
    }

    /**
     * Test that an unknown type throws an error
     */
    public function testSuccessUnknownType()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('JSON response contains unknown type: "broken"');

        $template = APISuccessResponses::templateArray();
        $template['type'] = 'broken';
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that a missing data field throws an error
     */
    public function testSuccessNoContent()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('JSON response does not contain field of type: "template"');

        $template = APISuccessResponses::templateArray();
        unset($template['template']);
        $response = new Response(200, [], json_encode($template));
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that HTTP errors are properly thrown
     */
    public function testHTTPErrors()
    {
        $this->expectException(SmartwaiverHTTPException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid parameter');

        $response = new Response(400, [], APIErrorResponses::parameter());
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that HTTP errors are properly thrown
     */
    public function testRateLimitExceptions()
    {
        $this->expectException(SmartwaiverRateLimitException::class);
        $this->expectExceptionCode(429);
        $this->expectExceptionMessage('Retry After 14 seconds...');

        $response = new Response(429, [], APIErrorResponses::rateLimit());
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that no error message throws an exception
     */
    public function testErrorNoMessage()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('Error response does not include message');

        $response = new Response(500, [], APIErrorResponses::noMessage());
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that a unknown HTTP code throws an exception
     */
    public function testUnknownError()
    {
        $this->expectException(SmartwaiverSDKException::class);
        $this->expectExceptionMessage('Unknown HTTP code returned');

        $response = new Response(430, [], APIErrorResponses::noMessage());
        $swResponse = new SmartwaiverResponse($response);
    }

    /**
     * Test that SmartwaiverHTTPException is passed the correct information and
     * that information is stored correctly.
     */
    public function testHTTPExceptionInfo()
    {
        $response = new Response(500, [], APIErrorResponses::server());
        $expected = [
            'version' => 4,
            'id' => 'a0256461ca244278b412ab3238f5efd2',
            'ts' => '2017-01-23T09:15:45.645Z',
            'type' => 'error'
        ];
        try {
            $swResponse = new SmartwaiverResponse($response);
            self::fail('Did not generate HTTP exception.');
        } catch(SmartwaiverHTTPException $se) {
            $responseInfo = $se->getResponseInfo();
            $this->assertEquals($expected, $responseInfo);
            $this->assertEquals('Internal server error', $se->getMessage());
            $this->assertEquals(500, $se->getCode());
        }
    }

    /**
     * Test that SmartwaiverSDKException is passed the correct information and
     * that information is stored correctly.
     */
    public function testSDKExceptionInfo()
    {
        $response = new Response(460);
        try {
            $swResponse = new SmartwaiverResponse($response);
            self::fail('Did not generate API exception.');
        } catch(SmartwaiverSDKException $se) {
            $this->assertEquals('Malformed JSON response from API server', $se->getMessage());
            $guzzleResponse = $se->getGuzzleResponse();
            $this->assertInstanceOf(Response::class, $guzzleResponse);
            $this->assertEquals(460, $guzzleResponse->getStatusCode());
        }
    }

    /**
     * Test that the Guzzle response is correctly saved
     */
    public function testGetGuzzleResponse()
    {
        // Note: we use 201 here because 200 is the default
        $response = new Response(201, [], APISuccessResponses::template());
        $swResponse = new SmartwaiverResponse($response);

        $guzzleResponse = $swResponse->getGuzzleResponse();
        $this->assertInstanceOf(Response::class, $guzzleResponse);
        $this->assertEquals(201, $guzzleResponse->getStatusCode());
    }
}