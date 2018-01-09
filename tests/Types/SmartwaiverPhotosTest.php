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
use Smartwaiver\Types\SmartwaiverPhoto;
use Smartwaiver\Types\SmartwaiverPhotos;

/**
 * Class SmartwaiverPhotosTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverPhotosTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverPhotos with missing field: waiverId');

        $photos = SmartwaiverTypes::createPhotos();
        unset($photos['waiverId']);

        $swPhotos = new SmartwaiverPhotos($photos);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $photos = SmartwaiverTypes::createPhotos();
        $swPhotos = new SmartwaiverPhotos($photos);

        $this->assertEquals($photos['waiverId'], $swPhotos->waiverId);
        $this->assertEquals($photos['templateId'], $swPhotos->templateId);
        $this->assertEquals($photos['title'], $swPhotos->title);
        $this->assertEquals($photos['createdOn'], $swPhotos->createdOn);

        $this->assertCount(count($photos['photos']), $swPhotos->photos);
        foreach($swPhotos->photos as $photo) {
            $this->assertInstanceOf(SmartwaiverPhoto::class, $photo);
        }
    }
}
