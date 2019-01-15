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

    /** @var string Data to fill into the address line one */
    public $addressLineOne;

    /** @var string Data to fill into the address line two */
    public $addressLineTwo;

    /** @var string Data to fill into the address country */
    public $addressCountry;

    /** @var string Data to fill into the address city */
    public $addressCity;

    /** @var string Data to fill into the address state */
    public $addressState;

    /** @var string Data to fill into the address zip */
    public $addressZip;

    /** @var string Data to fill into the email */
    public $email;

    /** @var string Data to fill into the emergency contact name */
    public $emergencyContactName;

    /** @var string Data to fill into the emergency contact phone */
    public $emergencyContactPhone;

    /** @var string Data to fill into the insurance carrier */
    public $insuranceCarrier;

    /** @var string Data to fill into the insurance policy number */
    public $insurancePolicyNumber;

    /** @var string Data to fill into the drivers license state */
    public $driversLicenseState;

    /** @var string Data to fill into the drivers license number */
    public $driversLicenseNumber;

    /**
     * @var array An array of participants that are on the waiver
     */
    protected $participants;

    /**
     * @var array An associative array of the guardian information
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

        // Address Line One
        if (isset($this->addressLineOne) && $this->addressLineOne != '') {
            $ret['addressLineOne'] = $this->addressLineOne;
        }

        // Address Line Two
        if (isset($this->addressLineTwo) && $this->addressLineTwo != '') {
            $ret['addressLineTwo'] = $this->addressLineTwo;
        }

        // Address Country
        if (isset($this->addressCountry) && $this->addressCountry != '') {
            $ret['addressCountry'] = $this->addressCountry;
        }

        // Address State
        if (isset($this->addressState) && $this->addressState != '') {
            $ret['addressState'] = $this->addressState;
        }

        // Address Zip
        if (isset($this->addressZip) && $this->addressZip != '') {
            $ret['addressZip'] = $this->addressZip;
        }

        // Email
        if (isset($this->email) && $this->email != '') {
            $ret['email'] = $this->email;
        }

        // Emergency Contact Name
        if (isset($this->emergencyContactName) && $this->emergencyContactName != '') {
            $ret['emergencyContactName'] = $this->emergencyContactName;
        }

        // Emergency Contact Phone
        if (isset($this->emergencyContactPhone) && $this->emergencyContactPhone != '') {
            $ret['emergencyContactPhone'] = $this->emergencyContactPhone;
        }

        // Insurance Carrier
        if (isset($this->insuranceCarrier) && $this->insuranceCarrier != '') {
            $ret['insuranceCarrier'] = $this->insuranceCarrier;
        }

        // Insurance Policy Number
        if (isset($this->insurancePolicyNumber) && $this->insurancePolicyNumber != '') {
            $ret['insurancePolicyNumber'] = $this->insurancePolicyNumber;
        }

        // Driver's License State
        if (isset($this->driversLicenseState) && $this->driversLicenseState != '') {
            $ret['driversLicenseState'] = $this->driversLicenseState;
        }

        // Driver's License Number
        if (isset($this->driversLicenseNumber) && $this->driversLicenseNumber != '') {
            $ret['driversLicenseNumber'] = $this->driversLicenseNumber;
        }

        return $ret;
    }
}
