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

use Smartwaiver\Types\Template\SmartwaiverTemplateBody;

/**
 * Class SmartwaiverTemplateBodyTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateBodyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $body = new SmartwaiverTemplateBody();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $body = new SmartwaiverTemplateBody();
        $this->assertFalse(isset($body->text));
        $this->assertEquals(new \ArrayObject(), $body->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'text' => ''
        ];

        $body = new SmartwaiverTemplateBody($input);
        $this->assertFalse(isset($body->text));
        $this->assertEquals(new \ArrayObject(), $body->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'text' => 'test'
        ];

        $completion = new SmartwaiverTemplateBody($input);
        $this->assertEquals($completion->text, 'test');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $body = new SmartwaiverTemplateBody();
        $body->text = '';
        $this->assertEquals(new \ArrayObject(), $body->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['text'] = 'test';

        $body = new SmartwaiverTemplateBody();
        $body->text = 'test';
        $this->assertEquals($expected, $body->apiArray());
    }
}
