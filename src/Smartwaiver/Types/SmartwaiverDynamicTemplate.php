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

namespace Smartwaiver\Types;

/**
 * Class SmartwaiverDynamicTemplate
 *
 * This class represents a newly created dynamic template response.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverDynamicTemplate extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'expiration',
        'uuid',
        'url'
    ];

    /**
     * @var integer Expiration of this template
     */
    public $expiration;

    /**
     * @var string Temporary ID assigned to this template
     */
    public $uuid;

    /**
     * @var string The url used to access this template
     */
    public $url;

    /**
     * Create a SmartwaiverDynamicTemplate object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $dynamicTemplate The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $dynamicTemplate)
    {
        // Check for required keys
        parent::__construct($dynamicTemplate, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->expiration = intval($dynamicTemplate['expiration']);
        $this->uuid = $dynamicTemplate['uuid'];
        $this->url = $dynamicTemplate['url'];
    }
}