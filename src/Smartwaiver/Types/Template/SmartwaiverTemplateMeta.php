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
 * Class SmartwaiverTemplateMeta
 *
 * This class the settings for the meta section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateMeta extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
    /**
     * @var string The title of the template
     */
    public $title;

    /**
     * @var string The language of the template
     */
    public $language;

    /**
     * Create a SmartwaiverTemplateMeta object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $meta  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $meta = [])
    {
        // Check for required keys
        parent::__construct($meta, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Title
        if (isset($meta['title']) && $meta['title'] != '') {
            $this->title = $meta['title'];
        }

        // Locale
        if (isset($meta['locale']) && isset($meta['locale']['locale']) && $meta['locale']['locale'] != '') {
            $this->language = $meta['locale']['locale'];
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

        // Locale
        if (isset($this->language) && $this->language != '') {
            $ret['locale'] =[
                'locale' => $this->language
            ];
        }

        return $ret;
    }
}
