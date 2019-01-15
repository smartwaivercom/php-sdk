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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

use Smartwaiver\Exceptions\SmartwaiverSDKException;
use Smartwaiver\Types\Data\SmartwaiverTemplateData;
use Smartwaiver\Types\SmartwaiverDynamicProcess;
use Smartwaiver\Types\SmartwaiverDynamicTemplate;
use Smartwaiver\Types\SmartwaiverPhotos;
use Smartwaiver\Types\SmartwaiverSearch;
use Smartwaiver\Types\SmartwaiverSignatures;
use Smartwaiver\Types\SmartwaiverTemplate;
use Smartwaiver\Types\SmartwaiverWaiver;
use Smartwaiver\Types\SmartwaiverWaiverSummary;
use Smartwaiver\Types\SmartwaiverWebhook;
use Smartwaiver\Types\Template\SmartwaiverTemplateConfig;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueue;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueues;

/**
 * Main class, which provides basic methods to interact with Smartwaiver API.
 *
 */
class Smartwaiver
{
    /**
     * Version of this SDK
     */
    const VERSION = '4.3.1';

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
     * @param integer $limit Limit to this number of the most recent waivers.
     * @param boolean|null $verified Limit to waivers that have been verified by email (true), not verified (false), or both (null).
     * @param string $templateId Limit to waivers of the given waiver template ID.
     * @param string $fromDts Limit to waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter).
     * @param string $toDts Limit to waivers between fromDts and this ISO 8601 date (requires fromDts parameter).
     * @param string $firstName Limit to waivers with any participant having this for a first name (Case Insensitive).
     * @param string $lastName Limit to waivers with any participant having this for a last name (Case Insensitive).
     * @param string $tag Limit to waivers with this primary tag.
     *
     * @return SmartwaiverWaiverSummary[] The list of signed waiver summary objects
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverSummaries($limit = 20, $verified = null,
                                       $templateId = '', $fromDts = '',
                                       $toDts = '', $firstName = '',
                                       $lastName = '', $tag = '')
    {
        $url = SmartwaiverRoutes::getWaiverSummaries($limit, $verified,
            $templateId, $fromDts, $toDts, $firstName, $lastName, $tag);
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
     * Retrieve all waiver photos for the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return SmartwaiverPhotos The photos object containing all the photos
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverPhotos($waiverId)
    {
        $url = SmartwaiverRoutes::getWaiverPhotos($waiverId);
        $this->sendGetRequest($url);

        // Return the retrieved waiver
        try
        {
            return new SmartwaiverPhotos($this->lastResponse->responseData);
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
     * Retrieve all drawn signatures for the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return SmartwaiverSignatures The signatures object containing all the signatures
     *
     * @throws SmartwaiverSDKException
     */
    public function getWaiverSignatures($waiverId)
    {
        $url = SmartwaiverRoutes::getWaiverSignatures($waiverId);
        $this->sendGetRequest($url);

        // Return the retrieved waiver
        try
        {
            return new SmartwaiverSignatures($this->lastResponse->responseData);
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
     * Perform a large search matching the given criteria. This will return a
     * guid that can then be used to access the results of the search.
     *
     * @param string $templateId Limit to waivers of the given waiver template ID.
     * @param string $fromDts Limit to waivers after this ISO 8601 date.
     * @param string $toDts Limit to waivers before this ISO 8601 date.
     * @param string $firstName Limit to waivers with any participant having this for a first name (Case Insensitive).
     * @param string $lastName Limit to waivers with any participant having this for a last name (Case Insensitive).
     * @param boolean|null $verified Limit to waivers that have been verified by email (true), not verified (false) or both (null).
     * @param boolean $sortDesc Sort results in descending (latest signed waiver first) order.
     * @param string $tag Limit to waivers with this primary tag.
     *
     * @return SmartwaiverSearch The object representing the results of the search
     *
     * @throws SmartwaiverSDKException
     */
    public function search($templateId = '', $fromDts = '', $toDts = '',
                           $firstName = '', $lastName = '',
                           $verified = null, $sortDesc = true, $tag = '')
    {
        $url = SmartwaiverRoutes::search($templateId, $fromDts, $toDts,
            $firstName, $lastName, $verified, $sortDesc, $tag);
        $this->sendGetRequest($url);

        try
        {
            // Return the results of the search
            return new SmartwaiverSearch($this->lastResponse->responseData);
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
     * Retrieve a page of the given search.
     *
     * @param SmartwaiverSearch     $search     The search object to get the results of
     * @param int                   $page       The page number to retrieve
     *
     * @return SmartwaiverWaiver[] A list of the waiver objects in the given page
     *
     * @throws SmartwaiverSDKException
     */
    public function searchResult(SmartwaiverSearch $search, $page)
    {
        $url = SmartwaiverRoutes::searchResults($search->guid, $page);
        $this->sendGetRequest($url);

        try
        {
            // Map array data from API JSON response to SmartwaiverWaiver objects
            $waivers = array_map(function ($data) {
                return new SmartwaiverWaiver($data);
            }, $this->lastResponse->responseData);

            return $waivers;
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
     * Retrieve a page of the given search.
     *
     * @param string    $guid   The guid of the search results
     * @param int       $page   The page number to retrieve
     *
     * @return SmartwaiverWaiver[] A list of the waiver objects in the given page
     *
     * @throws SmartwaiverSDKException
     */
    public function searchResultByGuid($guid, $page)
    {
        $url = SmartwaiverRoutes::searchResults($guid, $page);
        $this->sendGetRequest($url);

        try
        {
            // Map array data from API JSON response to SmartwaiverWaiver objects
            $waivers = array_map(function ($data) {
                return new SmartwaiverWaiver($data);
            }, $this->lastResponse->responseData);

            return $waivers;
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
     * Delete the current webhook configuration for the account
     */
    public function deleteWebhookConfig()
    {
        $url = SmartwaiverRoutes::deleteWebhookConfig();
        $this->sendDeleteRequest($url);
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
     * Retrieve the current message counts for all webhook queues enabled
     *
     * @return SmartwaiverWebhookQueues  The status information for all queues
     *
     * @throws SmartwaiverSDKException
     */
    public function getWebhookQueues()
    {
        $url = SmartwaiverRoutes::getWebhookQueues();
        $this->sendGetRequest($url);

        try
        {
            // Return the retrieved webhook queues
            return new SmartwaiverWebhookQueues($this->lastResponse->responseData);
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
     * Retrieve a message from the webhook account queue
     *
     * @param bool $delete  Whether to delete the message as it's retrieved
     *
     * @return SmartwaiverWebhookMessage|null  A message from the account queue
     *
     * @throws SmartwaiverSDKException
     */
    public function getWebhookQueueAccountMessage($delete = false)
    {
        $url = SmartwaiverRoutes::getWebhookQueueAccountMessage($delete);
        $this->sendGetRequest($url);

        // No messages
        if (is_null($this->lastResponse->responseData)) {
            return null;
        }

        try
        {
            // Return the retrieved webhook message
            return new SmartwaiverWebhookMessage($this->lastResponse->responseData);
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
     * Retrieve a message from a webhook template queue
     *
     * @param string $templateId  The template ID to retrieve the message from
     * @param bool $delete  Whether to delete the message as it's retrieved
     *
     * @return SmartwaiverWebhookMessage  A message from the template queue
     *
     * @throws SmartwaiverSDKException
     */
    public function getWebhookQueueTemplateMessage($templateId, $delete = false)
    {
        $url = SmartwaiverRoutes::getWebhookQueueTemplateMessage($templateId, $delete);
        $this->sendGetRequest($url);

        // No messages
        if (is_null($this->lastResponse->responseData)) {
            return null;
        }

        try
        {
            // Return the retrieved webhook message
            return new SmartwaiverWebhookMessage($this->lastResponse->responseData);
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
     * Delete a message from the webhook account queue
     *
     * @param string $messageId  The message to delete from the queue
     *
     * @return SmartwaiverWebhookMessageDelete  Whether the message was deleted
     *
     * @throws SmartwaiverSDKException
     */
    public function deleteWebhookQueueAccountMessage($messageId)
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueAccountMessage($messageId);
        $this->sendDeleteRequest($url);

        try
        {
            // Return the retrieved webhook message
            return new SmartwaiverWebhookMessageDelete($this->lastResponse->responseData);
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
     * Delete a message from a webhook template queue
     *
     * @param string $templateId  The template ID to retrieve the message from
     * @param string $messageId  The message to delete from the queue
     *
     * @return SmartwaiverWebhookMessageDelete  Whether the message was deleted
     *
     * @throws SmartwaiverSDKException
     */
    public function deleteWebhookQueueTemplateMessage($templateId, $messageId)
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueTemplateMessage($templateId, $messageId);
        $this->sendDeleteRequest($url);

        try
        {
            // Return the retrieved webhook message
            return new SmartwaiverWebhookMessageDelete($this->lastResponse->responseData);
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
     * Create a dynamic template for your participant to fill out
     *
     * @param SmartwaiverTemplateConfig $templateConfig The config for display of the dyanamic template
     * @param SmartwaiverTemplateData $data The data to fill on the dynamic template
     * @param integer $expiration The expiration of the dynamic template
     *
     * @return SmartwaiverDynamicTemplate An object representing your new dynamic template
     *
     * @throws SmartwaiverSDKException
     */
    public function createDynamicTemplate(SmartwaiverTemplateConfig $templateConfig,
                                          SmartwaiverTemplateData $data,
                                          $expiration)
    {
        // Send the request and process the response
        $this->sendPostRequest(SmartwaiverRoutes::createDynamicTemplate(), [
            'dynamic' => [
                'expiration' => $expiration,
                'template' => $templateConfig->apiArray(),
                'data' => $data->apiArray()
            ]
        ]);

        try
        {
            // Return info about the newly created dynamic template
            return new SmartwaiverDynamicTemplate($this->lastResponse->responseData);
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
     * Create a dynamic template for your participant to fill out
     *
     * @param string $transactionId The transaction ID you are requesting processing of
     *
     * @return SmartwaiverDynamicProcess An object representing info about your processed waiver
     *
     * @throws SmartwaiverSDKException
     */
    public function processDynamicTemplate($transactionId)
    {
        // Send the request and process the response
        $this->sendPostRequest(SmartwaiverRoutes::processDynamicTemplate($transactionId), []);

        try
        {
            // Return info about the newly created dynamic template
            return new SmartwaiverDynamicProcess($this->lastResponse->responseData);
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
     * @param integer $limit Limit to this number of the most recent waivers.
     * @param boolean|null $verified Limit to waivers that have been verified by email (true), not verified (false), or both (null).
     * @param string $templateId Limit to waivers of the given waiver template ID.
     * @param string $fromDts Limit to waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter).
     * @param string $toDts Limit to waivers between fromDts and this ISO 8601 date (requires fromDts parameter).
     * @param string $firstName Limit to waivers with any participant having this for a first name (Case Insensitive).
     * @param string $lastName Limit to waivers with any participant having this for a last name (Case Insensitive).
     * @param string $tag Limit to waivers with this primary tag.
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverSummariesRaw($limit = 20, $verified = null,
                                          $templateId = '', $fromDts = '',
                                          $toDts = '', $firstName = '',
                                          $lastName = '', $tag = '')
    {
        $url = SmartwaiverRoutes::getWaiverSummaries($limit, $verified,
            $templateId, $fromDts, $toDts, $firstName, $lastName, $tag);
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
     * Retrieve all photos attached to the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverPhotosRaw($waiverId)
    {
        $url = SmartwaiverRoutes::getWaiverPhotos($waiverId);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve all drawn signatures attached to the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWaiverSignaturesRaw($waiverId)
    {
        $url = SmartwaiverRoutes::getWaiverSignatures($waiverId);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Perform a large search matching the given criteria. This will return a
     * guid that can then be used to access the results of the search.
     *
     * @param string $templateId Limit to waivers of the given waiver template ID.
     * @param string $fromDts Limit to waivers after this ISO 8601 date.
     * @param string $toDts Limit to waivers before this ISO 8601 date.
     * @param string $firstName Limit to waivers with any participant having this for a first name (Case Insensitive).
     * @param string $lastName Limit to waivers with any participant having this for a last name (Case Insensitive).
     * @param boolean|null $verified Limit to waivers that have been verified by email (true), not verified (false) or both (null).
     * @param boolean $sortDesc Sort results in descending (latest signed waiver first) order.
     * @param string $tag Limit to waivers with this primary tag.
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function searchRaw($templateId = '', $fromDts = '', $toDts = '',
                              $firstName = '', $lastName = '',
                              $verified = null, $sortDesc = true, $tag = '')
    {
        $url = SmartwaiverRoutes::search($templateId, $fromDts, $toDts,
            $firstName, $lastName, $verified, $sortDesc, $tag);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve a page of the given search.
     *
     * @param string    $guid   The guid of the search results
     * @param int       $page   The page number to retrieve
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function searchResultByGuidRaw($guid, $page)
    {
        $url = SmartwaiverRoutes::searchResults($guid, $page);
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
     * Delete the current webhook configuration for the account
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function deleteWebhookConfigRaw()
    {
        $url = SmartwaiverRoutes::deleteWebhookConfig();
        return $this->sendRawDeleteRequest($url);
    }

    /**
     * Retrieve the current message counts for all webhook queues enabled
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWebhookQueuesRaw()
    {
        $url = SmartwaiverRoutes::getWebhookQueues();
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve a message from the webhook account queue
     *
     * @param bool $delete  Whether to delete the message as it's retrieved
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWebhookQueueAccountMessageRaw($delete = false)
    {
        $url = SmartwaiverRoutes::getWebhookQueueAccountMessage($delete);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Retrieve a message from a webhook template queue
     *
     * @param string $templateId  The template ID to retrieve the message from
     * @param bool $delete  Whether to delete the message as it's retrieved
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function getWebhookQueueTemplateMessageRaw($templateId, $delete = false)
    {
        $url = SmartwaiverRoutes::getWebhookQueueTemplateMessage($templateId, $delete);
        return $this->sendRawGetRequest($url);
    }

    /**
     * Delete a message from the webhook account queue
     *
     * @param string $messageId  The message to delete from the queue
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function deleteWebhookQueueAccountMessageRaw($messageId)
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueAccountMessage($messageId);
        return $this->sendRawDeleteRequest($url);
    }

    /**
     * Delete a message from a webhook template queue
     *
     * @param string $templateId  The template ID to retrieve the message from
     * @param string $messageId  The message to delete from the queue
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    public function deleteWebhookQueueTemplateMessageRaw($templateId, $messageId)
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueTemplateMessage($templateId, $messageId);
        return $this->sendRawDeleteRequest($url);
    }

    /**
     * Create a dynamic template for your participant to fill out
     *
     * @param SmartwaiverTemplateConfig $templateConfig The config for display of the dyanamic template
     * @param SmartwaiverTemplateData $data The data to fill on the dynamic template
     * @param integer $expiration The expiration of the dynamic template
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     *
     * @throws SmartwaiverSDKException
     */
    public function createDynamicTemplateRaw(SmartwaiverTemplateConfig $templateConfig,
                                             SmartwaiverTemplateData $data,
                                             $expiration)
    {
        // Send the request and return the response
        return $this->sendRawPostRequest(SmartwaiverRoutes::createDynamicTemplate(), [
            'dynamic' => [
                'expiration' => $expiration,
                'template' => $templateConfig->apiArray(),
                'data' => $data->apiArray()
            ]
        ]);
    }

    /**
     * Create a dynamic template for your participant to fill out
     *
     * @param string $transactionId The transaction ID you are requesting processing of
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     *
     * @throws SmartwaiverSDKException
     */
    public function processDynamicTemplateRaw($transactionId)
    {
        // Send the request and return the response
        return $this->sendRawPostRequest(SmartwaiverRoutes::processDynamicTemplate($transactionId), []);
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

    /**
     * Send a POST request to the given URL, process the response with a
     * SmartwaiverResponse object and set that to $this->lastResponse.
     *
     * @param string $url  The route to send the POST request to
     * @param array $data  The data for the POST request
     *
     * @throws SmartwaiverSDKException
     */
    private function sendPostRequest($url, $data)
    {
        // Send the request and process the response
        try {
            $guzzleResponse = $this->client->request('POST', $url, ['json' => $data]);
        } catch (GuzzleException $e) {
            throw new SmartwaiverSDKException(
                null,
                '',
                $e->getMessage(),
                1
            );
        }
        $response = new SmartwaiverResponse($guzzleResponse);
        $this->lastResponse = $response;
    }

    /**
     * Send a POST request to the given URL and send back the raw response.
     *
     * @param string $url  The route to send the POST request to
     * @param array $data  The data for the POST request
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     *
     * @throws SmartwaiverSDKException
     */
    private function sendRawPostRequest($url, $data)
    {
        // Send the request and process the response
        try {
            $guzzleResponse = $this->client->request('POST', $url, ['json' => $data]);
        } catch (GuzzleException $e) {
            throw new SmartwaiverSDKException(
                null,
                '',
                $e->getMessage(),
                1
            );
        }

        // Return the status code and body of the response
        return new SmartwaiverRawResponse($guzzleResponse);
    }

    /**
     * Send a DELETE request to the given URL, process the response with a
     * SmartwaiverResponse object and set that to $this->lastResponse.
     *
     * @param string $url The route to send the DELETE request to
     */
    private function sendDeleteRequest($url)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request('DELETE', $url);
        $this->lastResponse = new SmartwaiverResponse($guzzleResponse);
    }

    /**
     * Send a DELETE request to the given URL and send back the raw response.
     *
     * @param string $url The route to send the DELETE request to
     *
     * @return SmartwaiverRawResponse An object that holds the status code and
     * unprocessed json.
     */
    private function sendRawDeleteRequest($url)
    {
        // Send the request and process the response
        $guzzleResponse = $this->client->request('DELETE', $url);

        // Return the status code and body of the response
        return new SmartwaiverRawResponse($guzzleResponse);
    }
}
