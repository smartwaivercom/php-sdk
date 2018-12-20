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
 * Class SmartwaiverTemplateParticipants
 *
 * This class the settings for the participants section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateParticipants extends SmartwaiverType implements SmartwaiverInputType
{
    const PARTICIPANT_PHONE_ADULTS = 'adults';
    const PARTICIPANT_PHONE_ADULTS_AND_MINORS = 'adultsAndMinors';

    const PARTICIPANT_DOB_SELECT = 'select';
    const PARTICIPANT_DOB_CHECKBOX = 'checkbox';

    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var boolean Whether adults are enabled
     */
    public $adults;

    /**
     * @var boolean Whether minors are enabled
     */
    public $minorsEnabled;

    /**
     * @var boolean Whether multiple minors are allowed
     */
    public $multipleMinors;

    /**
     * @var boolean If minors are enabled, whether minors without adults are allowed
     */
    public $minorsWithoutAdults;

    /**
     * @var boolean If minors and adults are enabled, whether both are allowed
     */
    public $adultsAndMinors;

    /**
     * @var integer The age of majority between minors and adults
     */
    public $ageOfMajority;

    /**
     * @var string Override the default label for participant's
     */
    public $participantLabel;

    /**
     * @var string Override the default text for selecting who will be participating
     */
    public $participatingText;

    /**
     * @var boolean Ask for middle name
     */
    public $middleName;

    /**
     * @var boolean Ask for a phone number from participants (use PARTICIPANT_PHONE_ADULTS or PARTICIPANT_PHONE_ADULTS_AND_MINORS)
     */
    public $phone;

    /**
     * @var boolean Ask for gender
     */
    public $gender;

    /**
     * @var string How to ask for birthday or age of majority verification (use PARTICIPANT_DOB_SELECT or PARTICIPANT_DOB_CHECKBOX)
     */
    public $dobType;

    /**
     * Create a SmartwaiverTemplateParticipants object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $participants  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $participants = [])
    {
        // Check for required keys
        parent::__construct($participants, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Adults
        if (isset($participants['adults'])) {
            $this->adults = $participants['adults'] == true ? true : false;
        }

        // Minors Enabled
        if (isset($participants['minors']) && isset($participants['minors']['enabled'])) {
            $this->minorsEnabled = $participants['minors']['enabled'] == true ? true : false;
        }

        // Multiple Minors
        if (isset($participants['minors']) && isset($participants['minors']['multipleMinors'])) {
            $this->multipleMinors = $participants['minors']['multipleMinors'] == true ? true : false;
        }

        // Minors Without Adults
        if (isset($participants['minors']) && isset($participants['minors']['minorsWithoutAdults'])) {
            $this->minorsWithoutAdults = $participants['minors']['minorsWithoutAdults'] == true ? true : false;
        }

        // Adults And Minors
        if (isset($participants['minors']) && isset($participants['minors']['adultsAndMinors'])) {
            $this->adultsAndMinors = $participants['minors']['adultsAndMinors'] == true ? true : false;
        }

        // Age Of Majority
        if (isset($participants['ageOfMajority']) && is_numeric($participants['ageOfMajority'])) {
            $this->ageOfMajority = intval($participants['ageOfMajority']);
        }

        // Participant Label
        if (isset($participants['participantLabel']) && $participants['participantLabel'] != '') {
            $this->participantLabel = $participants['participantLabel'];
        }

        // Participating Text
        if (isset($participants['participatingText']) && $participants['participatingText'] != '') {
            $this->participatingText = $participants['participatingText'];
        }

        // Config Middle Name
        if (isset($participants['config']) && isset($participants['config']['middleName'])) {
            $this->middleName = $participants['config']['middleName'] == true ? true : false;
        }

        // Config Phone
        if (isset($participants['config']) && isset($participants['config']['phone']) && $participants['config']['phone'] != '') {
            $this->phone = $participants['config']['phone'] == self::PARTICIPANT_PHONE_ADULTS_AND_MINORS
                ? self::PARTICIPANT_PHONE_ADULTS_AND_MINORS : self::PARTICIPANT_PHONE_ADULTS;
        }

        // Config Gender
        if (isset($participants['config']) && isset($participants['config']['gender'])) {
            $this->gender = $participants['config']['gender'] == true ? true : false;
        }

        // Config DOB Type
        if (isset($participants['config']) && isset($participants['config']['dobType']) && $participants['config']['dobType'] != '') {
            $this->dobType = $participants['config']['dobType'] == self::PARTICIPANT_DOB_CHECKBOX
                ? self::PARTICIPANT_DOB_CHECKBOX : self::PARTICIPANT_DOB_SELECT;
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Adults
        if (isset($this->adults)) {
            $ret['adults'] = $this->adults ? true : false;
        }

        // Minors Enabled
        if (isset($this->minorsEnabled)) {
            if (!isset($ret['minors'])) $ret['minors'] = [];
            $ret['minors']['enabled'] = $this->minorsEnabled ? true : false;
        }

        // Multiple Minors
        if (isset($this->multipleMinors)) {
            if (!isset($ret['minors'])) $ret['minors'] = [];
            $ret['minors']['multipleMinors'] = $this->multipleMinors ? true : false;
        }

        // Minors Without Adults
        if (isset($this->minorsWithoutAdults)) {
            if (!isset($ret['minors'])) $ret['minors'] = [];
            $ret['minors']['minorsWithoutAdults'] = $this->minorsWithoutAdults ? true : false;
        }

        // Adults And Minors
        if (isset($this->adultsAndMinors)) {
            if (!isset($ret['minors'])) $ret['minors'] = [];
            $ret['minors']['adultsAndMinors'] = $this->adultsAndMinors ? true : false;
        }

        // Age Of Majority
        if (isset($this->ageOfMajority) && is_numeric($this->ageOfMajority)) {
            $ret['ageOfMajority'] = intval($this->ageOfMajority);
        }

        // Participant Label
        if (isset($this->participantLabel) && $this->participantLabel != '') {
            $ret['participantLabel'] = $this->participantLabel;
        }

        // Participating Text
        if (isset($this->participatingText) && $this->participatingText != '') {
            $ret['participatingText'] = $this->participatingText;
        }

        // Middle Name
        if (isset($this->middleName)) {
            if (!isset($ret['config'])) $ret['config'] = [];
            $ret['config']['middleName'] = $this->middleName ? true : false;
        }

        // Phone
        if (isset($this->phone) && $this->phone != '') {
            if (!isset($ret['config'])) $ret['config'] = [];
            $ret['config']['phone'] = $this->phone;
        }

        // Gender
        if (isset($this->gender)) {
            if (!isset($ret['config'])) $ret['config'] = [];
            $ret['config']['gender'] = $this->gender ? true : false;
        }

        // DOB Type
        if (isset($this->dobType) && $this->dobType != '') {
            if (!isset($ret['config'])) $ret['config'] = [];
            $ret['config']['dobType'] = $this->dobType;
        }

        return $ret;
    }
}
