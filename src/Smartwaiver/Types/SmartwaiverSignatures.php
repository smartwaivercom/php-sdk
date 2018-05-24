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
 * Class SmartwaiverSignatures
 *
 * This class represents the data for signatures drawn on a waiver
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverSignatures extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'waiverId',
        'templateId',
        'title',
        'createdOn',
        'signatures'
    ];

    /**
     * @var string UUID of the waiver
     */
    public $waiverId;

    /**
     * @var string UUID of this waiver's template
     */
    public $templateId;

    /**
     * @var string Title of the waiver
     */
    public $title;

    /**
     * @var string Creation date of the waiver
     */
    public $createdOn;

    /**
     * @var string[] A list of the drawn signatures for participants on this waiver (base 64 encoded image strings)
     */
    public $participantSignatures;

    /**
     * @var string[] A list of the drawn signatures for guardians on this waiver (base 64 encoded image strings)
     */
    public $guardianSignatures;

    /**
     * @var string[] A list of the drawn signatures from the body on this waiver (base 64 encoded image strings)
     */
    public $bodySignatures;

    /**
     * @var string[] A list of the drawn initials from the body on this waiver (base 64 encoded image strings)
     */
    public $bodyInitials;

    /**
     * Create a SmartwaiverSignatures object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $signatures  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $signatures)
    {
        // Check for required keys
        parent::__construct($signatures, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->waiverId = $signatures['waiverId'];
        $this->templateId = $signatures['templateId'];
        $this->title = $signatures['title'];
        $this->createdOn = $signatures['createdOn'];

        // Check that signatures is an array and create signatures objects
        $this->signatures = [];
        if(!is_array($signatures['signatures']))
            throw new \InvalidArgumentException('Signatures field must be an array');
        if(!is_array($signatures['signatures']['participants']))
            throw new \InvalidArgumentException('Signatures participants field must be an array');
        if(!is_array($signatures['signatures']['guardian']))
            throw new \InvalidArgumentException('Signatures guardian field must be an array');
        if(!is_array($signatures['signatures']['bodySignatures']))
            throw new \InvalidArgumentException('Signatures bodySignatures field must be an array');
        if(!is_array($signatures['signatures']['bodyInitials']))
            throw new \InvalidArgumentException('Signatures bodyInitials field must be an array');

        $this->participantSignatures = $signatures['signatures']['participants'];
        $this->guardianSignatures = $signatures['signatures']['guardian'];
        $this->bodySignatures = $signatures['signatures']['bodySignatures'];
        $this->bodyInitials = $signatures['signatures']['bodyInitials'];
    }
}