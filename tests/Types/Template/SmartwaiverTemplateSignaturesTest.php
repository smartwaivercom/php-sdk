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

use Smartwaiver\Types\Template\SmartwaiverTemplateSignatures;

/**
 * Class SmartwaiverTemplateSignaturesTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateSignaturesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $signatures = new SmartwaiverTemplateSignatures();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $signatures = new SmartwaiverTemplateSignatures();
        $this->assertFalse(isset($signatures->type));
        $this->assertFalse(isset($signatures->minor));
        $this->assertFalse(isset($signatures->defaultChoice));
        $this->assertEquals(new \ArrayObject(), $signatures->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'type' => '',
            'defaultChoice' => ''
        ];

        $signatures = new SmartwaiverTemplateSignatures($input);
        $this->assertFalse(isset($signatures->type));
        $this->assertFalse(isset($signatures->defaultChoice));
        $this->assertEquals(new \ArrayObject(), $signatures->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'type' => 'test',
            'minor' => false,
            'defaultChoice' => 'test2'
        ];

        $signatures = new SmartwaiverTemplateSignatures($input);
        $this->assertEquals($signatures->type, 'test');
        $this->assertEquals($signatures->minor, false);
        $this->assertEquals($signatures->defaultChoice, 'test2');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $signatures = new SmartwaiverTemplateSignatures();
        $signatures->type = '';
        $signatures->defaultChoice = '';
        $this->assertEquals(new \ArrayObject(), $signatures->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['type'] = 'test';
        $expected['minor'] = false;
        $expected['defaultChoice'] = 'test2';

        $signatures = new SmartwaiverTemplateSignatures();
        $signatures->type = 'test';
        $signatures->minor = false;
        $signatures->defaultChoice = 'test2';
        $this->assertEquals($expected, $signatures->apiArray());
    }
}
