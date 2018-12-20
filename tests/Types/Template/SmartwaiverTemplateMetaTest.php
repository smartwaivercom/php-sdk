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

use Smartwaiver\Types\Template\SmartwaiverTemplateMeta;

/**
 * Class SmartwaiverTemplateMetaTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateMetaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $meta = new SmartwaiverTemplateMeta();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $meta = new SmartwaiverTemplateMeta();
        $this->assertFalse(isset($meta->title));
        $this->assertFalse(isset($meta->language));
        $this->assertEquals(new \ArrayObject(), $meta->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'title' => '',
            'locale' => [
                'locale' => ''
            ]
        ];

        $meta = new SmartwaiverTemplateMeta($input);
        $this->assertFalse(isset($meta->title));
        $this->assertFalse(isset($meta->language));
        $this->assertEquals(new \ArrayObject(), $meta->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'title' => 'test',
            'locale' => [
                'locale' => 'test2'
            ]
        ];

        $meta = new SmartwaiverTemplateMeta($input);
        $this->assertEquals($meta->title, 'test');
        $this->assertEquals($meta->language, 'test2');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $meta = new SmartwaiverTemplateMeta();
        $meta->title = '';
        $meta->language = '';
        $this->assertEquals(new \ArrayObject(), $meta->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['title'] = 'test';
        $expected['locale'] = [
            'locale' => 'test2'
        ];

        $meta = new SmartwaiverTemplateMeta();
        $meta->title = 'test';
        $meta->language = 'test2';
        $this->assertEquals($expected, $meta->apiArray());
    }
}
