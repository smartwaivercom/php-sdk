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

namespace Smartwaiver;

use GuzzleHttp\Client;
use InvalidArgumentException;

use Smartwaiver\Exceptions\SmartwaiverSDKException;
use Smartwaiver\Types\SmartwaiverTemplate;
use Smartwaiver\Types\SmartwaiverWaiver;
use Smartwaiver\Types\SmartwaiverWaiverSummary;
use Smartwaiver\Types\SmartwaiverWebhook;

/**
 * Class Smartwaiver
 *
 */
class Smartwaiver
{
    /**
     * Version of this SDK
     */
    const VERSION = '4.0.0';

    /**
     * @var Client The Guzzle client used to make requests
     */
    protected $client;

    /**
     * @var SmartwaiverResponse|null The last response from the API server
     */
    protected $lastResponse = null;

    /**
     * Creates a new Smartwaiver object.
     *
     * @param string $apiKey The API Key for the account
     * @param array[] $guzzleOptions Optional options to pass to guzzle client
     */
    public function __construct($apiKey, $guzzleOptions = [])
    {
        // Add passed in Guzzle options
        $options = array_merge(
            [
                // Do not throw exceptions for 4xx HTTP responses
                'http_errors' => false,
                // Default headers
                'headers' => [
                    'User-Agent' => 'SmartwaiverSDK:' . self::VERSION . '-php:' . phpversion(),
                    'sw-api-key' => $apiKey
                ]
            ],
            $guzzleOptions
        );

        // Set up a new Guzzle Client
        $this->client = new Client($options);
    }

    /**
     * Retrieve a list of all waiver templates in the account.
     *
     * @return SmartwaiverTemplate[] An array (may be empty) of SmartwaiverTemplates
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverTemplates()
    {
        $url = SmartwaiverRoutes::getWaiverTemplates();
        $this->sendGetRequest($url);

        try
        {
            // Map array data from API JSON response to a SmartwaiverWaiver object
            $templates = array_map(function ($data) {
                return new SmartwaiverTemplate($data);
            }, $this->lastResponse->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }

        // Return array of retrieved templates
        return $templates;
    }

    /**
     * Retrieve information about a specific waiver template.
     *
     * If the waiver template is not found a NotFoundException will be thrown.
     *
     * @param string $templateId The Unique ID of waiver template to get
     *
     * @return SmartwaiverTemplate The requested template
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverTemplate($templateId)
    {
        $url = SmartwaiverRoutes::getWaiverTemplate($templateId);
        $this->sendGetRequest($url);

        try
        {
            return new SmartwaiverTemplate($this->lastResponse->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }
    }

    /**
     * Retrieve a list of waiver summaries matching the given criteria.
     *
     * @param integer $limit Limit query to this number of the most recent waivers.
     * @param boolean|null $verified Limit query to waivers that have been verified by email (true) or not verified (false). A null parameter will include waivers regardless of verification status.
     * @param string $templateId Limit query to signed waivers of the given waiver template ID.
     * @param string $fromDts Limit query to signed waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter).
     * @param string $toDts Limit query to signed waivers between fromDts and this ISO 8601 date (requires fromDts parameter).
     *
     * @return SmartwaiverWaiverSummary[] The list of signed waiver summary objects
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverSummaries($limit = 20, $verified = null, $templateId = '', $fromDts = '', $toDts = '')
    {
        $url = SmartwaiverRoutes::getWaiverSummaries($limit, $verified, $templateId, $fromDts, $toDts);
        $this->sendGetRequest($url);

        try
        {
            // Map array data from API JSON response to a SmartwaiverWaiver object
            $waivers = array_map(function ($data) {
                return new SmartwaiverWaiverSummary($data);
            }, $this->lastResponse->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }

        // Return the retrieved array of waivers
        return $waivers;
    }

    /**
     * Retrieve a waiver with the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver to retrieve
     * @param boolean $pdf Whether to include the Base64 Encoded PDF
     *
     * @return SmartwaiverWaiver The waiver object corresponding to the given waiver ID
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiver($waiverId, $pdf = false)
    {
        $url = SmartwaiverRoutes::getWaiver($waiverId, $pdf);
        $this->sendGetRequest($url);

        // Return the retrieved waiver
        try
        {
            return new SmartwaiverWaiver($this->lastResponse->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }
    }

    /**
     * Retrieve the current webhook configuration for the account
     *
     * @return SmartwaiverWebhook The current webhook configuration
     *
     * @throws SmartwaiverSDKException Thrown for any error returned by the API
     */
    public function getWebhookConfig()
    {
        $url = SmartwaiverRoutes::getWebhookConfig();
        $this->sendGetRequest($url);

        try
        {
            // Return the retrieved webhook
            return new SmartwaiverWebhook($this->lastResponse->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }
    }

    /**
     * Set the webhook configuration for this account
     *
     * @param string $endpoint A valid url to set as the webhook endpoint
     * @param string $emailValidationRequired Sets when the webhook is fired (use constants from SmartwaiverWebhook).
     *
     * @return SmartwaiverWebhook The new webhook configuration will be returned
     *
     * @throws SmartwaiverSDKException
     */
    public function setWebhookConfig($endpoint, $emailValidationRequired)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request(
            'PUT',
            SmartwaiverRoutes::setWebhookConfig(),
            ['json' =>
                [
                    'endpoint' => $endpoint,
                    'emailValidationRequired' => $emailValidationRequired
                ]
            ]
        );
        $response = new SmartwaiverResponse($guzzleResponse);

        try
        {
            // Return the retrieved webhook
            return new SmartwaiverWebhook($response->responseData);
        }
        catch(InvalidArgumentException $e)
        {
            throw new SmartwaiverSDKException(
                $this->lastResponse->getGuzzleResponse(),
                $this->lastResponse->getGuzzleBody(),
                $e->getMessage()
            );
        }
    }

    /**
     * Set the webhook configuration for this account
     *
     * @param SmartwaiverWebhook $webhook The webhook configuration to set
     *
     * @return SmartwaiverWebhook The new webhook configuration will be returned
     *
     * @throws SmartwaiverSDKException
     */
    public function setWebhook(SmartwaiverWebhook $webhook)
    {
        return $this->setWebhookConfig($webhook->endpoint, $webhook->emailValidationRequired);
    }

    /**
     * Retrieve a list of all waiver templates in the account.
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverTemplatesRaw()
    {
        $url = SmartwaiverRoutes::getWaiverTemplates();
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve information about a specific waiver template.
     *
     * @param string $templateId The Unique ID of waiver template to get
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverTemplateRaw($templateId)
    {
        $url = SmartwaiverRoutes::getWaiverTemplate($templateId);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve a list of waiver summaries matching the given criteria.
     *
     * @param integer $limit Limit query to this number of the most recent waivers.
     * @param boolean|null $verified Limit query to waivers that have been verified by email (true) or not verified (false). A null parameter will include waivers regardless of verification status.
     * @param string $templateId Limit query to signed waivers of the given waiver template ID.
     * @param string $fromDts Limit query to signed waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter).
     * @param string $toDts Limit query to signed waivers between fromDts and this ISO 8601 date (requires fromDts parameter).
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverSummariesRaw($limit = 20, $verified = null, $templateId = '', $fromDts = '', $toDts = '')
    {
        $url = SmartwaiverRoutes::getWaiverSummaries($limit, $verified, $templateId, $fromDts, $toDts);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve a waiver with the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver to retrieve
     * @param boolean $pdf Include the Base64 Encoded PDF
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverRaw($waiverId, $pdf = false)
    {
        $url = SmartwaiverRoutes::getWaiver($waiverId, $pdf);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve the current webhook configuration for the account
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWebhookConfigRaw()
    {
        $url = SmartwaiverRoutes::getWebhookConfig();
        return $this->sendRawGetRequest($url);
    }

    /**
     * Set the webhook configuration for this account
     *
     * @param string $endpoint A valid url to set as the webhook endpoint
     * @param string $emailValidationRequired Sets when the webhook is fired (use constants from SmartwaiverWebhook).
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function setWebhookConfigRaw($endpoint, $emailValidationRequired)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request(
            'PUT',
            SmartwaiverRoutes::setWebhookConfig(),
            ['json' =>
                [
                    'endpoint' => $endpoint,
                    'emailValidationRequired' => $emailValidationRequired
                ]
            ]
        );

        // Return the status code and body of the response
        return new SmartwaiverRawResponse($guzzleResponse);
    }

    /**
     * Get the SmartwaiverResponse objected created for the most recent API
     * request. Useful for error handling if an exception is thrown.
     *
     * @return SmartwaiverResponse|null The last response this object received from the API
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Send a GET request to the given URL, process the response with a
     * SmartwaiverResponse object and set that to $this->lastResponse.
     *
     * @param string $url The route to send the GET request to
     */
    private function sendGetRequest($url)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request('GET', $url);
        $this->lastResponse = new SmartwaiverResponse($guzzleResponse);
    }

    /**
     * Send a GET request to the given URL and send back the raw response.
     *
     * @param string $url The route to send the GET request to
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    private function sendRawGetRequest($url)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request('GET', $url);

        // Return the status code and body of the response
        return new SmartwaiverRawResponse($guzzleResponse);
    }
}
