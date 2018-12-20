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
 * Class SmartwaiverTemplateBody
 *
 * This class the settings for the body section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateBody extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string The text of the body
     */
    public $text;

    /**
     * Create a SmartwaiverTemplateBody object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $body  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $body = [])
    {
        // Check for required keys
        parent::__construct($body, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Text
        if (isset($body['text']) && $body['text'] != '') {
            $this->text = $body['text'];
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Text
        if (isset($this->text) && $this->text != '') {
            $ret['text'] = $this->text;
        }

        return $ret;
    }
}
