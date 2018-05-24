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

// The unique ID of the signed waiver to be retrieved
$waiverId = '[INSERT WAIVER ID]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Get a specific of waiver (include the PDF as a base 64 encoded string)
$waiver = $sw->getWaiver($waiverId, $pdf = true);

// Access waiver properties
// These are all the available properties for a SmartwaiverWaiver
echo 'Waiver Id: ' . $waiver->waiverId . PHP_EOL;
echo 'Template Id: ' . $waiver->templateId . PHP_EOL;
echo 'Title: ' . $waiver->title . PHP_EOL;
echo 'Created On: ' . $waiver->createdOn . PHP_EOL;
echo 'Expiration Date: ' . $waiver->expirationDate . PHP_EOL;
echo 'Expired: ' . ($waiver->expired ? 'true' : 'false') . PHP_EOL;
echo 'Verified: ' . ($waiver->verified ? 'true' : 'false') . PHP_EOL;
echo 'Kiosk: ' . ($waiver->kiosk ? 'true' : 'false') . PHP_EOL;
echo 'First Name: ' . $waiver->firstName . PHP_EOL;
echo 'Middle Name: ' . $waiver->middleName . PHP_EOL;
echo 'Last Name: ' . $waiver->lastName . PHP_EOL;
echo 'Dob: ' . $waiver->dob . PHP_EOL;
echo 'Is Minor: ' . ($waiver->isMinor ? 'true' : 'false') . PHP_EOL;
echo 'Tags:' . PHP_EOL;
foreach($waiver->tags as $tag) {
    echo '    ' . $tag . PHP_EOL;
}
echo 'Flags: (Display Text, Reason)' . PHP_EOL;
foreach ($waiver->flags as $flag) {
    echo '    ' . $flag->displayText . ', ' . $flag->reason . PHP_EOL;
}
echo 'Participants:' . PHP_EOL;
foreach ($waiver->participants as $index => $participant) {
    echo '    Participant ' . $index . ':'
        . PHP_EOL . '        First Name: ' . $participant->firstName
        . PHP_EOL . '        Middle Name: ' . $participant->middleName
        . PHP_EOL . '        Last Name: ' . $participant->lastName
        . PHP_EOL . '        DOB: ' . $participant->dob
        . PHP_EOL . '        Is Minor: ' . ($participant->isMinor ? 'true' : 'false')
        . PHP_EOL . '        Gender: ' . $participant->gender
        . PHP_EOL . '        Tags: ' . implode(',', $participant->tags)
        . PHP_EOL . '        Custom Participant Fields: (GUID, Display Text, Value)' . PHP_EOL;
    foreach ($participant->customParticipantFieldsByGuid as $guid => $customParticipantField) {
        echo '            ' . $guid . ', '
            . $customParticipantField->displayText
            . ', ' . $customParticipantField->value . PHP_EOL;
    }
    echo '        Flags: (Display Text, Reason)' . PHP_EOL;
    foreach ($waiver->flags as $flag) {
        echo '            ' . $flag->displayText . ', ' . $flag->reason . PHP_EOL;
    }
}
echo 'Custom Waiver Fields: (GUID, Display Text, Value)' . PHP_EOL;
foreach ($waiver->customWaiverFieldsByGuid as $guid => $customWaiverField) {
    echo '    ' . $guid
        . ', ' . $customWaiverField->displayText
        . ', ' . $customWaiverField->value . PHP_EOL;
}
echo 'Guardian:' . PHP_EOL;
if(!is_null($waiver->guardian))
{
    echo '    First Name: ' . $waiver->guardian->firstName . PHP_EOL;
    echo '    Middle Name: ' . $waiver->guardian->middleName . PHP_EOL;
    echo '    Last Name: ' . $waiver->guardian->lastName . PHP_EOL;
    echo '    Phone: ' . $waiver->guardian->phone . PHP_EOL;
    echo '    Relationship: ' . $waiver->guardian->relationship . PHP_EOL;
}
echo 'Email: ' . $waiver->email . PHP_EOL;
echo 'Marketing Allowed: ' . ($waiver->marketingAllowed ? 'true' : 'false') . PHP_EOL;
echo 'Address Line One: ' . $waiver->addressLineOne . PHP_EOL;
echo 'Address Line Two: ' . $waiver->addressLineTwo . PHP_EOL;
echo 'Address City: ' . $waiver->addressCity . PHP_EOL;
echo 'Address State: ' . $waiver->addressState . PHP_EOL;
echo 'Address Zip Code: ' . $waiver->addressZip . PHP_EOL;
echo 'Address Country: ' . $waiver->addressCountry . PHP_EOL;
echo 'Emergency Contact Name: ' . $waiver->emergencyContactName . PHP_EOL;
echo 'Emergency Contact Phone: ' . $waiver->emergencyContactPhone . PHP_EOL;
echo 'Insurance Carrier: ' . $waiver->insuranceCarrier . PHP_EOL;
echo 'Insurance Policy Number: ' . $waiver->insurancePolicyNumber . PHP_EOL;
echo 'Drivers License Number: ' . $waiver->driversLicenseNumber . PHP_EOL;
echo 'Drivers License State: ' . $waiver->driversLicenseState . PHP_EOL;
echo 'Client IP: ' . $waiver->clientIP . PHP_EOL;
echo 'Number of Photos: ' . $waiver->photos . PHP_EOL;
// A base 64 encoded string
echo 'PDF: ' . $waiver->pdf . PHP_EOL;
