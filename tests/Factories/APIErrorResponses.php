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

class APIErrorResponses extends APIResponses
{
    public static function parameter()
    {
        $response = APIResponses::base();
        $response['type'] = 'parameter_error';
        $response['message'] = 'Invalid parameter';
        return json_encode($response);
    }

    public static function unauthorized()
    {
        $response = APIResponses::base();
        $response['type'] = 'auth_error';
        $response['message'] = 'Unauthorized';
        return json_encode($response);
    }

    public static function data()
    {
        $response = APIResponses::base();
        $response['type'] = 'data_error';
        $response['message'] = 'Invalid data';
        return json_encode($response);
    }

    public static function notFound()
    {
        $response = APIResponses::base();
        $response['type'] = 'error';
        $response['message'] = 'Not Found';
        return json_encode($response);
    }

    public static function wrongContentType()
    {
        $response = APIResponses::base();
        $response['type'] = 'error';
        $response['message'] = 'Invalid content type';
        return json_encode($response);
    }

    public static function rateLimit()
    {
        $response = APIResponses::base();
        $response['type'] = 'rate_limit';
        $response['rate_limit'] = [
            'requests' => 101,
            'max' => 100,
            'retryAfter' => 14
        ];
        return json_encode($response);
    }

    public static function server()
    {
        $response = APIResponses::base();
        $response['type'] = 'error';
        $response['message'] = 'Internal server error';
        return json_encode($response);
    }

    public static function noMessage()
    {
        $response = APIResponses::base();
        $response['type'] = 'error';
        return json_encode($response);
    }
}
