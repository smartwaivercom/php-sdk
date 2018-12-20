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
 * Class SmartwaiverDynamicProcess
 *
 * This class represents a newly created dynamic template response.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverDynamicProcess extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'transactionId',
        'waiverId'
    ];

    /**
     * @var string The transaction ID that you requested processing of
     */
    public $transactionId;

    /**
     * @var string You're newly created waiver ID
     */
    public $waiverId;

    /**
     * Create a SmartwaiverDynamicProcess object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $dynamicProcess The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $dynamicProcess)
    {
        // Check for required keys
        parent::__construct($dynamicProcess, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->transactionId = $dynamicProcess['transactionId'];
        $this->waiverId = $dynamicProcess['waiverId'];
    }
}