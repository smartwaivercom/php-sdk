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
 * Class SmartwaiverGuardian
 *
 * This class represents all the data for the guardian field
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverGuardian extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'firstName',
        'middleName',
        'lastName',
        'phone',
        'relationship'
    ];

    /**
     * @var string The first name of the guardian
     */
    public $firstName;

    /**
     * @var string The middle name of the guardian
     */
    public $middleName;

    /**
     * @var string The last name of the guardian
     */
    public $lastName;

    /**
     * @var string The phone number of the guardian
     */
    public $phone;

    /**
     * @var string The relationship of the guardian to the minors
     */
    public $relationship;

    /**
     * Create a SmartwaiverGuardian object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $guardian  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $guardian)
    {
        // Check for required keys
        parent::__construct($guardian, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->firstName = $guardian['firstName'];
        $this->middleName = $guardian['middleName'];
        $this->lastName = $guardian['lastName'];
        $this->phone = $guardian['phone'];
        $this->relationship = $guardian['relationship'];
    }
}