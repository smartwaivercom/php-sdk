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

namespace Smartwaiver\Types\Template;

use Smartwaiver\Types\SmartwaiverInputType;
use Smartwaiver\Types\SmartwaiverType;

/**
 * Class SmartwaiverTemplateGuardian
 *
 * This class the settings for the guardian section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateGuardian extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string The consent verbiage for the guardian
     */
    public $verbiage;

    /**
     * @var string The addendum to guardian consent verbiage for a participating guardian
     */
    public $verbiageParticipantAddendum;

    /**
     * @var string The label for the guardian section
     */
    public $label;

    /**
     * @var boolean Whether to ask for the relationship to the minor
     */
    public $relationship;

    /**
     * @var boolean Whether to ask for age verification of guardian even if not participating
     */
    public $ageVerification;

    /**
     * Create a SmartwaiverTemplateGuardian object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $guardian  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $guardian = [])
    {
        // Check for required keys
        parent::__construct($guardian, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Verbiage
        if (isset($guardian['verbiage']) && $guardian['verbiage'] != '') {
            $this->verbiage = $guardian['verbiage'];
        }

        // Verbiage Participant Addendum
        if (isset($guardian['verbiageParticipantAddendum']) && $guardian['verbiageParticipantAddendum'] != '') {
            $this->verbiageParticipantAddendum = $guardian['verbiageParticipantAddendum'];
        }

        // Label
        if (isset($guardian['label']) && $guardian['label'] != '') {
            $this->label = $guardian['label'];
        }

        // Relationship
        if (isset($guardian['relationship'])) {
            $this->relationship = $guardian['relationship'] ? true : false;
        }

        // Age Verification
        if (isset($guardian['ageVerification'])) {
            $this->ageVerification = $guardian['ageVerification'] ? true : false;
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Verbiage
        if (isset($this->verbiage) && $this->verbiage != '') {
            $ret['verbiage'] = $this->verbiage;
        }

        // Verbiage Participant Addendum
        if (isset($this->verbiageParticipantAddendum) && $this->verbiageParticipantAddendum != '') {
            $ret['verbiageParticipantAddendum'] = $this->verbiageParticipantAddendum;
        }

        // Label
        if (isset($this->label) && $this->label != '') {
            $ret['label'] = $this->label;
        }

        // Relationship
        if (isset($this->relationship)) {
            $ret['relationship'] = $this->relationship ? true : false;
        }

        // Age Verification
        if (isset($this->ageVerification)) {
            $ret['ageVerification'] = $this->ageVerification ? true : false;
        }

        return $ret;
    }
}
