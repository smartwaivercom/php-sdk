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
 * Class APIResponses
 *
 * @package Smartwaiver\Tests\Factories
 */
class APIResponses
{
    /**
     * Create the base response that the API sends
     *
     * @return array
     */
    protected static function base()
    {
        return [
            'version' => 4,
            'id' => 'a0256461ca244278b412ab3238f5efd2',
            'ts' => '2017-01-23T09:15:45.645Z'
        ];
    }
}
