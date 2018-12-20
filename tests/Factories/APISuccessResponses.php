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

namespace Smartwaiver\Tests\Factories;

/**
 * Class APISuccessResponses
 *
 * @package Smartwaiver\Tests\Factories
 */
class APISuccessResponses extends APIResponses
{
    /**
     * Create a basic template list API response
     *
     * @param int $numTemplates The number of templates to include
     *
     * @return string The JSON response
     */
    public static function templates($numTemplates)
    {
        $response = APIResponses::base();
        $response['type'] = 'templates';
        $response['templates'] = [];
        for($i=0; $i<$numTemplates; $i++)
            array_push($response['templates'], SmartwaiverTypes::createTemplate());
        return json_encode($response);
    }

    /**
     * Create a basic template API response
     *
     * @return string The JSON response
     */
    public static function template()
    {
        return json_encode(APISuccessResponses::templateArray());
    }

    /**
     * Create a basic template API response (Array version)
     *
     * @return array The array that can be converted to JSON
     */
    public static function templateArray()
    {
        $response = APIResponses::base();
        $response['type'] = 'template';
        $response['template'] = SmartwaiverTypes::createTemplate();
        return $response;
    }

    /**
     * Create a basic waiver list API response
     *
     * @param int $numWaivers The number of waivers to include
     *
     * @return string The JSON response
     */
    public static function waivers($numWaivers)
    {
        $response = APIResponses::base();
        $response['type'] = 'waivers';
        $response['waivers'] = [];
        for($i=0; $i<$numWaivers; $i++)
            array_push($response['waivers'], SmartwaiverTypes::createWaiverSummary());
        return json_encode($response);
    }

    /**
     * Create a basic waiver API response
     *
     * @return string The JSON response
     */
    public static function waiver()
    {
        $response = APIResponses::base();
        $response['type'] = 'waiver';
        $response['waiver'] = SmartwaiverTypes::createWaiver();
        return json_encode($response);
    }

    /**
     * Create a basic waiver photos API response
     *
     * @param int $numPhotos The number of photos to include
     *
     * @return string The JSON response
     */
    public static function photos($numPhotos)
    {
        $response = APIResponses::base();
        $response['type'] = 'photos';
        $response['photos'] = SmartwaiverTypes::createPhotos();
        for($i=1; $i<$numPhotos; $i++)
            array_push($response['photos']['photos'], SmartwaiverTypes::createPhoto());
        return json_encode($response);
    }

    /**
     * Create a basic waiver signatures API response
     *
     * @param int $numParticipants The number of participant signatures to include
     * @param int $numBodySignatures The number of boyd signatures to include
     * @param int $numBodyInitials The number of body initials to include
     *
     * @return string The JSON response
     */
    public static function signatures($numParticipants, $numBodySignatures, $numBodyInitials)
    {
        $response = APIResponses::base();
        $response['type'] = 'signatures';
        $response['signatures'] = SmartwaiverTypes::createSignatures();
        for($i=1; $i<$numParticipants; $i++)
            array_push($response['signatures']['participants'], 'BASE64ENCODED');
        for($i=1; $i<$numBodySignatures; $i++)
            array_push($response['signatures']['bodySignatures'], 'BASE64ENCODED');
        for($i=1; $i<$numBodyInitials; $i++)
            array_push($response['signatures']['bodyInitials'], 'BASE64ENCODED');
        return json_encode($response);
    }

    /**
     * Create a basic search API response
     *
     * @param int $numWaivers The number of waivers to include
     *
     * @return string The JSON response
     */
    public static function search($guid, $count, $pageSize)
    {
        $response = APIResponses::base();
        $response['type'] = 'search';
        $response['search'] = [
            'guid' => $guid,
            'count' => $count,
            'pages' => intval(ceil($count / $pageSize)),
            'pageSize' => $pageSize
        ];
        return json_encode($response);
    }

    /**
     * Create a basic search results API response
     *
     * @param int $numWaivers The number of waivers to include
     *
     * @return string The JSON response
     */
    public static function searchResults($numWaivers)
    {
        $response = APIResponses::base();
        $response['type'] = 'search_results';
        $response['search_results'] = [];
        for($i=0; $i<$numWaivers; $i++)
            array_push($response['search_results'], SmartwaiverTypes::createWaiver());
        return json_encode($response);
    }

    /**
     * Create a basic webhook API response
     *
     * @return string The JSON response
     */
    public static function webhooks()
    {
        $response = APIResponses::base();
        $response['type'] = 'webhooks';
        $response['webhooks'] = SmartwaiverTypes::createWebhook();
        return json_encode($response);
    }

    /**
     * Create a basic webhook queues API response
     *
     * @return string The JSON response
     */
    public static function webhookQueues()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_all_queue_message_count';
        $response['api_webhook_all_queue_message_count'] = SmartwaiverTypes::createWebhookQueues();
        return json_encode($response);
    }

    /**
     * Create a webhook queue account message API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueAccountMessage()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_account_message_get';
        $response['api_webhook_account_message_get'] = SmartwaiverTypes::createWebhookMessage();
        return json_encode($response);
    }

    /**
     * Create a webhook queue account message empty API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueAccountMessageNull()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_account_message_get';
        $response['api_webhook_account_message_get'] = null;
        return json_encode($response);
    }

    /**
     * Create a webhook queue template message API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueTemplateMessage()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_template_message_get';
        $response['api_webhook_template_message_get'] = SmartwaiverTypes::createWebhookMessage();
        return json_encode($response);
    }

    /**
     * Create a webhook queue template message empty API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueTemplateMessageNull()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_template_message_get';
        $response['api_webhook_template_message_get'] = null;
        return json_encode($response);
    }

    /**
     * Create a webhook queue account message delete API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueAccountMessageDelete()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_account_message_delete';
        $response['api_webhook_account_message_delete'] = SmartwaiverTypes::createWebhookMessageDelete();
        return json_encode($response);
    }

    /**
     * Create a webhook queue template message delete API response
     *
     * @return string The JSON response
     */
    public static function webhookQueueTemplateMessageDelete()
    {
        $response = APIResponses::base();
        $response['type'] = 'api_webhook_template_message_delete';
        $response['api_webhook_template_message_delete'] = SmartwaiverTypes::createWebhookMessageDelete();
        return json_encode($response);
    }

    /**
     * Create a create dynamic template API response
     *
     * @return string The JSON response
     */
    public static function createDynamicTemplate()
    {
        $response = APIResponses::base();
        $response['type'] = 'dynamic';
        $response['dynamic'] = SmartwaiverTypes::createDynamicTemplate();
        return json_encode($response);
    }

    /**
     * Create a process dynamic template API response
     *
     * @return string The JSON response
     */
    public static function dynamicProcess()
    {
        $response = APIResponses::base();
        $response['type'] = 'dynamic_process';
        $response['dynamic_process'] = SmartwaiverTypes::dynamicProcess();
        return json_encode($response);
    }
}
