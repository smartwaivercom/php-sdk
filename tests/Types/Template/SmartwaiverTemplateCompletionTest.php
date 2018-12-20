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

use Smartwaiver\Types\Template\SmartwaiverTemplateCompletion;

/**
 * Class SmartwaiverTemplateCompletionTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateCompletionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $completion = new SmartwaiverTemplateCompletion();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $completion = new SmartwaiverTemplateCompletion();
        $this->assertFalse(isset($completion->redirectSuccess));
        $this->assertFalse(isset($completion->redirectCancel));
        $this->assertEquals(new \ArrayObject(), $completion->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'redirect' => [
                'success' => '',
                'cancel' => ''
            ]
        ];

        $completion = new SmartwaiverTemplateCompletion($input);
        $this->assertFalse(isset($completion->redirectSuccess));
        $this->assertFalse(isset($completion->redirectCancel));
        $this->assertEquals(new \ArrayObject(), $completion->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'redirect' => [
                'success' => 'test',
                'cancel' => 'test2'
            ]
        ];

        $completion = new SmartwaiverTemplateCompletion($input);
        $this->assertEquals($completion->redirectSuccess, 'test');
        $this->assertEquals($completion->redirectCancel, 'test2');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $completion = new SmartwaiverTemplateCompletion();
        $completion->redirectSuccess = '';
        $completion->redirectCancel = '';
        $this->assertEquals(new \ArrayObject(), $completion->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['redirect'] = [
            'success' => 'test',
            'cancel' => 'test2'
        ];

        $completion = new SmartwaiverTemplateCompletion();
        $completion->redirectSuccess = 'test';
        $completion->redirectCancel = 'test2';
        $this->assertEquals($expected, $completion->apiArray());
    }
}
