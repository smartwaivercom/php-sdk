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
use Smartwaiver\Types\SmartwaiverFlag;
use Smartwaiver\Types\SmartwaiverWaiverSummary;

/**
 * Class SmartwaiverWaiverSummaryTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWaiverSummaryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWaiverSummary with missing field: waiverId');

        $waiver = SmartwaiverTypes::createWaiverSummary();
        unset($waiver['waiverId']);

        $swWaiverSummary = new SmartwaiverWaiverSummary($waiver);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $waiver = SmartwaiverTypes::createWaiverSummary();
        $swWaiverSummary = new SmartwaiverWaiverSummary($waiver);

        $this->assertEquals($waiver['waiverId'], $swWaiverSummary->waiverId);
        $this->assertEquals($waiver['templateId'], $swWaiverSummary->templateId);
        $this->assertEquals($waiver['title'], $swWaiverSummary->title);
        $this->assertEquals($waiver['createdOn'], $swWaiverSummary->createdOn);
        $this->assertEquals($waiver['expirationDate'], $swWaiverSummary->expirationDate);
        $this->assertEquals($waiver['expired'], $swWaiverSummary->expired);
        $this->assertEquals($waiver['verified'], $swWaiverSummary->verified);
        $this->assertEquals($waiver['kiosk'], $swWaiverSummary->kiosk);
        $this->assertEquals($waiver['firstName'], $swWaiverSummary->firstName);
        $this->assertEquals($waiver['middleName'], $swWaiverSummary->middleName);
        $this->assertEquals($waiver['lastName'], $swWaiverSummary->lastName);
        $this->assertEquals($waiver['dob'], $swWaiverSummary->dob);
        $this->assertEquals($waiver['isMinor'], $swWaiverSummary->isMinor);
        $this->assertEquals($waiver['tags'], $swWaiverSummary->tags);

        $this->assertCount(count($waiver['flags']), $swWaiverSummary->flags);
        foreach($swWaiverSummary->flags as $flag) {
            $this->assertInstanceOf(SmartwaiverFlag::class, $flag);
        }
    }
}
