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
     * @return string The array that can be converted to JSON
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

}