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

use InvalidArgumentException;

use Smartwaiver\Exceptions\SmartwaiverSDKException;

/**
 * Class SmartwaiverType
 *
 * Base class for all types of returned objects from the API.
 *
 * @package Smartwaiver\Types
 */
class SmartwaiverType
{
    /**
     * @var array The input array the object is constructed from
     */
    protected $input;

    /**
     * SmartwaiverType constructor.
     *
     * Checks that all the required keys for the given object type exist
     *
     * @param array $input  All the data to be put into the object
     * @param array $requiredKeys  The required keys in the input
     * @param string $type  The name of the object type (for errors)
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $input, array $requiredKeys, $type)
    {
        // Save the input in case the user wants it later
        $this->input = $input;
        // Cut off the namespace of the type
        if(strpos($type, '\\') !== false)
            $type = substr($type, strrpos($type, '\\')+1);
        // Check that all required key's exist in the given input
        foreach($requiredKeys as $key) {
            if(!array_key_exists($key, $input))
                throw new InvalidArgumentException('Cannot create a '.$type.' with missing field: '.$key);
        }
    }

    /**
     * Retrieve the input array this object was constructed from
     *
     * @return array The input array
     */
    public function getArrayInput()
    {
        return $this->input;
    }
}