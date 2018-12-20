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

namespace Smartwaiver\Tests;

use Smartwaiver\Types\Template\SmartwaiverTemplateProcessing;

/**
 * Class SmartwaiverTemplateProcessingTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateProcessingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $processing = new SmartwaiverTemplateProcessing();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $processing = new SmartwaiverTemplateProcessing();
        $this->assertFalse(isset($processing->emailBusinessName));
        $this->assertFalse(isset($processing->emailReplyTo));
        $this->assertFalse(isset($processing->emailCustomTextEnabled));
        $this->assertFalse(isset($processing->emailCustomTextWeb));
        $this->assertFalse(isset($processing->emailCCEnabled));
        $this->assertFalse(isset($processing->emailCCWebEnabled));
        $this->assertFalse(isset($processing->emailCCEmails));
        $this->assertFalse(isset($processing->emailIncludeBarcodes));
        $this->assertEquals(new \ArrayObject(), $processing->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'emailBusinessName' => '',
            'emailReplyTo' => '',
            'emailCustomTextWeb' => ''
        ];

        $processing = new SmartwaiverTemplateProcessing($input);
        $this->assertFalse(isset($processing->emailBusinessName));
        $this->assertFalse(isset($processing->emailReplyTo));
        $this->assertFalse(isset($processing->emailCustomTextWeb));
        $this->assertEquals(new \ArrayObject(), $processing->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'emails' => [
                'businessName' => 'test',
                'replyTo' => 'test2',
                'customText' => [
                    'enabled' => true,
                    'web' => 'test3'
                ],
                'cc' => [
                    'enabled' => true,
                    'web' => true,
                    'emails' => [
                        'noreply@smartwaiver.com',
                        'noreply@smartwaiver.com',
                        'noreply@smartwaiver.com'
                    ]
                ],
                'includeBarcodes' => true
            ]
        ];

        $processing = new SmartwaiverTemplateProcessing($input);
        $this->assertEquals($processing->emailBusinessName, 'test');
        $this->assertEquals($processing->emailReplyTo, 'test2');
        $this->assertEquals($processing->emailCustomTextEnabled, true);
        $this->assertEquals($processing->emailCustomTextWeb, 'test3');
        $this->assertEquals($processing->emailCCEnabled, true);
        $this->assertEquals($processing->emailCCWebEnabled, true);
        $this->assertEquals($processing->emailCCEmails, [
            'noreply@smartwaiver.com',
            'noreply@smartwaiver.com',
            'noreply@smartwaiver.com'
        ]);
        $this->assertEquals($processing->emailIncludeBarcodes, true);
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $processing = new SmartwaiverTemplateProcessing();
        $processing->emailBusinessName = '';
        $processing->emailReplyTo = '';
        $processing->emailCustomTextWeb = '';
        $this->assertEquals(new \ArrayObject(), $processing->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['emails'] = [
            'businessName' => 'test',
            'replyTo' => 'test2',
            'customText' => [
                'enabled' => true,
                'web' => 'test3'
            ],
            'cc' => [
                'enabled' => true,
                'web' => true,
                'emails' => [
                    'noreply@smartwaiver.com',
                    'noreply@smartwaiver.com',
                    'noreply@smartwaiver.com'
                ]
            ],
            'includeBarcodes' => true
        ];

        $processing = new SmartwaiverTemplateProcessing();
        $processing->emailBusinessName = 'test';
        $processing->emailReplyTo = 'test2';
        $processing->emailCustomTextEnabled = true;
        $processing->emailCustomTextWeb = 'test3';
        $processing->emailCCEnabled = true;
        $processing->emailCCWebEnabled = true;
        $processing->emailCCEmails = [
            'noreply@smartwaiver.com',
            'noreply@smartwaiver.com',
            'noreply@smartwaiver.com'
        ];
        $processing->emailIncludeBarcodes = true;
        $this->assertEquals($expected, $processing->apiArray());
    }
}
