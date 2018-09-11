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
 * Class SmartwaiverWebhookQueues
 *
 * This class contains information about counts in all your webhook queues.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWebhookQueues extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var SmartwaiverWebhookQueue Object representing the smartwaiver webhook queue
     */
    public $accountQueue;

    /**
     * @var SmartwaiverWebhookQueue[] Associative array of webhook queues by template ID
     */
    public $templateQueues;

    /**
     * Create a SmartwaiverWebhookQueues object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $webhookQueues The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $webhookQueues)
    {
        // Check for required keys
        parent::__construct($webhookQueues, self::REQUIRED_KEYS, self::class);

        // Set up public variables
        $this->accountQueue = null;
        $this->templateQueues = [];

        // Now parse the response
        foreach ($webhookQueues as $name => $webhookQueue) {
            if ($name == 'account') {
                $this->accountQueue = new SmartwaiverWebhookQueue($webhookQueue);
            } else {
                $templateId = substr($name, 9);

                $this->templateQueues[$templateId] = new SmartwaiverWebhookQueue($webhookQueue);
            }
        }

    }
}