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
 * Class SmartwaiverTemplateProcessing
 *
 * This class the settings for the processing section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateProcessing extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string The business name for your emails
     */
    public $emailBusinessName;

    /**
     * @var string The reply to for your emails
     */
    public $emailReplyTo;

    /**
     * @var boolean Whether to use custom text in your emails
     */
    public $emailCustomTextEnabled;

    /**
     * @var string Custom text in emails for waivers filled out on the web
     */
    public $emailCustomTextWeb;

    /**
     * @var boolean Enable sending a copy of signed waiver emails
     */
    public $emailCCEnabled;

    /**
     * @var boolean Enable sending a copy of signed waiver emails for waivers on the web
     */
    public $emailCCWebEnabled;

    /**
     * @var array List of email address to send copy of signed waivers to
     */
    public $emailCCEmails;

    /**
     * @var boolean Include the 2D barcode used for check-in in the emails
     */
    public $emailIncludeBarcodes;

    /**
     * Create a SmartwaiverTemplateProcessing object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $processing  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $processing = [])
    {
        // Check for required keys
        parent::__construct($processing, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Email Business Name
        if (isset($processing['emails']) && isset($processing['emails']['businessName'])
                && $processing['emails']['businessName'] != '') {
            $this->emailBusinessName = $processing['emails']['businessName'];
        }

        // Email Reply To
        if (isset($processing['emails']) && isset($processing['emails']['replyTo'])
                && $processing['emails']['replyTo'] != '') {
            $this->emailReplyTo = $processing['emails']['replyTo'];
        }

        // Email Custom Text Enabled
        if (isset($processing['emails']) && isset($processing['emails']['customText'])
                && isset($processing['emails']['customText']['enabled'])) {
            $this->emailCustomTextEnabled = $processing['emails']['customText']['enabled'] == true ? true : false;
        }

        // Email Custom Text Web
        if (isset($processing['emails']) && isset($processing['emails']['customText'])
                && isset($processing['emails']['customText']['web'])
                && $processing['emails']['customText']['web'] != '') {
            $this->emailCustomTextWeb = $processing['emails']['customText']['web'];
        }

        // Email CC Enabled
        if (isset($processing['emails']) && isset($processing['emails']['cc'])
                && isset($processing['emails']['cc']['enabled'])) {
            $this->emailCCEnabled = $processing['emails']['cc']['enabled'] == true ? true : false;
        }

        // Email CC Web Enabled
        if (isset($processing['emails']) && isset($processing['emails']['cc'])
            && isset($processing['emails']['cc']['web'])) {
            $this->emailCCWebEnabled = $processing['emails']['cc']['enabled'] == true ? true : false;
        }

        // Email CC Eamils
        if (isset($processing['emails']) && isset($processing['emails']['cc'])
            && isset($processing['emails']['cc']['emails']) && is_array($processing['emails']['cc']['emails'])) {
            $this->emailCCEmails = $processing['emails']['cc']['emails'];
        }

        // Email Include Barcodes
        if (isset($processing['emails']) && isset($processing['emails']['includeBarcodes'])) {
            $this->emailIncludeBarcodes = $processing['emails']['includeBarcodes'] == true ? true : false;
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Business Name
        if (isset($this->emailBusinessName) && $this->emailBusinessName != '') {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            $ret['emails']['businessName'] = $this->emailBusinessName;
        }

        // Reply To
        if (isset($this->emailReplyTo) && $this->emailReplyTo != '') {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            $ret['emails']['replyTo'] = $this->emailReplyTo;
        }

        // Custom Text Enabled
        if (isset($this->emailCustomTextEnabled)) {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            if (!isset($ret['emails']['customText'])) $ret['emails']['customText'] = [];
            $ret['emails']['customText']['enabled'] = $this->emailCustomTextEnabled;
        }

        // Custom Text Web
        if (isset($this->emailCustomTextWeb) && $this->emailCustomTextWeb != '') {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            if (!isset($ret['emails']['customText'])) $ret['emails']['customText'] = [];
            $ret['emails']['customText']['web'] = $this->emailCustomTextWeb;
        }

        // Email CC Enabled
        if (isset($this->emailCCEnabled)) {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            if (!isset($ret['emails']['cc'])) $ret['emails']['cc'] = [];
            $ret['emails']['cc']['enabled'] = $this->emailCCEnabled;
        }

        // Email CC Web Enabled
        if (isset($this->emailCCWebEnabled)) {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            if (!isset($ret['emails']['cc'])) $ret['emails']['cc'] = [];
            $ret['emails']['cc']['web'] = $this->emailCCWebEnabled;
        }

        // Email CC Emails
        if (isset($this->emailCCEmails)) {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            if (!isset($ret['emails']['cc'])) $ret['emails']['cc'] = [];
            $ret['emails']['cc']['emails'] = $this->emailCCEmails;
        }

        // Include Barcodes
        if (isset($this->emailIncludeBarcodes)) {
            if (!isset($ret['emails'])) $ret['emails'] = [];
            $ret['emails']['includeBarcodes'] = $this->emailIncludeBarcodes;
        }

        return $ret;
    }
}
