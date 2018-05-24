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

// The unique ID of the signed waiver to retrieve drawn signatures for
$waiverId = '[INSERT WAIVER ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Get the photos for a specific waiver
$signatures = $sw->getWaiverSignatures($waiverId);

// Print a little header
echo PHP_EOL . 'Waiver Signatures for: ' . $signatures->title . PHP_EOL;
// echo $signatures->waiverId;
// echo $signatures->templateId;
// echo $signatures->createdOn;

// Loop through signatures of different types and print out the base 64 encoded image.
for ($i = 0; $i < count($signatures->participantSignatures); $i++) {
    echo 'Participant #' . $i . '\'s Signature: ' . $signatures->participantSignatures[$i] . PHP_EOL;
}

for ($i = 0; $i < count($signatures->guardianSignatures); $i++) {
    echo 'Guardian #' . $i . '\'s Signature: ' . $signatures->guardianSignatures[$i] . PHP_EOL;
}

for ($i = 0; $i < count($signatures->bodySignatures); $i++) {
    echo 'Body Signature #' .$i. ': ' . $signatures->bodySignatures[$i] . PHP_EOL;
}

for ($i = 0; $i < count($signatures->bodyInitials); $i++) {
    echo 'Body Initials #' .$i. ': ' . $signatures->bodyInitials[$i] . PHP_EOL;
}
