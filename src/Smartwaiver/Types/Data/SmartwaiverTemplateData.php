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

namespace Smartwaiver\Types\Data;

use Smartwaiver\Types\SmartwaiverInputType;

/**
 * Class SmartwaiverTemplateData
 *
 * This class the settings for the body section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Data
 */
class SmartwaiverTemplateData implements SmartwaiverInputType
{
    /**
     * @var boolean True if this data is for an adult waiver or false for a minor waiver
     */
    public $adult;

    /**
     * @var array An array of participants that are on the waiver
     */
    protected $participants;

    /**
     * @var
     */
    protected $guardian;

    /**
     * Add a participant to the end of the participant array. First Name and Last Name are required, everything else is
     * optional.
     *
     * @param string $firstName  The first name of the participant
     * @param string $lastName  The last name of the participant
     * @param string|null $middleName  The middle name of the participant
     * @param string|null $phone  The phone number of the participant
     * @param string|null $gender  The gender of the participant
     * @param string|null $dob  The DOB of the participant in ISO 8601 format.
     */
    public function addParticipant($firstName, $lastName, $middleName = null, $phone = null, $gender = null, $dob = null) {
        if ($firstName != '' && $lastName != '') {
            $participant = [
                'firstName' => $firstName,
                'lastName' => $lastName
            ];

            if (!is_null($middleName) && $middleName != '') {
                $participant['middleName'] = $middleName;
            }

            if (!is_null($phone) && $phone != '') {
                $participant['phone'] = $phone;
            }

            if (!is_null($gender) && $gender != '') {
                $participant['gender'] = $gender;
            }

            if (!is_null($dob) && $dob != '') {
                $participant['dob'] = $dob;
            }

            if (!isset($this->participants) || is_array($this->participants)) $this->participants = [];
            array_push($this->participants, $participant);
        }
    }

    /**
     * Set prefill data for the guardian
     *
     * @param string $firstName  The first name of the guardian
     * @param string $lastName  The last name of the guardian
     * @param string|null $middleName  The middle name of the guardian
     * @param string|null $relationship  The relationship of the guardian to the minor
     * @param string|null $phone  The phone number of the guardian
     * @param string|null $gender  The gender of the guardian
     * @param string|null $dob  The DOB of the guardian
     * @param boolean|null $participant  Whether the guardian is also a participant or not
     */
    public function setGuardian($firstName, $lastName, $middleName = null, $relationship = null, $phone = null, $gender = null, $dob = null, $participant = null) {
        if ($firstName != '' && $lastName != '') {
            $this->guardian = [
                'firstName' => $firstName,
                'lastName' => $lastName
            ];

            if (!is_null($middleName) && $middleName != '') {
                $this->guardian['middleName'] = $middleName;
            }

            if (!is_null($relationship) && $relationship != '') {
                $this->guardian['relationship'] = $relationship;
            }

            if (!is_null($phone) && $phone != '') {
                $this->guardian['phone'] = $phone;
            }

            if (!is_null($gender) && $gender != '') {
                $this->guardian['gender'] = $gender;
            }

            if (!is_null($dob) && $dob != '') {
                $this->guardian['dob'] = $dob;
            }

            if (!is_null($participant)) {
                $this->guardian['participant'] = $participant ? true : false;
            }
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Adult
        if (isset($this->adult)) {
            $ret['adult'] = $this->adult;
        }

        // Participants
        if (isset($this->participants) && is_array($this->participants) && count($this->participants) > 0) {
            $ret['participants'] = $this->participants;
        }

        // Guardian
        if (isset($this->guardian)) {
            $ret['guardian'] = $this->guardian;
        }

        return $ret;
    }
}
