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
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete;

/**
 * Class SmartwaiverWebhookMessageDeleteTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverWebhookMessageDeleteTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverWebhookMessageDelete with missing field: success');

        $webhookMessageDelete = SmartwaiverTypes::createWebhookMessageDelete();
        unset($webhookMessageDelete['success']);

        $swWebhookBody = new SmartwaiverWebhookMessageDelete($webhookMessageDelete);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $webhookMessageDelete = SmartwaiverTypes::createWebhookMessageDelete();
        $swWebhookMessageDelete = new SmartwaiverWebhookMessageDelete($webhookMessageDelete);

        $this->assertEquals($webhookMessageDelete['success'], $swWebhookMessageDelete->success);
    }
}
