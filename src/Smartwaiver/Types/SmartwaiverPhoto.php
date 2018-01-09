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
 * Class SmartwaiverPhoto
 *
 * This class represents all the data a single photo on a waiver
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverPhoto extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'type',
        'date',
        'tag',
        'fileType',
        'photoId',
        'photo'
    ];

    /**
     * @var string Where the photo was captured from
     */
    public $type;

    /**
     * @var string The date the photo was taken (in UTC)
     */
    public $date;

    /**
     * @var string A string containing metadata about where/when the photo was captured
     */
    public $tag;

    /**
     * @var string The file type of the photo
     */
    public $fileType;

    /**
     * @var string A unique identifier for this photo
     */
    public $photoId;

    /**
     * @var string Base 64 Encoded photo
     */
    public $photo;

    /**
     * Create a SmartwaiverPhoto object by providing an array with all the
     * required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $photo  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $photo)
    {
        // Check for required keys
        parent::__construct($photo, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->type = $photo['type'];
        $this->date = $photo['date'];
        $this->tag = $photo['tag'];
        $this->fileType = $photo['fileType'];
        $this->photoId = $photo['photoId'];
        $this->photo = $photo['photo'];
    }
}