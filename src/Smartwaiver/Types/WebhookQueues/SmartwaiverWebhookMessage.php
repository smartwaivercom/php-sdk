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

namespace Smartwaiver\Types\WebhookQueues;

use Smartwaiver\Types\SmartwaiverType;

/**
 * Class SmartwaiverWebhookMessage
 *
 * This class represents information about a smartwaiver webhook message
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWebhookMessage extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'messageId',
        'payload'
    ];

    /**
     * @var string ID of webhook message
     */
    public $messageId;

    /**
     * @var SmartwaiverWebhookMessagePayload The payload of the message
     */
    public $payload;

    /**
     * Create a SmartwaiverWebhookMessage object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $webhookMessage The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $webhookMessage)
    {
        // Check for required keys
        parent::__construct($webhookMessage, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->messageId = $webhookMessage['messageId'];
        $this->payload = new SmartwaiverWebhookMessagePayload($webhookMessage['payload']);
    }
}