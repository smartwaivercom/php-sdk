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
 * Class SmartwaiverWebhookQueue
 *
 * This class represents information about a smartwaiver webhook queue
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWebhookQueue extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'messagesTotal',
        'messagesNotVisible',
        'messagesDelayed'
    ];

    /**
     * @var integer Number of messages in queue
     */
    public $messagesTotal;

    /**
     * @var integer Number of messages that are not visible
     */
    public $messagesNotVisible;

    /**
     * @var integer Number of messages that have a delay set
     */
    public $messagesDelayed;

    /**
     * Create a SmartwaiverWebhookQueue object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $webhookQueue The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $webhookQueue)
    {
        // Check for required keys
        parent::__construct($webhookQueue, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->messagesTotal = $webhookQueue['messagesTotal'];
        $this->messagesNotVisible = $webhookQueue['messagesNotVisible'];
        $this->messagesDelayed = $webhookQueue['messagesDelayed'];
    }
}