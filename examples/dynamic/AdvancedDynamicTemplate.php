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
use Smartwaiver\Types\Data\SmartwaiverTemplateData;
use Smartwaiver\Types\Template\SmartwaiverTemplateConfig;
use Smartwaiver\Types\Template\SmartwaiverTemplateSignatures;

// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// We are going to create a template
$templateConfig = new SmartwaiverTemplateConfig();

// Set the title of our template
$templateConfig->meta->title = 'Dynamic Template';

// Set the header of our template
$templateConfig->header->text = 'Trail Treks Demo Waiver';
$templateConfig->header->logoImage = 'data:image/png;base64,'.base64_encode(file_get_contents('trail_treks_logo.png'));

// Set the body of our template to our legal language
$templateConfig->body->text = <<<BODY
<p style="text-align:center;"><strong>SAMPLE LEGAL TEXT</strong><br /><strong>All text , form fields, and signature elements can be customized on your waiver.</strong></p>
<p style="text-align:justify;">In consideration of the services of Demo Company, LLC, their agents, owners, officers, volunteers, participants, employees, and all other persons or entities acting in any capacity on their behalf (hereinafter collectively referred to as "DC"), I hereby agree to release and discharge DC, on behalf of myself, my children, my parents, my heirs, assigns, personal representative and estate as follows:</p>
<p style="text-align:justify;">1. I acknowledge that the activities involved in the use of any of DCs services or facilities entail significant risks, both known and unknown, which could result in physical or emotional injury, paralysis, death, or damage to myself, to property, or to third parties.</p>
<p style="text-align:justify;">2. I expressly agree and promise to accept and assume all of the risks existing in these activities, both known and unknown, whether caused or alleged to be caused by the negligent acts or omissions of DC. My participation in this activity is purely voluntary, and I elect to participate in spite of the risks.</p>
<p style="text-align:justify;">3. I hereby voluntarily release, forever discharge, and agree to indemnify and hold harmless DF from any and all claims, demands, or causes of action, which are in any way connected with my participation in this activity or my use of DC equipment or facilities, including any such claims which allege negligent acts or omissions of DC.</p>
<p style="text-align:justify;">4. Should DC or anyone acting on their behalf, be required to incur attorney's fees and costs to enforce this agreement, I agree to indemnify and hold them harmless for all such fees and costs.</p>
<p style="text-align:justify;">5. I certify that I have adequate insurance to cover any injury or damage I may cause or suffer while participating, or else I agree to bear the costs of such injury or damage myself. I further certify that I have no medical or physical conditions which could interfere with my safety in this activity, or else I am willing to assume - and bear the costs of -- all risks that may be created, directly or indirectly, by any such condition.</p>
<p style="text-align:justify;">6. I agree to abide by the rules of the facility. <strong>[initial]</strong></p>
<p style="text-align:justify;">By signing this document, I acknowledge that if anyone is hurt or property is damaged during my participation in this activity, I may be found by a court of law to have waived my right to maintain a lawsuit against DC on the basis of any claim from which I have released them herein.</p>
<p style="text-align:justify;"> </p>
<p style="text-align:justify;"><strong>I HAVE HAD SUFFICIENT OPPORTUNITY TO READ THIS ENTIRE DOCUMENT. I HAVE READ AND UNDERSTAND IT, AND I AGREE TO BE BOUND BY ITS TERMS. </strong></p>
<p style="text-align:justify;"><strong>Today's Date: </strong>[date]</p>
BODY;

// Allow our template to have adults
$templateConfig->participants->adults = true;

// Turn on the middle name for participants
$templateConfig->participants->middleName = true;

// We don't want to call them participants
$templateConfig->participants->participantLabel = 'Adventurer\'s';

// Add some standard questions
$templateConfig->standardQuestions->addressEnabled = true;
$templateConfig->standardQuestions->addressDefaultState = 'OR';
$templateConfig->standardQuestions->emailVerification = false;
$templateConfig->standardQuestions->emailMarketingEnabled = true;
$templateConfig->standardQuestions->emailMarketingDefaultChecked = true;

// We want to collect typed signatures by default, but let's give them the choice
$templateConfig->signatures->type = SmartwaiverTemplateSignatures::SIGNATURE_CHOICE;
$templateConfig->signatures->defaultChoice = SmartwaiverTemplateSignatures::SIGNATURE_TYPE;

// Set up our redirects on success and cancelation
$templateConfig->completion->redirectSuccess = 'https://localhost/done?tid=[transactionId]';
$templateConfig->completion->redirectCancel = 'https://localhost/cancel';

// Now we are going to create some data to prefill this template with
$data = new SmartwaiverTemplateData();

// Add a participant
$data->addParticipant('Kyle', 'Smith', null, null, null, '1986-01-02');

// Set the standard fields
$data->addressLineOne = '123 Main St.';
$data->addressLineTwo = 'Suite 2';
$data->addressCity = 'Bend';
$data->addressZip = '97701';
$data->email = 'test@example.org';

// One final piece, how long do we want our template to last if nobody fills it in (this is in seconds)
$expiration = 600;

// Now it's time to make our API call.
$dynamicTemplate = $sw->createDynamicTemplate($templateConfig, $data, $expiration);

// Access our created template
echo 'Successfully created dynamic template.' . PHP_EOL;
echo 'Template ID: ' . $dynamicTemplate->uuid . ' expires in ' . $dynamicTemplate->expiration . ' seconds...' . PHP_EOL;
echo 'Please go to ' . $dynamicTemplate->url . ' to fill it out!' . PHP_EOL;
