<?php
/**
 * Copyright 2017 Smartwaiver
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
use Smartwaiver\Types\SmartwaiverWebhook;

/**
 * Class SmartwaiverWebhookTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWebhook with missing field: endpoint');

        $webhook = SmartwaiverTypes::createParticipant();
        unset($webhook['endpoint']);

        $swWebhook = new SmartwaiverWebhook($webhook);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhook = SmartwaiverTypes::createWebhook();
        $swWebhook = new SmartwaiverWebhook($webhook);

        $this->assertEquals($webhook['endpoint'], $swWebhook->endpoint);
        $this->assertEquals($webhook['emailValidationRequired'], $swWebhook->emailValidationRequired);
    }
}
