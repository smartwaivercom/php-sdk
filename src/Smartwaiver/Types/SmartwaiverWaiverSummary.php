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
 * Class SmartwaiverWaiverSummary
 *
 * This class represents a waiver summary response from the API. These are
 * found in the waiver list call.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWaiverSummary extends SmartwaiverType
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
        'tags',
        'flags'
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
     * @var string[] A list of tags for the waiver
     */
    public $tags;

    /**
     * @var SmartwaiverFlag[] A list of flags for the waiver
     */
    public $flags;

    /**
     * Create a SmartwaiverWaiverSummary object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $summary  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $summary)
    {
        // Check for required keys
        parent::__construct($summary, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->waiverId = $summary['waiverId'];
        $this->templateId = $summary['templateId'];
        $this->title = $summary['title'];
        $this->createdOn = $summary['createdOn'];
        $this->expirationDate = $summary['expirationDate'];
        $this->expired = $summary['expired'];
        $this->verified = $summary['verified'];
        $this->kiosk = $summary['kiosk'];
        $this->firstName = $summary['firstName'];
        $this->middleName = $summary['middleName'];
        $this->lastName = $summary['lastName'];
        $this->dob = $summary['dob'];
        $this->isMinor = $summary['isMinor'];
        $this->tags = $summary['tags'];

        // Check that flags field is an array
        $this->flags = array();
        if(!is_array($summary['flags']))
            throw new \InvalidArgumentException('Flags field must be an array');
        foreach($summary['flags'] as $flag) {
            array_push($this->flags, new SmartwaiverFlag($flag));
        }
    }

}