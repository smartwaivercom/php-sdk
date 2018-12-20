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
use Smartwaiver\Exceptions\SmartwaiverHTTPException;
use Smartwaiver\Exceptions\SmartwaiverRateLimitException;
use Smartwaiver\Exceptions\SmartwaiverSDKException;

/**
 * Class SmartwaiverResponse
 *
 * This class processes general information for all HTTP responses from the API
 * server. Version, Unique ID, and Timestamp information for every request are
 * stored in this class.
 *
 * @package Smartwaiver
 */
class SmartwaiverResponse
{
    /**
     * Mapping from response type to key in JSON object containing data
     */
    const RESPONSE_TYPES = [
        'templates' => 'templates',
        'template' => 'template',
        'waivers' => 'waivers',
        'waiver' => 'waiver',
        'photos' => 'photos',
        'signatures' => 'signatures',
        'search' => 'search',
        'search_results' => 'search_results',
        'webhooks' => 'webhooks',
        'api_webhook_all_queue_message_count' => 'api_webhook_all_queue_message_count',
        'api_webhook_account_message_get' => 'api_webhook_account_message_get',
        'api_webhook_template_message_get' => 'api_webhook_template_message_get',
        'api_webhook_account_message_delete' => 'api_webhook_account_message_delete',
        'api_webhook_template_message_delete' => 'api_webhook_template_message_delete',
        'dynamic' => 'dynamic',
        'dynamic_process' => 'dynamic_process'
    ];

    /**
     * Required keys in the all response's from the server
     */
    const REQUIRED_KEYS = [
        'version',
        'id',
        'ts',
        'type'
    ];

    /**
     * @var string The API version that generated the response
     */
    public $version;

    /**
     * @var string The unique identifier of the response
     */
    public $id;

    /**
     * @var string The timestamp of when the response was created by the API server
     */
    public $ts;

    /**
     * @var string The type of data included in this response, see constant RESPONSE_TYPES
     */
    public $type;

    /**
     * @var array The particular response data according to the type specified
     */
    public $responseData;

    /**
     * @var Response Guzzle response object passed into constructor
     */
    private $guzzleResponse;

    /**
     * Parses all responses from the server and throws an exception if any error occurred.
     *
     * @param Response $guzzleResponse The entire Guzzle HTTP Response from the request
     *
     * @throws SmartwaiverSDKException
     */
    public function __construct(Response $guzzleResponse)
    {
        // Save the guzzle response in case an advanced user wants to access it
        $this->guzzleResponse = $guzzleResponse;

        // Save the response contents (because it's a stream that can't be re-read)
        $this->guzzleBody = $guzzleResponse->getBody()->getContents();

        // Decode the JSON response
        $content = json_decode($this->guzzleBody, true);

        // This will be true if there is no JSON to parse or if PHP cannot parse the
        // given JSON
        if($content == null)
        {
            throw new SmartwaiverSDKException(
                $guzzleResponse,
                $this->guzzleBody,
                'Malformed JSON response from API server'
            );
        }

        // Check that all required key's exist in the response
        foreach(self::REQUIRED_KEYS as $key) {
            if(!array_key_exists($key, $content))
                throw new SmartwaiverSDKException(
                    $guzzleResponse,
                    $this->guzzleBody,
                    'API server response missing expected field: '.$key
                );
        }

        // Pull out generic response information
        $this->version = $content['version'];
        $this->id = $content['id'];
        $this->ts = $content['ts'];
        $this->type = $content['type'];

        // Check HTTP response code for problems
        $success = [200, 201];
        $error = [400, 401, 402, 404, 405, 406, 500];
        $rateLimit = 429;
        if(in_array($guzzleResponse->getStatusCode(), $success)) {
            // Check that the response type is in our type mappings
            if(array_key_exists($this->type, self::RESPONSE_TYPES)) {
                // Check that the data field is there
                if(array_key_exists($this->type, $content))
                    $this->responseData = $content[$this->type];
                else
                    throw new SmartwaiverSDKException(
                        $guzzleResponse,
                        $this->guzzleBody,
                        'JSON response does not contain field of type: "' . $this->type . '"'
                    );
            }
            else {
                throw new SmartwaiverSDKException(
                    $guzzleResponse,
                    $this->guzzleBody,
                    'JSON response contains unknown type: "' . $this->type . '"'
                );
            }
        }
        else if($guzzleResponse->getStatusCode() == $rateLimit) {
            if(array_key_exists('rate_limit', $content) &&
                array_key_exists('requests', $content['rate_limit']) &&
                array_key_exists('max', $content['rate_limit']) &&
                array_key_exists('retryAfter', $content['rate_limit']))
            {
                throw new SmartwaiverRateLimitException($guzzleResponse, $this->guzzleBody, $content);
            } else {
                throw new SmartwaiverSDKException(
                    $guzzleResponse,
                    $this->guzzleBody,
                    'Malformed rate limit response'
                );
            }
        }
        else if(in_array($guzzleResponse->getStatusCode(), $error)) {
            // Check that a message exists
            if(array_key_exists('message', $content))
                throw new SmartwaiverHTTPException($guzzleResponse, $this->guzzleBody, $content);
            // If not, throw an error, this is unexpected
            else
                throw new SmartwaiverSDKException(
                    $guzzleResponse,
                    $this->guzzleBody,
                    'Error response does not include message'
                );
        }
        else {
            // Unknown response from the API server, throw an exception
            throw new SmartwaiverSDKException(
                $guzzleResponse,
                $this->guzzleBody,
                'Unknown HTTP code returned: ' . $guzzleResponse->getStatusCode()
            );
        }
    }

    /**
     * Get the actual Guzzle response object that underlies the data in this
     * response object. Note that the body will be empty because it is read by
     * this class's constructor. If you need the body, call getGuzzleBody()
     *
     * @return Response The underlying Guzzle response object
     */
    public function getGuzzleResponse()
    {
        return $this->guzzleResponse;
    }

    /**
     * Access the body of the guzzle response. This is provided since the body
     * is a stream that will be empty in the $guzzleResponse object.
     *
     * @return string
     */
    public function getGuzzleBody()
    {
        return $this->guzzleBody;
    }
}