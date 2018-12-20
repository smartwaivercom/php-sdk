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

use Smartwaiver\Types\Template\SmartwaiverTemplateStyling;

/**
 * Class SmartwaiverTemplateStylingTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateStylingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $styling = new SmartwaiverTemplateStyling();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $styling = new SmartwaiverTemplateStyling();
        $this->assertFalse(isset($styling->style));
        $this->assertFalse(isset($styling->customBackground));
        $this->assertFalse(isset($styling->customBorder));
        $this->assertFalse(isset($styling->customShadow));
        $this->assertEquals(new \ArrayObject(), $styling->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'style' => '',
            'customBackground' => '',
            'customBorder' => '',
            'customShadow' => '',
        ];

        $styling = new SmartwaiverTemplateStyling($input);
        $this->assertFalse(isset($styling->style));
        $this->assertFalse(isset($styling->customBackground));
        $this->assertFalse(isset($styling->customBorder));
        $this->assertFalse(isset($styling->customShadow));
        $this->assertEquals(new \ArrayObject(), $styling->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'style' => 'custom',
            'custom' => [
                'background' => 'test',
                'border' => 'test2',
                'shadow' => 'test3'
            ],
        ];

        $styling = new SmartwaiverTemplateStyling($input);
        $this->assertEquals($styling->style, 'custom');
        $this->assertEquals($styling->customBackground, 'test');
        $this->assertEquals($styling->customBorder, 'test2');
        $this->assertEquals($styling->customShadow, 'test3');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $styling = new SmartwaiverTemplateStyling();
        $styling->style = '';
        $styling->customBackground = '';
        $styling->customBorder = '';
        $styling->customShadow = '';
        $this->assertEquals(new \ArrayObject(), $styling->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['style'] = 'custom';
        $expected['custom'] = [
            'background' => 'test',
            'border' => 'test2',
            'shadow' => 'test3'
        ];

        $styling = new SmartwaiverTemplateStyling();
        $styling->style = SmartwaiverTemplateStyling::STYLE_CUSTOM;
        $styling->customBackground = 'test';
        $styling->customBorder = 'test2';
        $styling->customShadow = 'test3';
        $this->assertEquals($expected, $styling->apiArray());
    }
}
