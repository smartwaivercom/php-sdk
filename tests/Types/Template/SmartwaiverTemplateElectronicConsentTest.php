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

use Smartwaiver\Types\Template\SmartwaiverTemplateElectronicConsent;

/**
 * Class SmartwaiverTemplateElectronicConsentTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateElectronicConsentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether no required keys error is generated
     */
    public function testRequiredKeysEmpty()
    {
        $electronicConsent = new SmartwaiverTemplateElectronicConsent();
    }

    /**
     * Test that defaults are created correctly
     */
    public function testDefaults()
    {
        $electronicConsent = new SmartwaiverTemplateElectronicConsent();
        $this->assertFalse(isset($electronicConsent->title));
        $this->assertFalse(isset($electronicConsent->verbiage));
        $this->assertEquals(new \ArrayObject(), $electronicConsent->apiArray());
    }

    /**
     * Test that blank inputs are not stored
     */
    public function testBlankInput()
    {
        $input = [
            'title' => '',
            'verbiage' => ''
        ];

        $electronicConsent = new SmartwaiverTemplateElectronicConsent($input);
        $this->assertFalse(isset($electronicConsent->title));
        $this->assertFalse(isset($electronicConsent->verbiage));
        $this->assertEquals(new \ArrayObject(), $electronicConsent->apiArray());
    }

    /**
     * Test input
     */
    public function testInput()
    {
        $input = [
            'title' => 'test',
            'verbiage' => 'test2'
        ];

        $electronicConsent = new SmartwaiverTemplateElectronicConsent($input);
        $this->assertEquals($electronicConsent->title, 'test');
        $this->assertEquals($electronicConsent->verbiage, 'test2');
    }

    /**
     * Test that blank output checks
     */
    public function testBlankOutput()
    {
        $electronicConsent = new SmartwaiverTemplateElectronicConsent();
        $electronicConsent->title = '';
        $electronicConsent->verbiage = '';
        $this->assertEquals(new \ArrayObject(), $electronicConsent->apiArray());
    }

    /**
     * Test api array
     */
    public function testApiArray()
    {
        $expected = new \ArrayObject();
        $expected['title'] = 'test';
        $expected['verbiage'] = 'test2';

        $electronicConsent = new SmartwaiverTemplateElectronicConsent();
        $electronicConsent->title = 'test';
        $electronicConsent->verbiage = 'test2';
        $this->assertEquals($expected, $electronicConsent->apiArray());
    }
}
