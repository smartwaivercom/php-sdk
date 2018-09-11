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

use Smartwaiver\Tests\Factories\SmartwaiverTypes;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueues;

/**
 * Class SmartwaiverWebhookQueuesTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookQueuesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $swWebhookQueues = new SmartwaiverWebhookQueues([]);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhookQueues = SmartwaiverTypes::createWebhookQueues();
        $swWebhookQueues = new SmartwaiverWebhookQueues($webhookQueues);

        $this->assertNotNull($swWebhookQueues->accountQueue);
        $this->assertEquals($webhookQueues['account']['messagesTotal'], $swWebhookQueues->accountQueue->messagesTotal);
        $this->assertEquals($webhookQueues['account']['messagesNotVisible'], $swWebhookQueues->accountQueue->messagesNotVisible);
        $this->assertEquals($webhookQueues['account']['messagesDelayed'], $swWebhookQueues->accountQueue->messagesDelayed);

        $this->assertCount(1, $swWebhookQueues->templateQueues);
        $this->assertEquals($webhookQueues['template-4fc7d12601941']['messagesTotal'], $swWebhookQueues->templateQueues['4fc7d12601941']->messagesTotal);
        $this->assertEquals($webhookQueues['template-4fc7d12601941']['messagesNotVisible'], $swWebhookQueues->templateQueues['4fc7d12601941']->messagesNotVisible);
        $this->assertEquals($webhookQueues['template-4fc7d12601941']['messagesDelayed'], $swWebhookQueues->templateQueues['4fc7d12601941']->messagesDelayed);
    }
}
