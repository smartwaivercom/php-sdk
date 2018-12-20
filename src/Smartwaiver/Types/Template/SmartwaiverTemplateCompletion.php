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

namespace Smartwaiver\Types\Template;

use Smartwaiver\Types\SmartwaiverInputType;
use Smartwaiver\Types\SmartwaiverType;

/**
 * Class SmartwaiverTemplateCompletion
 *
 * This class the settings for the completion section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateCompletion extends SmartwaiverType implements SmartwaiverInputType
{
    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string Where to redirect on success ("[transactionId"] in the URL will be replaced)
     */
    public $redirectSuccess;

    /**
     * @var string Where to redirect on cancelation
     */
    public $redirectCancel;

    /**
     * Create a SmartwaiverTemplateCompletion object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $completion  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $completion = [])
    {
        // Check for required keys
        parent::__construct($completion, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Redirect Success
        if (isset($completion['redirect']) && isset($completion['redirect']['success'])
                && $completion['redirect']['success'] != '') {
            $this->redirectSuccess = $completion['redirect']['success'];
        }

        // Redirect Cancel
        if (isset($completion['redirect']) && isset($completion['redirect']['cancel'])
            && $completion['redirect']['cancel'] != '') {
            $this->redirectCancel = $completion['redirect']['cancel'];
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Redirect Success
        if (isset($this->redirectSuccess) && $this->redirectSuccess != '') {
            if (!isset($ret['redirect'])) $ret['redirect'] = [];
            $ret['redirect']['success'] = $this->redirectSuccess;
        }

        // Redirect Cancel
        if (isset($this->redirectCancel) && $this->redirectCancel != '') {
            if (!isset($ret['redirect'])) $ret['redirect'] = [];
            $ret['redirect']['cancel'] = $this->redirectCancel;
        }

        return $ret;
    }
}
