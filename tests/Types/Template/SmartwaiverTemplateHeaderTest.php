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

use Smartwaiver\Types\Template\SmartwaiverTemplateHeader;

/**
 * Class SmartwaiverTemplateHeaderTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateHeaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $header = new SmartwaiverTemplateHeader();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $header = new SmartwaiverTemplateHeader();
        $this->assertFalse(isset($header->logoImage));
        $this->assertFalse(isset($header->text));
        $this->assertEquals(new \ArrayObject(), $header->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'logo' => [
                'image' => ''
            ],
            'text' => ''
        ];

        $header = new SmartwaiverTemplateHeader($input);
        $this->assertFalse(isset($header->logoImage));
        $this->assertFalse(isset($header->text));
        $this->assertEquals(new \ArrayObject(), $header->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'logo' => [
                'image' => 'test'
            ],
            'text' => 'test2'
        ];

        $header = new SmartwaiverTemplateHeader($input);
        $this->assertEquals($header->logoImage, 'test');
        $this->assertEquals($header->text, 'test2');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $header = new SmartwaiverTemplateHeader();
        $header->logoImage = '';
        $header->text = '';
        $this->assertEquals(new \ArrayObject(), $header->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['logo'] = [
            'image' => 'test'
        ];
        $expected['text'] = 'test2';

        $header = new SmartwaiverTemplateHeader();
        $header->logoImage = 'test';
        $header->text = 'test2';
        $this->assertEquals($expected, $header->apiArray());
    }
}
