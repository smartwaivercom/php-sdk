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

use Smartwaiver\Types\Template\SmartwaiverTemplateStandardQuestions;

/**
 * Class SmartwaiverTemplateStandardQuestionsTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateStandardQuestionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $standardQuestions = new SmartwaiverTemplateStandardQuestions();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $standardQuestions = new SmartwaiverTemplateStandardQuestions();
        $this->assertFalse(isset($standardQuestions->addressEnabled));
        $this->assertFalse(isset($standardQuestions->addressRequired));
        $this->assertFalse(isset($standardQuestions->addressDefaultCountry));
        $this->assertFalse(isset($standardQuestions->addressDefaultState));
        $this->assertFalse(isset($standardQuestions->emailVerification));
        $this->assertFalse(isset($standardQuestions->emailMarketingEnabled));
        $this->assertFalse(isset($standardQuestions->emailMarketingOptInText));
        $this->assertFalse(isset($standardQuestions->emailMarketingDefaultChecked));
        $this->assertFalse(isset($standardQuestions->emergencyContactEnabled));
        $this->assertFalse(isset($standardQuestions->insuranceEnabled));
        $this->assertFalse(isset($standardQuestions->idCardEnabled));
        $this->assertEquals(new \ArrayObject(), $standardQuestions->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'addressDefaultCountry' => '',
            'addressDefaultState' => '',
            'emailMarketingOptInText' => ''
        ];

        $standardQuestions = new SmartwaiverTemplateStandardQuestions($input);
        $this->assertFalse(isset($standardQuestions->addressDefaultCountry));
        $this->assertFalse(isset($standardQuestions->addressDefaultState));
        $this->assertFalse(isset($standardQuestions->emailMarketingOptInText));
        $this->assertEquals(new \ArrayObject(), $standardQuestions->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'address' => [
                'enabled' => true,
                'required' => true,
                'defaults' => [
                    'country' => 'test',
                    'state' => 'test2'
                ]
            ],
            'email' => [
                'verification' => true,
                'marketing' => [
                    'enabled' => true,
                    'optInText' => 'test3',
                    'defaultChecked' => true,
                ]
            ],
            'emergencyContact' => [
                'enabled' => true
            ],
            'insurance' => [
                'enabled' => true
            ],
            'idCard' => [
                'enabled' => true
            ]
        ];

        $standardQuestions = new SmartwaiverTemplateStandardQuestions($input);
        $this->assertEquals($standardQuestions->addressEnabled, true);
        $this->assertEquals($standardQuestions->addressRequired, true);
        $this->assertEquals($standardQuestions->addressDefaultCountry, 'test');
        $this->assertEquals($standardQuestions->addressDefaultState, 'test2');
        $this->assertEquals($standardQuestions->emailVerification, true);
        $this->assertEquals($standardQuestions->emailMarketingEnabled, true);
        $this->assertEquals($standardQuestions->emailMarketingOptInText, 'test3');
        $this->assertEquals($standardQuestions->emailMarketingDefaultChecked, true);
        $this->assertEquals($standardQuestions->emergencyContactEnabled, true);
        $this->assertEquals($standardQuestions->insuranceEnabled, true);
        $this->assertEquals($standardQuestions->idCardEnabled, true);
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $standardQuestions = new SmartwaiverTemplateStandardQuestions();
        $standardQuestions->addressDefaultCountry = '';
        $standardQuestions->addressDefaultState = '';
        $standardQuestions->emailMarketingOptInText = '';
        $this->assertEquals(new \ArrayObject(), $standardQuestions->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['address'] = [
            'enabled' => true,
            'required' => true,
            'defaults' => [
                'country' => 'test',
                'state' => 'test2'
            ]
        ];
        $expected['email'] = [
            'verification' => true,
            'marketing' => [
                'enabled' => true,
                'optInText' => 'test3',
                'defaultChecked' => true,
            ]
        ];
        $expected['emergencyContact'] = [
            'enabled' => true
        ];
        $expected['insurance'] = [
            'enabled' => true
        ];
        $expected['idCard'] = [
            'enabled' => true
        ];

        $standardQuestions = new SmartwaiverTemplateStandardQuestions();
        $standardQuestions->addressEnabled = true;
        $standardQuestions->addressRequired = true;
        $standardQuestions->addressDefaultCountry = 'test';
        $standardQuestions->addressDefaultState = 'test2';
        $standardQuestions->emailVerification = true;
        $standardQuestions->emailMarketingEnabled = true;
        $standardQuestions->emailMarketingOptInText = 'test3';
        $standardQuestions->emailMarketingDefaultChecked = true;
        $standardQuestions->emergencyContactEnabled = true;
        $standardQuestions->insuranceEnabled = true;
        $standardQuestions->idCardEnabled = true;
        $this->assertEquals($expected, $standardQuestions->apiArray());
    }
}
