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
 * Class SmartwaiverParticipant
 *
 * This class represents a single participant on a signed waiver.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverParticipant extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'firstName',
        'middleName',
        'lastName',
        'dob',
        'isMinor',
        'gender',
        'phone',
        'tags',
        'customParticipantFields',
        'flags'
    ];

    /**
     * @var string The first name of the participant
     */
    public $firstName;

    /**
     * @var string The middle name of the participant
     */
    public $middleName;

    /**
     * @var string The last name of the participant
     */
    public $lastName;

    /**
     * @var string The date of birth of the participant (ISO 8601 format)
     */
    public $dob;

    /**
     * @var boolean Whether or not this participant is a minor
     */
    public $isMinor;

    /**
     * @var string Gender of the participant
     */
    public $gender;

    /**
     * @var string Phone number of the participant
     */
    public $phone;

    /**
     * @var string[] A list of tags for this participant
     */
    public $tags;

    /**
     * @var SmartwaiverFlag[] A list of flags for this participant
     */
    public $flags;

    /**
     * @var SmartwaiverCustomField[] Any custom participant fields on the waiver (numerically indexed array)
     */
    public $customParticipantFields;

    /**
     * @var SmartwaiverCustomField[] Any custom participant fields on the waiver (associative array)
     */
    public $customParticipantFieldsByGuid;

    /**
     * Create a SmartwaiverParticipant object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $participant The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $participant)
    {
        // Check for required keys
        parent::__construct($participant, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->firstName = $participant['firstName'];
        $this->middleName = $participant['middleName'];
        $this->lastName = $participant['lastName'];
        $this->dob = $participant['dob'];
        $this->isMinor = $participant['isMinor'];
        $this->gender = $participant['gender'];
        $this->phone = $participant['phone'];
        $this->tags = $participant['tags'];

        // Check that custom participant fields is an array
        $this->customParticipantFields = array();
        $this->customParticipantFieldsByGuid = array();
        if(!is_array($participant['customParticipantFields']))
            throw new \InvalidArgumentException('Custom participant fields must be an array');

        // Load the custom participant fields as objects of that type
        foreach($participant['customParticipantFields'] as $guid => $customParticipantField) {
            $customParticipantFieldObject = new SmartwaiverCustomField($customParticipantField);
            array_push($this->customParticipantFields, $customParticipantFieldObject);
            $this->customParticipantFieldsByGuid[$guid] = $customParticipantFieldObject;
        }

        // Check that flag field is an array
        $this->flags = array();
        if(!is_array($participant['flags']))
            throw new \InvalidArgumentException('Flag field must be an array');

        // Load the flags as objects of that type
        foreach($participant['flags'] as $flag) {
            array_push($this->flags, new SmartwaiverFlag($flag));
        }
    }
}