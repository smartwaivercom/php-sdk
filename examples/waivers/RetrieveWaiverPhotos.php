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

require_once __DIR__ . '/../../../../autoload.php';

use Smartwaiver\Smartwaiver;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// The unique ID of the signed waiver to retrieve photos for
$waiverId = '[INSERT WAIVER ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Get the photos for a specific waiver
$photos = $sw->getWaiverPhotos($waiverId);

// Print a little header
echo PHP_EOL . 'Waiver Photos for: ' . $photos->title . PHP_EOL;
// echo $photos->waiverId;
// echo $photos->templateId;
// echo $photos->createdOn;

// Loop through photos and print out some meta-data
foreach ($photos->photos as $photo) {
    echo $photo->photoId . ': ' . $photo->date;
    // Other fields
    // echo $photo->type;
    // echo $photo->tag;
    // echo $photo->fileType;
    // echo $photo->photo; // Base 64 encoded photo
}
