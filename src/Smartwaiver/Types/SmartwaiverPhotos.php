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
 * Class SmartwaiverPhotos
 *
 * This class represents all the data for the photos of a waiver
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverPhotos extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'waiverId',
        'templateId',
        'title',
        'createdOn',
        'photos'
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
     * @var SmartwaiverPhoto[] A list of the photos for this waiver
     */
    public $photos;

    /**
     * Create a SmartwaiverPhotos object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $photos  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $photos)
    {
        // Check for required keys
        parent::__construct($photos, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->waiverId = $photos['waiverId'];
        $this->templateId = $photos['templateId'];
        $this->title = $photos['title'];
        $this->createdOn = $photos['createdOn'];

        // Check that photos is an array and create photo objects
        $this->photos = [];
        if(!is_array($photos['photos']))
            throw new \InvalidArgumentException('Photos field must be an array');
        foreach($photos['photos'] as $photo) {
            array_push($this->photos, new SmartwaiverPhoto($photo));
        }
    }
}