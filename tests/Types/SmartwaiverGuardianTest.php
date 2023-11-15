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
use Smartwaiver\Types\SmartwaiverGuardian;

/**
 * Class SmartwaiverGuardianTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverGuardianTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverGuardian with missing field: firstName');

        $guardian = SmartwaiverTypes::createGuardian();
        unset($guardian['firstName']);

        $swGuardian = new SmartwaiverGuardian($guardian);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $guardian = SmartwaiverTypes::createGuardian();
        $swGuardian = new SmartwaiverGuardian($guardian);

        $this->assertEquals($guardian['firstName'], $swGuardian->firstName);
        $this->assertEquals($guardian['middleName'], $swGuardian->middleName);
        $this->assertEquals($guardian['lastName'], $swGuardian->lastName);
        $this->assertEquals($guardian['phone'], $swGuardian->phone);
        $this->assertEquals($guardian['relationship'], $swGuardian->relationship);
    }
}
