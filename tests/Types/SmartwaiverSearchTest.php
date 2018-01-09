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
use Smartwaiver\Types\SmartwaiverSearch;

/**
 * Class SmartwaiverSearchTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverSearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverSearch with missing field: guid');

        $search = SmartwaiverTypes::createSearch();
        unset($search['guid']);

        $swSearch = new SmartwaiverSearch($search);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $search = SmartwaiverTypes::createSearch();
        $swSearch = new SmartwaiverSearch($search);

        $this->assertEquals($search['guid'], $swSearch->guid);
        $this->assertEquals($search['count'], $swSearch->count);
        $this->assertEquals($search['pages'], $swSearch->pages);
        $this->assertEquals($search['pageSize'], $swSearch->pageSize);
    }
}
