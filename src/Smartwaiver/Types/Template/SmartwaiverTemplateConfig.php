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
 * Class SmartwaiverTemplateConfig
 *
 * This class the settings for the config section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateConfig extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var SmartwaiverTemplateMeta The meta section
     */
    public $meta;

    /**
     * @var SmartwaiverTemplateHeader The header section
     */
    public $header;

    /**
     * @var SmartwaiverTemplateBody The body section
     */
    public $body;

    /**
     * @var SmartwaiverTemplateParticipants The participants section
     */
    public $participants;

    /**
     * @var SmartwaiverTemplateStandardQuestions The standard questions section
     */
    public $standardQuestions;

    /**
     * @var SmartwaiverTemplateGuardian The guardian section
     */
    public $guardian;

    /**
     * @var SmartwaiverTemplateElectronicConsent The electronic consent section
     */
    public $electronicConsent;

    /**
     * @var SmartwaiverTemplateStyling The styling section
     */
    public $styling;

    /**
     * @var SmartwaiverTemplateCompletion The completion section
     */
    public $completion;

    /**
     * @var SmartwaiverTemplateSignatures The signatures section
     */
    public $signatures;

    /**
     * @var SmartwaiverTemplateProcessing The processing section
     */
    public $processing;

    /**
     * Create a SmartwaiverTemplateConfig object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $config  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $config = [])
    {
        // Check for required keys
        parent::__construct($config, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Meta
        if (isset($config['meta'])) {
            $this->meta = new SmartwaiverTemplateMeta($config['meta']);
        } else {
            $this->meta = new SmartwaiverTemplateMeta();
        }

        // Header
        if (isset($config['header'])) {
            $this->header = new SmartwaiverTemplateHeader($config['header']);
        } else {
            $this->header = new SmartwaiverTemplateHeader();
        }

        // Body
        if (isset($config['body'])) {
            $this->body = new SmartwaiverTemplateBody($config['body']);
        } else {
            $this->body = new SmartwaiverTemplateBody();
        }

        // Participants
        if (isset($config['participants'])) {
            $this->participants = new SmartwaiverTemplateParticipants($config['participants']);
        } else {
            $this->participants = new SmartwaiverTemplateParticipants();
        }

        // Standard Questions
        if (isset($config['standardQuestions'])) {
            $this->standardQuestions = new SmartwaiverTemplateStandardQuestions($config['standardQuestions']);
        } else {
            $this->standardQuestions = new SmartwaiverTemplateStandardQuestions();
        }

        // Guardian
        if (isset($config['guardian'])) {
            $this->guardian = new SmartwaiverTemplateGuardian($config['guardian']);
        } else {
            $this->guardian = new SmartwaiverTemplateGuardian();
        }

        // Electronic Consent
        if (isset($config['electronicConsent'])) {
            $this->electronicConsent = new SmartwaiverTemplateElectronicConsent($config['electronicConsent']);
        } else {
            $this->electronicConsent = new SmartwaiverTemplateElectronicConsent();
        }

        // Styling
        if (isset($config['styling'])) {
            $this->styling = new SmartwaiverTemplateStyling($config['styling']);
        } else {
            $this->styling = new SmartwaiverTemplateStyling();
        }

        // Completion
        if (isset($config['completion'])) {
            $this->completion = new SmartwaiverTemplateCompletion($config['completion']);
        } else {
            $this->completion = new SmartwaiverTemplateCompletion();
        }

        // Signatures
        if (isset($config['signatures'])) {
            $this->signatures = new SmartwaiverTemplateSignatures($config['signatures']);
        } else {
            $this->signatures = new SmartwaiverTemplateSignatures();
        }

        // Processing
        if (isset($config['processing'])) {
            $this->processing = new SmartwaiverTemplateProcessing($config['processing']);
        } else {
            $this->processing = new SmartwaiverTemplateProcessing();
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Meta
        if (isset($this->meta)) $ret = $this->apiArrayHelper($ret, $this->meta, 'meta');

        // Header
        if (isset($this->header)) $ret = $this->apiArrayHelper($ret, $this->header, 'header');

        // Body
        if (isset($this->body)) $ret = $this->apiArrayHelper($ret, $this->body, 'body');

        // Participants
        if (isset($this->participants)) $ret = $this->apiArrayHelper($ret, $this->participants, 'participants');

        // Standard Questions
        if (isset($this->standardQuestions)) $ret = $this->apiArrayHelper($ret, $this->standardQuestions, 'standardQuestions');

        // Guardian
        if (isset($this->guardian)) $ret = $this->apiArrayHelper($ret, $this->guardian, 'guardian');

        // Electronic Consent
        if (isset($this->electronicConsent)) $ret = $this->apiArrayHelper($ret, $this->electronicConsent, 'electronicConsent');

        // Styling
        if (isset($this->styling)) $ret = $this->apiArrayHelper($ret, $this->styling, 'styling');

        // Completion
        if (isset($this->completion)) $ret = $this->apiArrayHelper($ret, $this->completion, 'completion');

        // Signatures
        if (isset($this->signatures)) $ret = $this->apiArrayHelper($ret, $this->signatures, 'signatures');

        // Processing
        if (isset($this->processing)) $ret = $this->apiArrayHelper($ret, $this->processing, 'processing');

        return $ret;
    }

    /**
     * Helper function to create the full array
     *
     * @param array $apiArray The array to add to
     * @param SmartwaiverInputType $object The object that contains the info we need to add to the api array
     * @param string $key The key to store the object info under in the api array
     *
     * @return array The new api array
     */
    private function apiArrayHelper($apiArray, SmartwaiverInputType $object, $key) {
        $objectApiArray = $object->apiArray();
        if (count($objectApiArray) > 0) {
            $apiArray[$key] = $objectApiArray;
        }
        return $apiArray;
    }
}
