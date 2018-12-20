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

use Smartwaiver\Types\Template\SmartwaiverTemplateParticipants;

/**
 * Class SmartwaiverTemplateParticipantsTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateParticipantsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $participants = new SmartwaiverTemplateParticipants();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $participants = new SmartwaiverTemplateParticipants();
        $this->assertFalse(isset($participants->adults));
        $this->assertFalse(isset($participants->minorsEnabled));
        $this->assertFalse(isset($participants->multipleMinors));
        $this->assertFalse(isset($participants->minorsWithoutAdults));
        $this->assertFalse(isset($participants->ageOfMajority));
        $this->assertFalse(isset($participants->participantLabel));
        $this->assertFalse(isset($participants->participatingText));
        $this->assertFalse(isset($participants->middleName));
        $this->assertFalse(isset($participants->phone));
        $this->assertFalse(isset($participants->gender));
        $this->assertFalse(isset($participants->dobType));
        $this->assertEquals(new \ArrayObject(), $participants->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'participantLabel' => '',
            'participatingText' => '',
            'ageOfMajority' => '',
            'config' => [
                'phone' => '',
                'dobType' => ''
            ]
        ];

        $participants = new SmartwaiverTemplateParticipants($input);
        $this->assertFalse(isset($participants->participantLabel));
        $this->assertFalse(isset($participants->participatingText));
        $this->assertFalse(isset($participants->ageOfMajority));
        $this->assertFalse(isset($participants->phone));
        $this->assertFalse(isset($participants->dobType));
        $this->assertEquals(new \ArrayObject(), $participants->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'adults' => true,
            'minors' => [
                'enabled' => true,
                'multipleMinors' => true,
                'minorsWithoutAdults' => true,
                'adultsAndMinors' => true
            ],
            'ageOfMajority' => 18,
            'participantLabel' => 'test',
            'participatingText' => 'test2',
            'config' => [
                'middleName' => true,
                'phone' => SmartwaiverTemplateParticipants::PARTICIPANT_PHONE_ADULTS_AND_MINORS,
                'gender' => true,
                'dobType' => SmartwaiverTemplateParticipants::PARTICIPANT_DOB_CHECKBOX
            ]
        ];

        $participants = new SmartwaiverTemplateParticipants($input);
        $this->assertEquals($participants->adults, true);
        $this->assertEquals($participants->minorsEnabled, true);
        $this->assertEquals($participants->multipleMinors, true);
        $this->assertEquals($participants->minorsWithoutAdults, true);
        $this->assertEquals($participants->adultsAndMinors, true);
        $this->assertEquals($participants->ageOfMajority, 18);
        $this->assertEquals($participants->participantLabel, 'test');
        $this->assertEquals($participants->participatingText, 'test2');
        $this->assertEquals($participants->middleName, true);
        $this->assertEquals($participants->phone, SmartwaiverTemplateParticipants::PARTICIPANT_PHONE_ADULTS_AND_MINORS);
        $this->assertEquals($participants->gender, true);
        $this->assertEquals($participants->dobType, SmartwaiverTemplateParticipants::PARTICIPANT_DOB_CHECKBOX);
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $participants = new SmartwaiverTemplateParticipants();
        $participants->participantLabel = '';
        $participants->participatingText = '';
        $participants->ageOfMajority = '';
        $participants->phone = '';
        $participants->dobType = '';
        $this->assertEquals(new \ArrayObject(), $participants->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['adults'] = true;
        $expected['minors'] = [
            'enabled' => true,
            'multipleMinors' => true,
            'minorsWithoutAdults' => true,
            'adultsAndMinors' => true
        ];
        $expected['ageOfMajority'] = 18;
        $expected['participantLabel'] = 'test';
        $expected['participatingText'] = 'test2';
        $expected['config'] = [
            'middleName' => true,
            'phone' => SmartwaiverTemplateParticipants::PARTICIPANT_PHONE_ADULTS_AND_MINORS,
            'gender' => true,
            'dobType' => SmartwaiverTemplateParticipants::PARTICIPANT_DOB_CHECKBOX
        ];

        $participants = new SmartwaiverTemplateParticipants();
        $participants->adults = true;
        $participants->minorsEnabled = true;
        $participants->multipleMinors = true;
        $participants->minorsWithoutAdults = true;
        $participants->adultsAndMinors = true;
        $participants->ageOfMajority = 18;
        $participants->participantLabel = 'test';
        $participants->participatingText = 'test2';
        $participants->middleName = true;
        $participants->phone = SmartwaiverTemplateParticipants::PARTICIPANT_PHONE_ADULTS_AND_MINORS;
        $participants->gender = true;
        $participants->dobType = SmartwaiverTemplateParticipants::PARTICIPANT_DOB_CHECKBOX;
        $this->assertEquals($expected, $participants->apiArray());
    }
}
