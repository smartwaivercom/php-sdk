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

use InvalidArgumentException;
use Smartwaiver\Tests\Factories\SmartwaiverTypes;
use Smartwaiver\Types\Data\SmartwaiverTemplateData;

/**
 * Class SmartwaiverTemplateDataTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test blank data object is generated properly
     */
    public function testBlankData()
    {
        $expected = new \ArrayObject();

        $data = new SmartwaiverTemplateData();
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adult parameter
     */
    public function testAdultParamTrue()
    {
        $expected = new \ArrayObject();
        $expected['adult'] = true;

        $data = new SmartwaiverTemplateData();
        $data->adult = true;
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adult parameter
     */
    public function testAdultParamFalse()
    {
        $expected = new \ArrayObject();
        $expected['adult'] = false;

        $data = new SmartwaiverTemplateData();
        $data->adult = false;
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants
     */
    public function testAddParticipant()
    {
        $expected = new \ArrayObject();
        $expected['participants'] = [
            [
                'firstName' => 'TestFirst',
                'lastName' => 'TestLast'
            ]
        ];

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst', 'TestLast');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants first name required
     */
    public function testAddParticipantNoFirst()
    {
        $expected = new \ArrayObject();

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('', 'TestLast');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants last name required
     */
    public function testAddParticipantNoLast()
    {
        $expected = new \ArrayObject();

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst', '');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants middle
     */
    public function testAddParticipantMiddle()
    {
        $expected = new \ArrayObject();
        $expected['participants'] = [
            [
                'firstName' => 'TestFirst',
                'lastName' => 'TestLast',
                'middleName' => 'TestMiddle'
            ]
        ];

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst', 'TestLast', 'TestMiddle');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants phone
     */
    public function testAddParticipantPhone()
    {
        $expected = new \ArrayObject();
        $expected['participants'] = [
            [
                'firstName' => 'TestFirst',
                'lastName' => 'TestLast',
                'phone' => '123-456-7890'
            ]
        ];

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst', 'TestLast', null, '123-456-7890');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants gender
     */
    public function testAddParticipantGender()
    {
        $expected = new \ArrayObject();
        $expected['participants'] = [
            [
                'firstName' => 'TestFirst',
                'lastName' => 'TestLast',
                'gender' => 'Male'
            ]
        ];

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst', 'TestLast', null, null, 'Male');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding participants dob
     */
    public function testAddParticipantDob()
    {
        $expected = new \ArrayObject();
        $expected['participants'] = [
            [
                'firstName' => 'TestFirst',
                'lastName' => 'TestLast',
                'dob' => '1990-01-01'
            ]
        ];

        $data = new SmartwaiverTemplateData();
        $data->addParticipant('TestFirst','TestLast', null, null, null, '1990-01-01');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian
     */
    public function testSetGuardian()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian first name required
     */
    public function testSetGuardianNoFirst()
    {
        $expected = new \ArrayObject();

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('', 'TestLast');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian last name required
     */
    public function testSetGuardianNoLast()
    {
        $expected = new \ArrayObject();

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', '');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian middle name
     */
    public function testSetGuardianMiddleName()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'middleName' => 'TestMiddle'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', 'TestMiddle');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian relationship
     */
    public function testSetGuardianRelationship()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'relationship' => 'Father'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, 'Father');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian phone
     */
    public function testSetGuardianPhone()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'phone' => '123-456-7890'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, null, '123-456-7890');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian gender
     */
    public function testSetGuardianGender()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'gender' => 'Male'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, null, null, 'Male');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian dob
     */
    public function testSetGuardianDob()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'dob' => '1990-01-01'
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, null, null, null, '1990-01-01');
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian participant
     */
    public function testSetGuardianParticipantTrue()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'participant' => true
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, null, null, null, null, true);
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding guardian participant false
     */
    public function testSetGuardianParticipantFalse()
    {
        $expected = new \ArrayObject();
        $expected['guardian'] = [
            'firstName' => 'TestFirst',
            'lastName' => 'TestLast',
            'participant' => false
        ];

        $data = new SmartwaiverTemplateData();
        $data->setGuardian('TestFirst', 'TestLast', null, null, null, null, null, false);
        $this->assertEquals($expected, $data->apiArray());
    }

    /**
     * Test adding standard fields
     */
    public function testStandardFields()
    {
        $expected = new \ArrayObject();
        $expected['addressLineOne'] = 'Test1';
        $expected['addressLineTwo'] = 'Test2';
        $expected['addressCountry'] = 'Test3';
        $expected['addressState'] = 'Test4';
        $expected['addressZip'] = 'Test5';
        $expected['email'] = 'Test6';
        $expected['emergencyContactName'] = 'Test7';
        $expected['emergencyContactPhone'] = 'Test8';
        $expected['insuranceCarrier'] = 'Test9';
        $expected['insurancePolicyNumber'] = 'Test10';
        $expected['driversLicenseState'] = 'Test11';
        $expected['driversLicenseNumber'] = 'Test12';

        $data = new SmartwaiverTemplateData();
        $data->addressLineOne = 'Test1';
        $data->addressLineTwo = 'Test2';
        $data->addressCountry = 'Test3';
        $data->addressState = 'Test4';
        $data->addressZip = 'Test5';
        $data->email = 'Test6';
        $data->emergencyContactName = 'Test7';
        $data->emergencyContactPhone = 'Test8';
        $data->insuranceCarrier = 'Test9';
        $data->insurancePolicyNumber = 'Test10';
        $data->driversLicenseState = 'Test11';
        $data->driversLicenseNumber = 'Test12';
        $this->assertEquals($expected, $data->apiArray());
    }
}
