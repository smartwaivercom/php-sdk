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
 * Class SmartwaiverTemplate
 *
 * This class represents a waiver template response from the API.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverTemplate extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'templateId',
        'title',
        'publishedVersion',
        'publishedOn',
        'webUrl',
        'kioskUrl',
        'vanityUrls'
    ];

    /**
     * @var string UUID of the waiver template
     */
    public $templateId;

    /**
     * @var string Title of the waiver template
     */
    public $title;

    /**
     * @var string Version of the waiver template
     */
    public $publishedVersion;

    /**
     * @var string Date the waiver template was published (ISO 8601 formatted date)
     */
    public $publishedOn;

    /**
     * @var string URL to access the waiver template
     */
    public $webUrl;

    /**
     * @var string URL to access the kiosk version of the waiver template
     */
    public $kioskUrl;

    /**
     * @var string[] Array of vanity URLs that can be used to access the template
     */
    public $vanityUrls;

    /**
     * Create a SmartwaiverWaiver object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $template An array to create the template object from
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $template)
    {
        // Check for required keys
        parent::__construct($template, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->templateId = $template['templateId'];
        $this->title = $template['title'];
        $this->publishedVersion = $template['publishedVersion'];
        $this->publishedOn = $template['publishedOn'];
        $this->webUrl = $template['webUrl'];
        $this->kioskUrl = $template['kioskUrl'];
        $this->vanityUrls = $template['vanityUrls'];

    }
}