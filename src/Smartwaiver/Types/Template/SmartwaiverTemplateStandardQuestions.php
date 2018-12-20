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
 * Class SmartwaiverTemplateStandardQuestions
 *
 * This class the settings for the standardQuestions section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateStandardQuestions extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var boolean Whether the address is enabled
     */
    public $addressEnabled;

    /**
     * @var boolean Whether the address is required
     */
    public $addressRequired;

    /**
     * @var string The default country on the address
     */
    public $addressDefaultCountry;

    /**
     * @var string The default state on the address
     */
    public $addressDefaultState;

    /**
     * @var boolean Whether email verification is turned on
     */
    public $emailVerification;

    /**
     * @var boolean Whether to show the marketing opt-in checkbox
     */
    public $emailMarketingEnabled;

    /**
     * @var string Text for the marketing opt-in checkbox
     */
    public $emailMarketingOptInText;

    /**
     * @var boolean Default the marketing opt-in checkbox to be checked
     */
    public $emailMarketingDefaultChecked;

    /**
     * @var boolean Whether the emergency contact field is enabled
     */
    public $emergencyContactEnabled;

    /**
     * @var boolean Whether the insurance field is enabled
     */
    public $insuranceEnabled;

    /**
     * @var boolean Whether the ID Card field is enabled
     */
    public $idCardEnabled;

    /**
     * Create a SmartwaiverTemplateStandardQuestions object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $standardQuestions  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $standardQuestions = [])
    {
        // Check for required keys
        parent::__construct($standardQuestions, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Address Enabled
        if (isset($standardQuestions['address']) && isset($standardQuestions['address']['enabled'])) {
            $this->addressEnabled = $standardQuestions['address']['enabled'] == true ? true : false;
        }

        // Address Required
        if (isset($standardQuestions['address']) && isset($standardQuestions['address']['required'])) {
            $this->addressRequired = $standardQuestions['address']['required'] == true ? true : false;
        }

        // Address Default Country
        if (isset($standardQuestions['address']) && isset($standardQuestions['address']['defaults'])
                && isset($standardQuestions['address']['defaults']['country'])
                && $standardQuestions['address']['defaults']['country'] != '') {
            $this->addressDefaultCountry = $standardQuestions['address']['defaults']['country'];
        }

        // Address Default State
        if (isset($standardQuestions['address']) && isset($standardQuestions['address']['defaults'])
                && isset($standardQuestions['address']['defaults']['state'])
                && $standardQuestions['address']['defaults']['state'] != '') {
            $this->addressDefaultState = $standardQuestions['address']['defaults']['state'];
        }

        // Email Verification
        if (isset($standardQuestions['email']) && isset($standardQuestions['email']['verification'])) {
            $this->emailVerification = $standardQuestions['email']['verification'] == true ? true : false;
        }

        // Email Marketing Enabled
        if (isset($standardQuestions['email']) && isset($standardQuestions['email']['marketing'])
                && isset($standardQuestions['email']['marketing']['enabled'])) {
            $this->emailMarketingEnabled = $standardQuestions['email']['marketing']['enabled'] == true ? true : false;
        }

        // Email Marketing Opt In Text
        if (isset($standardQuestions['email']) && isset($standardQuestions['email']['marketing'])
                && isset($standardQuestions['email']['marketing']['optInText'])
                && $standardQuestions['email']['marketing']['optInText'] != '') {
            $this->emailMarketingOptInText = $standardQuestions['email']['marketing']['optInText'];
        }

        // Email Marketing Default Checked
        if (isset($standardQuestions['email']) && isset($standardQuestions['email']['marketing'])
            && isset($standardQuestions['email']['marketing']['defaultChecked'])) {
            $this->emailMarketingDefaultChecked = $standardQuestions['email']['marketing']['defaultChecked'] == true ? true : false;
        }

        // Emergency Contact Enabled
        if (isset($standardQuestions['emergencyContact']) && isset($standardQuestions['emergencyContact']['enabled'])) {
            $this->emergencyContactEnabled = $standardQuestions['emergencyContact']['enabled'] == true ? true : false;
        }

        // Insurance Enabled
        if (isset($standardQuestions['insurance']) && isset($standardQuestions['insurance']['enabled'])) {
            $this->insuranceEnabled = $standardQuestions['insurance']['enabled'] == true ? true : false;
        }

        // ID Card Enabled
        if (isset($standardQuestions['idCard']) && isset($standardQuestions['idCard']['enabled'])) {
            $this->idCardEnabled = $standardQuestions['idCard']['enabled'] == true ? true : false;
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Address Enabled
        if (isset($this->addressEnabled)) {
            if (!isset($ret['address'])) $ret['address'] = [];
            $ret['address']['enabled'] = $this->addressEnabled ? true : false;
        }

        // Address Required
        if (isset($this->addressRequired)) {
            if (!isset($ret['address'])) $ret['address'] = [];
            $ret['address']['required'] = $this->addressRequired ? true : false;
        }

        // Address Default Country
        if (isset($this->addressDefaultCountry) && $this->addressDefaultCountry != '') {
            if (!isset($ret['address'])) $ret['address'] = [];
            if (!isset($ret['address']['defaults'])) $ret['address']['defaults'] = [];
            $ret['address']['defaults']['country'] = $this->addressDefaultCountry;
        }

        // Address Default State
        if (isset($this->addressDefaultState) && $this->addressDefaultState != '') {
            if (!isset($ret['address'])) $ret['address'] = [];
            if (!isset($ret['address']['defaults'])) $ret['address']['defaults'] = [];
            $ret['address']['defaults']['state'] = $this->addressDefaultState;
        }

        // Email Verification
        if (isset($this->emailVerification)) {
            if (!isset($ret['email'])) $ret['email'] = [];
            $ret['email']['verification'] = $this->emailVerification ? true : false;
        }

        // Email Marketing Enabled
        if (isset($this->emailMarketingEnabled)) {
            if (!isset($ret['email'])) $ret['email'] = [];
            if (!isset($ret['email']['marketing'])) $ret['email']['marketing'] = [];
            $ret['email']['marketing']['enabled'] = $this->emailMarketingEnabled ? true : false;
        }

        // Email Marketing Opt In Text
        if (isset($this->emailMarketingOptInText) && $this->emailMarketingOptInText != '') {
            if (!isset($ret['email'])) $ret['email'] = [];
            if (!isset($ret['email']['marketing'])) $ret['email']['marketing'] = [];
            $ret['email']['marketing']['optInText'] = $this->emailMarketingOptInText;
        }

        // Email Marketing Default Checked
        if (isset($this->emailMarketingDefaultChecked)) {
            if (!isset($ret['email'])) $ret['email'] = [];
            if (!isset($ret['email']['marketing'])) $ret['email']['marketing'] = [];
            $ret['email']['marketing']['defaultChecked'] = $this->emailMarketingDefaultChecked ? true : false;
        }

        // Emergency Contact Enabled
        if (isset($this->emergencyContactEnabled)) {
            if (!isset($ret['emergencyContact'])) $ret['emergencyContact'] = [];
            $ret['emergencyContact']['enabled'] = $this->emergencyContactEnabled ? true : false;
        }

        // Insurance Enabled
        if (isset($this->insuranceEnabled)) {
            if (!isset($ret['insurance'])) $ret['insurance'] = [];
            $ret['insurance']['enabled'] = $this->insuranceEnabled ? true : false;
        }

        // ID Card Enabled
        if (isset($this->idCardEnabled)) {
            if (!isset($ret['idCard'])) $ret['idCard'] = [];
            $ret['idCard']['enabled'] = $this->idCardEnabled ? true : false;
        }

        return $ret;
    }
}
