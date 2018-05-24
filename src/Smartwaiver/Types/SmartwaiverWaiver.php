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
 * Class SmartwaiverWaiver
 *
 * This class represents a waiver response from the API. Fields from the
 * response are placed in public variables.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWaiver extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'waiverId',
        'templateId',
        'title',
        'createdOn',
        'expirationDate',
        'expired',
        'verified',
        'kiosk',
        'firstName',
        'middleName',
        'lastName',
        'dob',
        'isMinor',
        'clientIP',
        'tags',
        'flags',
        'participants',
        'email',
        'marketingAllowed',
        'addressLineOne',
        'addressLineTwo',
        'addressCity',
        'addressState',
        'addressZip',
        'addressCountry',
        'emergencyContactName',
        'emergencyContactPhone',
        'insuranceCarrier',
        'insurancePolicyNumber',
        'driversLicenseNumber',
        'driversLicenseState',
        'customWaiverFields',
        'guardian',
        'photos',
        'pdf'
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
     * @var string Date on which the waiver will expire
     */
    public $expirationDate;

    /**
     * @var boolean Whether this waiver is expired
     */
    public $expired;

    /**
     * @var boolean Whether the waiver has been email verified
     */
    public $verified;

    /**
     * @var boolean Whether the waiver was submitted at a kiosk
     */
    public $kiosk;

    /**
     * @var string The first name of the first participant on the waiver
     */
    public $firstName;

    /**
     * @var string The middle name of the first participant on the waiver
     */
    public $middleName;

    /**
     * @var string The last name of the first participant on the waiver
     */
    public $lastName;

    /**
     * @var string Date of birth of the first participant on the waiver (ISO 8601 format)
     */
    public $dob;

    /**
     * @var boolean Whether the first participant is a minor
     */
    public $isMinor;

    /**
     * @var string IP Address from which the waiver submitted
     */
    public $clientIP;

    /**
     * @var string[] A list of tags for the waiver
     */
    public $tags;

    /**
     * @var SmartwaiverFlag[] A list of flags for the waiver
     */
    public $flags;

    /**
     * @var SmartwaiverParticipant[] A list of participant's
     */
    public $participants;

    /**
     * @var string The email on the waiver
     */
    public $email;

    /**
     * @var boolean Whether the user allows marketing to be sent to their email
     */
    public $marketingAllowed;

    /**
     * @var string The first line of the address on the waiver
     */
    public $addressLineOne;

    /**
     * @var string The second line of the address on the waiver
     */
    public $addressLineTwo;

    /**
     * @var string The city of the address on the waiver
     */
    public $addressCity;

    /**
     * @var string The state of the address on the waiver
     */
    public $addressState;

    /**
     * @var string The zip code of the address on the waiver
     */
    public $addressZip;

    /**
     * @var string The country of the address on the waiver
     */
    public $addressCountry;

    /**
     * @var string The name of the emergency contact on the waiver
     */
    public $emergencyContactName;

    /**
     * @var string The phone number of the emergency contact on the waiver
     */
    public $emergencyContactPhone;

    /**
     * @var string The name of the insurance carrier on the waiver
     */
    public $insuranceCarrier;

    /**
     * @var string The policy number of the insurance on the waiver
     */
    public $insurancePolicyNumber;

    /**
     * @var string The number of the drivers license on the waiver
     */
    public $driversLicenseNumber;

    /**
     * @var string The state of the drivers license on the waiver
     */
    public $driversLicenseState;

    /**
     * @var SmartwaiverCustomField[] Any custom waiver fields on the waiver (numerically indexed array)
     */
    public $customWaiverFields;

    /**
     * @var SmartwaiverCustomField[] Any custom waiver fields on the waiver (associative array)
     */
    public $customWaiverFieldsByGuid;

    /**
     * @var SmartwaiverGuardian If there are only minors on the waiver, this field contains the guardian information
     */
    public $guardian;

    /**
     * @var integer Number of photos attached to this waiver
     */
    public $photos;

    /**
     * @var string Base 64 Encoded string of PDF (Empty if PDF was not requested)
     */
    public $pdf;

    /**
     * Create a SmartwaiverWaiver object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $waiver The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $waiver)
    {
        // Check for required keys
        parent::__construct($waiver, self::REQUIRED_KEYS, self::class);

        // Load the wavier sumamry into public variables
        $this->waiverId = $waiver['waiverId'];
        $this->templateId = $waiver['templateId'];
        $this->title = $waiver['title'];
        $this->createdOn = $waiver['createdOn'];
        $this->expirationDate = $waiver['expirationDate'];
        $this->expired = $waiver['expired'];
        $this->verified = $waiver['verified'];
        $this->kiosk = $waiver['kiosk'];
        $this->firstName = $waiver['firstName'];
        $this->middleName = $waiver['middleName'];
        $this->lastName = $waiver['lastName'];
        $this->dob = $waiver['dob'];
        $this->isMinor = $waiver['isMinor'];
        $this->clientIP = $waiver['clientIP'];
        $this->tags = $waiver['tags'];

        // Check that flags field is an array
        $this->flags = array();
        if(!is_array($waiver['flags']))
            throw new \InvalidArgumentException('Flags field must be an array');
        foreach($waiver['flags'] as $flag) {
            array_push($this->flags, new SmartwaiverFlag($flag));
        }

        // Check that participants is an array and create participant objects
        $this->participants = [];
        if(!is_array($waiver['participants']))
            throw new \InvalidArgumentException('Participants field must be an array');
        if(count($waiver['participants']) < 1)
            throw new \InvalidArgumentException('There must be at least one participant');
        foreach($waiver['participants'] as $waiverParticipant) {
            array_push($this->participants, new SmartwaiverParticipant($waiverParticipant));
        }

        // Load the waiver data
        $this->email = $waiver['email'];
        $this->marketingAllowed = $waiver['marketingAllowed'];
        $this->addressLineOne = $waiver['addressLineOne'];
        $this->addressLineTwo = $waiver['addressLineTwo'];
        $this->addressCity = $waiver['addressCity'];
        $this->addressState = $waiver['addressState'];
        $this->addressZip = $waiver['addressZip'];
        $this->addressCountry = $waiver['addressCountry'];
        $this->emergencyContactName = $waiver['emergencyContactName'];
        $this->emergencyContactPhone = $waiver['emergencyContactPhone'];
        $this->insuranceCarrier = $waiver['insuranceCarrier'];
        $this->insurancePolicyNumber = $waiver['insurancePolicyNumber'];
        $this->driversLicenseNumber = $waiver['driversLicenseNumber'];
        $this->driversLicenseState = $waiver['driversLicenseState'];
        $this->photos = $waiver['photos'];

        // Check that custom waiver fields is an array
        $this->customWaiverFields = array();
        $this->customWaiverFieldsByGuid = array();
        if(!is_array($waiver['customWaiverFields']))
            throw new \InvalidArgumentException('Custom waiver fields must be an array');
        foreach($waiver['customWaiverFields'] as $guid => $customWaiverField) {
            $customWaiverFieldObject = new SmartwaiverCustomField($customWaiverField);
            array_push($this->customWaiverFields, $customWaiverFieldObject);
            $this->customWaiverFieldsByGuid[$guid] = $customWaiverFieldObject;
        }

        // Check that guardian field is not null
        $this->guardian = null;
        if(!is_null($waiver['guardian'])) {
            $this->guardian = new SmartwaiverGuardian($waiver['guardian']);
        }

        $this->pdf = $waiver['pdf'];
    }
}