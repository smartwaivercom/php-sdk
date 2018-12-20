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
 * Class SmartwaiverTemplateElectronicConsent
 *
 * This class the settings for the electronicConsent section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateElectronicConsent extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string The title of the Electronic Consent section
     */
    public $title;

    /**
     * @var string The verbiage of the Electronic Consent section
     */
    public $verbiage;

    /**
     * Create a SmartwaiverTemplateElectronicConsent object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $electronicConsent  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $electronicConsent = [])
    {
        // Check for required keys
        parent::__construct($electronicConsent, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Title
        if (isset($electronicConsent['title']) && $electronicConsent['title'] != '') {
            $this->title = $electronicConsent['title'];
        }

        // Verbiage
        if (isset($electronicConsent['verbiage']) && $electronicConsent['verbiage'] != '') {
            $this->verbiage = $electronicConsent['verbiage'];
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Title
        if (isset($this->title) && $this->title != '') {
            $ret['title'] = $this->title;
        }

        // Verbiage
        if (isset($this->verbiage) && $this->verbiage != '') {
            $ret['verbiage'] = $this->verbiage;
        }

        return $ret;
    }
}
