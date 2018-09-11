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
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessagePayload;

/**
 * Class SmartwaiverWebhookMessageBodyTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookMessagePayloadTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWebhookMessagePayload with missing field: unique_id');

        $webhookMessagePayload = SmartwaiverTypes::createWebhookMessagePayload();
        unset($webhookMessagePayload['unique_id']);

        $swWebhookPayload = new SmartwaiverWebhookMessagePayload($webhookMessagePayload);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhookMessagePayload = SmartwaiverTypes::createWebhookMessagePayload();
        $swWebhookMessagePayload = new SmartwaiverWebhookMessagePayload($webhookMessagePayload);

        $this->assertEquals($webhookMessagePayload['unique_id'], $swWebhookMessagePayload->uniqueId);
        $this->assertEquals($webhookMessagePayload['event'], $swWebhookMessagePayload->event);
    }
}
