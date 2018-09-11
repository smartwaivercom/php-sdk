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
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueue;

/**
 * Class SmartwaiverWebhookQueueTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookQueueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWebhookQueue with missing field: messagesTotal');

        $webhookQueue = SmartwaiverTypes::createWebhookQueue();
        unset($webhookQueue['messagesTotal']);

        $swWebhook = new SmartwaiverWebhookQueue($webhookQueue);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhookQueue = SmartwaiverTypes::createWebhookQueue();
        $swWebhookQueue = new SmartwaiverWebhookQueue($webhookQueue);

        $this->assertEquals($webhookQueue['messagesTotal'], $swWebhookQueue->messagesTotal);
        $this->assertEquals($webhookQueue['messagesNotVisible'], $swWebhookQueue->messagesNotVisible);
        $this->assertEquals($webhookQueue['messagesDelayed'], $swWebhookQueue->messagesDelayed);
    }
}
