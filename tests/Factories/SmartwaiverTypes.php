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

namespace Smartwaiver\Tests\Factories;

/**
 * Class SmartwaiverTypes
 *
 * @package Smartwaiver\Tests\Factories
 */
class SmartwaiverTypes
{
    /**
     * Create an input array for a SmartwaiverTemplate object
     *
     * @return array
     */
    public static function createTemplate()
    {
        return [
            'templateId' => 'sprswrvh2keeh',
            'title' => 'Demo Waiver',
            'publishedVersion' => 78015,
            'publishedOn' => '2017-01-24 11:14:25',
            'webUrl' => 'https://waiver.smartwaiver.com/w/sprswrvh2keeh/web/',
            'kioskUrl' => 'https://waiver.smartwaiver.com/w/sprswrvh2keeh/kiosk/',
            'vanityUrls' => [
                'https://waiver.smartwaiver.com/v/foobar/'
            ]
        ];
    }

    /**
     * Create an input array for a SmartwaiverWaiverSummary object
     *
     * @return array
     */
    public static function createWaiverSummary()
    {
        return [
            'waiverId' => '6jebdfxzvrdkd',
            'templateId' => 'sprswrvh2keeh',
            'title' => 'Demo Waiver',
            'createdOn' => '2017-01-24 13:12:29',
            'expirationDate' => '',
            'expired' => false,
            'verified' => true,
            'kiosk' => false,
            'firstName' => 'Kyle',
            'middleName' => '',
            'lastName' => 'Smith',
            'dob' => '2005-12-25',
            'isMinor' => true,
            'tags' => [
                'Green Team'
            ],
            'flags' => [
                SmartwaiverTypes::createFlag()
            ]
        ];
    }

    /**
     * Create an input array for a SmartwaiverWaiver object
     *
     * @return array
     */
    public static function createWaiver()
    {
        $waiver = self::createWaiverSummary();
        $waiver['participants'] = [self::createParticipant()];
        $waiver['clientIP'] = '192.0.2.0';
        $waiver['email']  = 'kyle@example.com';
        $waiver['marketingAllowed']  = false;
        $waiver['addressLineOne']  = '626 NW Arizona Ave.';
        $waiver['addressLineTwo']  = 'Suite 2';
        $waiver['addressCity']  = 'Bend';
        $waiver['addressState']  = 'OR';
        $waiver['addressZip']  = '97703';
        $waiver['addressCountry']  = 'US';
        $waiver['emergencyContactName']  = 'John Smith';
        $waiver['emergencyContactPhone']  = '111-111-1111';
        $waiver['insuranceCarrier']  = 'My Insurance';
        $waiver['insurancePolicyNumber']  = '1234567';
        $waiver['driversLicenseNumber']  = '9876543';
        $waiver['driversLicenseState']  = 'OR';
        $waiver['customWaiverFields']  = [
            'zrmgxh4ft8sqh' => SmartwaiverTypes::createCustomField()
        ];
        $waiver['guardian']  = SmartwaiverTypes::createGuardian();
        $waiver['pdf'] = '';
        $waiver['photos'] = 0;
        return $waiver;
    }

    /**
     * Create an input array for a SmartwaiverParticipant object
     *
     * @return array
     */
    public static function createParticipant()
    {
        return [
            'firstName' => 'Kyle',
            'middleName' => '',
            'lastName' => 'Smith',
            'dob' => '2005-12-25',
            'isMinor' => 'true',
            'gender' => 'Male',
            'phone' => '111-111-1111',
            'tags' => [
                'Beginner'
            ],
            'customParticipantFields' => [
                'w5qe9kkh3bxpe' => SmartwaiverTypes::createCustomField()
            ],
            'flags' => [
                SmartwaiverTypes::createFlag()
            ]
        ];
    }

    /**
     * Create an input array for a SmartwaiverPhotos object
     *
     * @return array
     */
    public static function createPhotos()
    {
        return [
            'waiverId' => '6jebdfxzvrdkd',
            'templateId' => 'sprswrvh2keeh',
            'title' => 'Demo Waiver',
            'createdOn' => '2017-01-24 13:12:29',
            'photos' => [
                SmartwaiverTypes::createPhoto()
            ]
        ];
    }

    /**
     * Create an input array for a SmartwaiverPhoto object
     *
     * @return array
     */
    public static function createPhoto()
    {
        return [
            'type' => 'kiosk',
            'date' => '2017-01-24 13:12:29',
            'tag' => 'IP: 192.168.2.0',
            'fileType' => 'jpg',
            'photoId' => 'CwLeDjffgDoGHua',
            'photo' => 'BASE64 ENCODED PHOTO',
        ];
    }

    /**
     * Create an input array for a SmartwaiverSignature object
     *
     * @return array
     */
    public static function createSignatures()
    {
        return [
            'waiverId' => '6jebdfxzvrdkd',
            'templateId' => 'sprswrvh2keeh',
            'title' => 'Demo Waiver',
            'createdOn' => '2017-01-24 13:12:29',
            'signatures' => [
                'participants' => ['BASE64ENCODED'],
                'guardian' => ['BASE64ENCODED'],
                'bodySignatures' => ['BASE64ENCODED'],
                'bodyInitials' => ['BASE64ENCODED']
            ]
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhook object
     *
     * @return array
     */
    public static function createWebhook()
    {
        return [
            'endpoint' => 'endpoint',
            'emailValidationRequired' => 'both'
        ];
    }

    /**
     * Create an input array for a SmartwaiverCustomField object
     *
     * @return array
     */
    public static function createCustomField()
    {
        return [
            'value' => 'A friend',
            'displayText' => 'How did you hear about this company?'
        ];
    }

    /**
     * Create an input array for a SmartwaiverFlag object
     *
     * @return array
     */
    public static function createFlag()
    {
        return [
            'displayText' => 'Are you ready to have fun?',
            'reason' => 'was not selected'
        ];
    }

    /**
     * Create an input array for a SmartwaiverGuardian object
     *
     * @return array
     */
    public static function createGuardian()
    {
        return [
            'firstName' => 'Jane',
            'middleName' => '',
            'lastName' => 'Smith',
            'phone' => '111-111-1111',
            'relationship' => 'Mother'
        ];
    }

    /**
     * Create an input array for a SmartwaiverSearch object
     *
     * @return array
     */
    public static function createSearch()
    {
        return [
            'guid' => 'a0256461ca244278b412ab3238f5efd2',
            'count' => 563,
            'pages' => 5,
            'pageSize' => 100
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhookQueue object
     *
     * @return array
     */
    public static function createWebhookQueue()
    {
        return [
            'messagesTotal' => 0,
            'messagesNotVisible' => 0,
            'messagesDelayed' => 0
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhookQueues object
     *
     * @return array
     */
    public static function createWebhookQueues()
    {
        return [
            'account' => SmartwaiverTypes::createWebhookQueue(),
            'template-4fc7d12601941' => SmartwaiverTypes::createWebhookQueue()
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhookMessage object
     *
     * @return array
     */
    public static function createWebhookMessage()
    {
        return [
            'messageId' => '9d58e8fc-6353-4ceb-b0a3-5412f3d05e28',
            'payload' => SmartwaiverTypes::createWebhookMessagePayload(),
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhookMessagePayload object
     *
     * @return array
     */
    public static function createWebhookMessagePayload()
    {
        return [
            'unique_id' => '9d58e8fc-6353-4ceb-b0a3-5412f3d05e28',
            'event' => 'new-waiver'
        ];
    }

    /**
     * Create an input array for a SmartwaiverWebhookMessageDelete object
     *
     * @return array
     */
    public static function createWebhookMessageDelete()
    {
        return [
            'success' => true,
        ];
    }

    /**
     * Create an input array for a SmartwaiverDynamicTemplate object
     *
     * @return array
     */
    public static function createDynamicTemplate()
    {
        return [
            'expiration' => 300,
            'uuid' => 'sprswrvh2keeh',
            'url' => 'https://waiver.smartwaiver.com/d/sprswrvh2keeh/',
        ];
    }

    /**
     * Create an input array for a SmartwaiverDynamicProcess object
     *
     * @return array
     */
    public static function dynamicProcess()
    {
        return [
            'transactionId' => 'sprswrvh2keeh',
            'waiverId' => '6jebdfxzvrdkd',
        ];
    }
}
