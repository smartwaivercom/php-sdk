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
use Smartwaiver\Types\SmartwaiverType;

/**
 * Class SmartwaiverTypeTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that the input array is properly accessible
     */
    public function testGetInput()
    {
        $swType = new SmartwaiverType(['input'], [], '');

        $this->assertEquals(['input'], $swType->getArrayInput());
    }

    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverType with missing field: key2');

        $swType = new SmartwaiverType(['key1' => 'test'], ['key1', 'key2'], 'SmartwaiverType');
    }

    /**
     * Test that the namespace is properly removed in the error message
     */
    public function testTypeNamespace()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverType with missing field: key2');

        $swType = new SmartwaiverType(['key1' => 'test'], ['key1', 'key2'], 'Namespace\SmartwaiverType');
    }
}
