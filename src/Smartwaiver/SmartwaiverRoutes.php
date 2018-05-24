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

/**
 * Class SmartwaiverRoutes
 *
 * This class provides and easy way to create the actual URLs for the routes.
 *
 * @package Smartwaiver
 */
class SmartwaiverRoutes
{
    /**
     * Location of the API server
     */
    const BASE_URI = 'https://api.smartwaiver.com';

    /**
     * URLs for the different routes
     */
    const ROUTE_TEMPLATES = '/v4/templates';
    const ROUTE_WAIVERS = '/v4/waivers';
    const ROUTE_SEARCH = '/v4/search';
    const ROUTE_WEBHOOKS = '/v4/webhooks/configure';

    /**
     * Get the URL to retrieve a list of all waiver templates in the account.
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverTemplates()
    {
        return self::BASE_URI . self::ROUTE_TEMPLATES;
    }

    /**
     * Get the URL to retrieve information about a specific waiver template.
     *
     * @param string $templateId The Unique ID of waiver template to get
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverTemplate($templateId)
    {
        return self::BASE_URI . self::ROUTE_TEMPLATES.'/'.$templateId;
    }

    /**
     * Get the URL to retrieve a list of waiver summaries matching the given criteria.
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
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverSummaries($limit = 20, $verified = null,
                                              $templateId = '', $fromDts = '',
                                              $toDts = '', $firstName = '',
                                              $lastName = '', $tag = '')
    {
        // Always include the limit, default (same as the API) is 20
        $url = self::BASE_URI . self::ROUTE_WAIVERS.'?limit='.urlencode($limit);
        // Add in other parameters
        if(!is_null($verified))
            $url = $url.'&verified='.($verified ? 'true' : 'false');
        if($templateId !== '')
            $url = $url.'&templateId='.urlencode($templateId);
        if($fromDts !== '')
            $url = $url.'&fromDts='.urlencode($fromDts);
        if($toDts !== '')
            $url = $url.'&toDts='.urlencode($toDts);
        if($firstName !== '')
            $url = $url.'&firstName='.urlencode($firstName);
        if($lastName !== '')
            $url = $url.'&lastName='.urlencode($lastName);
        if($tag !== '')
            $url = $url.'&tag='.urlencode($tag);

        return $url;
    }

    /**
     * Get the URL to retrieve a waiver with the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver to retrieve
     * @param bool $pdf Whether to include the Base64 Encoded PDF
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiver($waiverId, $pdf = false)
    {
        $url = self::BASE_URI . self::ROUTE_WAIVERS.'/'.$waiverId;
        $url = $url.'?pdf='.($pdf ? 'true' : 'false');
        return $url;
    }

    /**
     * Get the URL to retrieve all photos attached to the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverPhotos($waiverId)
    {
        $url = self::BASE_URI . self::ROUTE_WAIVERS.'/'.$waiverId.'/photos';
        return $url;
    }

    /**
     * Get the URL to retrieve all drawn signatures attached to the given waiver ID
     *
     * @param string $waiverId The Unique identifier of the waiver
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverSignatures($waiverId)
    {
        $url = self::BASE_URI . self::ROUTE_WAIVERS.'/'.$waiverId.'/signatures';
        return $url;
    }

    /**
     * Get the URL to search for waivers matching the given criteria.
     *
     * @param string $templateId Limit query to signed waivers of the given waiver template ID.
     * @param string $fromDts Limit query to signed waivers after this ISO 8601 date.
     * @param string $toDts Limit query to signed waivers before this ISO 8601 date.
     * @param string $firstName Limit query to signed waivers with any participant having this for a first name (Case Insensitive).
     * @param string $lastName Limit query to signed waivers with any participant having this for a last name (Case Insensitive).
     * @param boolean|null $verified Limit query to waivers that have been verified by email (true), not verified (false) or both (null).
     * @param boolean $sortDesc Sort results in descending (latest signed waiver first) order.
     * @param string $tag Limit to waivers with this primary tag.
     *
     * @return string The URL to retrieve the information.
     */
    public static function search($templateId = '', $fromDts = '', $toDts = '',
                                  $firstName = '', $lastName = '',
                                  $verified = null, $sortDesc = true, $tag = '')
    {
        $url = self::BASE_URI . self::ROUTE_SEARCH;

        $params = [];

        // Add in other parameters
        if($templateId !== '')
            array_push($params, 'templateId='.urlencode($templateId));
        if($fromDts !== '')
            array_push($params, 'fromDts='.urlencode($fromDts));
        if($toDts !== '')
            array_push($params, 'toDts='.urlencode($toDts));
        if($firstName !== '')
            array_push($params, 'firstName='.urlencode($firstName));
        if($lastName !== '')
            array_push($params, 'lastName='.urlencode($lastName));
        if(!is_null($verified))
            array_push($params, 'verified='.($verified ? 'true' : 'false'));
        if(!$sortDesc)
            array_push($params, 'sort=asc');
        if($tag !== '')
            array_push($params, 'tag='.urlencode($tag));

        if(!empty($params))
            $url .= '?' . implode('&', $params);

        return $url;
    }

    /**
     * Get the URL to retrieve a specific page of a search result
     *
     * @param string $guid The guid returned by the search request
     * @param int    $page Which page to retrieve
     *
     * @return string The URL to retrieve the information.
     */
    public static function searchResults($guid, $page)
    {
        return self::BASE_URI . self::ROUTE_SEARCH . '/' . $guid . '/results?page=' . $page;
    }

    /**
     * Get the URL to retrieve the current webhook configuration for the account
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWebhookConfig()
    {
        return self::BASE_URI . self::ROUTE_WEBHOOKS;
    }

    /**
     * Get the URL to set the webhook configuration for this account
     *
     * @return string The URL to retrieve the information.
     */
    public static function setWebhookConfig()
    {
        return self::BASE_URI . self::ROUTE_WEBHOOKS;
    }
}