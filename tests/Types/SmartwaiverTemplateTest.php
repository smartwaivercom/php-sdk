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
use Smartwaiver\Types\SmartwaiverTemplate;

/**
 * Class SmartwaiverTemplateTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverTemplate with missing field: templateId');

        $template = SmartwaiverTypes::createTemplate();
        unset($template['templateId']);

        $swTemplate = new SmartwaiverTemplate($template);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $template = SmartwaiverTypes::createTemplate();
        $swTemplate = new SmartwaiverTemplate($template);

        $this->assertEquals($template['templateId'], $swTemplate->templateId);
        $this->assertEquals($template['title'], $swTemplate->title);
        $this->assertEquals($template['publishedVersion'], $swTemplate->publishedVersion);
        $this->assertEquals($template['publishedOn'], $swTemplate->publishedOn);
        $this->assertEquals($template['webUrl'], $swTemplate->webUrl);
        $this->assertEquals($template['kioskUrl'], $swTemplate->kioskUrl);
        $this->assertEquals($template['vanityUrls'], $swTemplate->vanityUrls);
    }
}
