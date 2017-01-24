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
     * @param integer $limit Limit query to this number of the most recent waivers.
     * @param boolean|null $verified Limit query to waivers that have been verified by email (true) or not verified (false). A null parameter will include waivers regardless of verification status.
     * @param string $templateId Limit query to signed waivers of the given waiver template ID.
     * @param string $fromDts Limit query to signed waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter).
     * @param string $toDts Limit query to signed waivers between fromDts and this ISO 8601 date (requires fromDts parameter).
     *
     * @return string The URL to retrieve the information.
     */
    public static function getWaiverSummaries($limit = 20, $verified = null, $templateId = '', $fromDts = '', $toDts = '')
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