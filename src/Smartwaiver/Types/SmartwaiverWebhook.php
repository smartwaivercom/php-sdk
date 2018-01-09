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

namespace Smartwaiver\Types;

/**
 * Class SmartwaiverWebhook
 *
 * This class represents a webhook configuration.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverWebhook extends SmartwaiverType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [
        'endpoint',
        'emailValidationRequired'
    ];

    /**
     * Represents the setting for webhooks only being sent after email
     * verification has occurred
     */
    const WEBHOOK_AFTER_EMAIL_ONLY = 'yes';

    /**
     * Represents the setting for webhooks being sent right after waiver is
     * signed
     */
    const WEBHOOK_BEFORE_EMAIL_ONLY = 'no';

    /**
     * Represents the setting for webhooks being sent both before email
     * verification has occurred and after
     */
    const WEBHOOK_BEFORE_AND_AFTER_EMAIL = 'both';

    /**
     * @var string URL that webhooks will be sent too
     */
    public $endpoint;

    /**
     * @var string When webhooks will be sent, use constants for this setting
     */
    public $emailValidationRequired;

    /**
     * Create a SmartwaiverWebhook object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $webhook The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $webhook)
    {
        // Check for required keys
        parent::__construct($webhook, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables
        $this->endpoint = $webhook['endpoint'];
        $this->emailValidationRequired = $webhook['emailValidationRequired'];
    }
}