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
 * Class SmartwaiverTemplateStyling
 *
 * This class the settings for the styling section of a Smartwaiver Template
 *
 * @package Smartwaiver\Types\Template
 */
class SmartwaiverTemplateStyling extends SmartwaiverType implements SmartwaiverInputType
{
    const STYLE_THEME = 'theme';
    const STYLE_CUSTOM = 'custom';

    /**
     * The required fields in the constructor array to create this object
     */
    const REQUIRED_KEYS = [];

    /**
     * @var string The type of styling to use (theme or custom)
     */
    public $style;

    /**
     * @var string The hex for the custom background color
     */
    public $customBackground;

    /**
     * @var string The hex for the custom border color
     */
    public $customBorder;

    /**
     * @var string The hex for the custom shadow color
     */
    public $customShadow;

    /**
     * Create a SmartwaiverTemplateStyling object by providing an array with all
     * the required keys. See REQUIRED_KEYS for that information.
     *
     * @param array $styling  The input array containing all the information
     *
     * @throws \InvalidArgumentException Thrown if any of the required keys are missing
     */
    public function __construct(array $styling = [])
    {
        // Check for required keys
        parent::__construct($styling, self::REQUIRED_KEYS, self::class);

        // Load all the information into public variables

        // Style
        if (isset($styling['style']) && $styling['style'] != '') {
            $this->style = $styling['style'] == self::STYLE_CUSTOM ? self::STYLE_CUSTOM : self::STYLE_THEME;
        }

        // Custom Background
        if (isset($styling['custom']) && isset($styling['custom']['background'])
                && $styling['custom']['background'] != '') {
            $this->customBackground = $styling['custom']['background'];
        }

        // Custom Border
        if (isset($styling['custom']) && isset($styling['custom']['border'])
            && $styling['custom']['border'] != '') {
            $this->customBorder = $styling['custom']['border'];
        }

        // Custom Shadow
        if (isset($styling['custom']) && isset($styling['custom']['shadow'])
                && $styling['custom']['shadow'] != '') {
            $this->customShadow = $styling['custom']['shadow'];
        }
    }

    /**
     * Return the array to be passed to the api representing this object
     *
     * @return \ArrayObject
     */
    public function apiArray() {
        $ret = new \ArrayObject();

        // Style
        if (isset($this->style) && $this->style != '') {
            $ret['style'] = $this->style;
        }

        // Custom Background
        if (isset($this->customBackground) && $this->customBackground != '') {
            if (!isset($ret['custom'])) $ret['custom'] = [];
            $ret['custom']['background'] = $this->customBackground;
        }

        // Custom Border
        if (isset($this->customBorder) && $this->customBorder != '') {
            if (!isset($ret['custom'])) $ret['custom'] = [];
            $ret['custom']['border'] = $this->customBorder;
        }

        // Custom Shadow
        if (isset($this->customShadow) && $this->customShadow != '') {
            if (!isset($ret['custom'])) $ret['custom'] = [];
            $ret['custom']['shadow'] = $this->customShadow;
        }

        return $ret;
    }
}
