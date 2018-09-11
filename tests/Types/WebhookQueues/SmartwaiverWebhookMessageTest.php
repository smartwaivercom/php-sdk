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
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessagePayload;

/**
 * Class SmartwaiverWebhookMessageTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWebhookMessage with missing field: messageId');

        $webhookMessage = SmartwaiverTypes::createWebhookMessage();
        unset($webhookMessage['messageId']);

        $swWebhookMessage = new SmartwaiverWebhookMessage($webhookMessage);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhookMessage = SmartwaiverTypes::createWebhookMessage();
        $swWebhookMessage = new SmartwaiverWebhookMessage($webhookMessage);

        $this->assertEquals($webhookMessage['messageId'], $swWebhookMessage->messageId);
        $this->assertInstanceOf(SmartwaiverWebhookMessagePayload::class, $swWebhookMessage->payload);
    }
}
