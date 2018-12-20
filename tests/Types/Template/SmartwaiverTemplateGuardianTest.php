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

use Smartwaiver\Types\Template\SmartwaiverTemplateGuardian;

/**
 * Class SmartwaiverTemplateGuardianTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateGuardianTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $guardian = new SmartwaiverTemplateGuardian();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $guardian = new SmartwaiverTemplateGuardian();
        $this->assertFalse(isset($guardian->verbiage));
        $this->assertFalse(isset($guardian->verbiageParticipantAddendum));
        $this->assertFalse(isset($guardian->label));
        $this->assertFalse(isset($guardian->relationship));
        $this->assertFalse(isset($guardian->ageVerification));
        $this->assertEquals(new \ArrayObject(), $guardian->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'verbiage' => '',
            'verbiageParticipantAddendum' => '',
            'label' => ''
        ];

        $guardian = new SmartwaiverTemplateGuardian($input);
        $this->assertFalse(isset($guardian->verbiage));
        $this->assertFalse(isset($guardian->verbiageParticipantAddendum));
        $this->assertFalse(isset($guardian->label));
        $this->assertEquals(new \ArrayObject(), $guardian->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'verbiage' => 'test',
            'verbiageParticipantAddendum' => 'test2',
            'label' => 'test3',
            'relationship' => true,
            'ageVerification' => true
        ];

        $guardian = new SmartwaiverTemplateGuardian($input);
        $this->assertEquals($guardian->verbiage, 'test');
        $this->assertEquals($guardian->verbiageParticipantAddendum, 'test2');
        $this->assertEquals($guardian->label, 'test3');
        $this->assertEquals($guardian->relationship, true);
        $this->assertEquals($guardian->ageVerification, true);
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $guardian = new SmartwaiverTemplateGuardian();
        $guardian->verbiage = '';
        $guardian->verbiageParticipantAddendum = '';
        $guardian->label = '';
        $this->assertEquals(new \ArrayObject(), $guardian->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['verbiage'] = 'test';
        $expected['verbiageParticipantAddendum'] = 'test2';
        $expected['label'] = 'test3';
        $expected['relationship'] = true;
        $expected['ageVerification'] = true;

        $guardian = new SmartwaiverTemplateGuardian();
        $guardian->verbiage = 'test';
        $guardian->verbiageParticipantAddendum = 'test2';
        $guardian->label = 'test3';
        $guardian->relationship = true;
        $guardian->ageVerification = true;
        $this->assertEquals($expected, $guardian->apiArray());
    }
}
