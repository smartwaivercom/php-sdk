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
 * Class SmartwaiverWebhookMessagePayload
 *
 * This class represents information about a webhook message payload
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWebhookMessagePayload extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'unique_id',
        'event'
    ];

    /**
     * @var string ID of waiver this webhook is for
     */
    public $uniqueId;

    /**
     * @var string The event that caused the webhook
     */
    public $event;

    /**
     * Create a SmartwaiverWebhookMessagePayload object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $webhookMessagePayload The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $webhookMessagePayload)
    {
        // Check for required keys
        parent::__construct($webhookMessagePayload, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->uniqueId = $webhookMessagePayload['unique_id'];
        $this->event = $webhookMessagePayload['event'];
    }
}