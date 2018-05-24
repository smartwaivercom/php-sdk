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
use Smartwaiver\Types\SmartwaiverCustomField;
use Smartwaiver\Types\SmartwaiverParticipant;

/**
 * Class SmartwaiverParticipantTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverParticipantTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverParticipant with missing field: firstName');

        $participant = SmartwaiverTypes::createParticipant();
        unset($participant['firstName']);

        $swParticipant = new SmartwaiverParticipant($participant);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $participant = SmartwaiverTypes::createParticipant();
        $swParticipant = new SmartwaiverParticipant($participant);

        $this->assertEquals($participant['firstName'], $swParticipant->firstName);
        $this->assertEquals($participant['middleName'], $swParticipant->middleName);
        $this->assertEquals($participant['lastName'], $swParticipant->lastName);
        $this->assertEquals($participant['dob'], $swParticipant->dob);
        $this->assertEquals($participant['isMinor'], $swParticipant->isMinor);
        $this->assertEquals($participant['gender'], $swParticipant->gender);
        $this->assertEquals($participant['phone'], $swParticipant->phone);
        $this->assertEquals($participant['tags'], $swParticipant->tags);

        $this->assertCount(count($participant['customParticipantFields']), $swParticipant->customParticipantFields);
        $this->assertCount(count($participant['customParticipantFields']), $swParticipant->customParticipantFieldsByGuid);
        foreach($swParticipant->customParticipantFields as $customParticipantField) {
            $this->assertInstanceOf(SmartwaiverCustomField::class, $customParticipantField);
        }
        foreach($swParticipant->customParticipantFieldsByGuid as $guid => $customParticipantField) {
            $this->assertInstanceOf(SmartwaiverCustomField::class, $customParticipantField);
        }
        foreach($participant['customParticipantFields'] as $guid => $customParticipantField) {
            $this->assertArrayHasKey($guid, $swParticipant->customParticipantFieldsByGuid);
        }
    }
}
