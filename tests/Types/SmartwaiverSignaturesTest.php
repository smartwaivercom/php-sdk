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
use Smartwaiver\Types\SmartwaiverSignatures;

/**
 * Class SmartwaiverSignaturesTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverSignaturesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test whether a required keys error is generated correctly
     */
    public function testRequiredKeys()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create a SmartwaiverSignatures with missing field: waiverId');

        $signatures = SmartwaiverTypes::createSignatures();
        unset($signatures['waiverId']);

        $swSignatures = new SmartwaiverSignatures($signatures);
    }

    /**
     * Test whether all data values are correctly assigned
     */
    public function testSuccess()
    {
        $signatures = SmartwaiverTypes::createSignatures();
        $swSignatures = new SmartwaiverSignatures($signatures);

        $this->assertEquals($signatures['waiverId'], $swSignatures->waiverId);
        $this->assertEquals($signatures['templateId'], $swSignatures->templateId);
        $this->assertEquals($signatures['title'], $swSignatures->title);
        $this->assertEquals($signatures['createdOn'], $swSignatures->createdOn);

        $this->assertCount(count($signatures['signatures']['participants']), $swSignatures->participantSignatures);
        foreach($swSignatures->participantSignatures as $participantSignature) {
            $this->assertEquals('BASE64ENCODED', $participantSignature);
        }

        $this->assertCount(count($signatures['signatures']['guardian']), $swSignatures->guardianSignatures);
        foreach($swSignatures->guardianSignatures as $guardianSignature) {
            $this->assertEquals('BASE64ENCODED', $guardianSignature);
        }

        $this->assertCount(count($signatures['signatures']['bodySignatures']), $swSignatures->bodySignatures);
        foreach($swSignatures->bodySignatures as $bodySignature) {
            $this->assertEquals('BASE64ENCODED', $bodySignature);
        }

        $this->assertCount(count($signatures['signatures']['bodyInitials']), $swSignatures->bodyInitials);
        foreach($swSignatures->bodyInitials as $bodyInitial) {
            $this->assertEquals('BASE64ENCODED', $bodyInitial);
        }
    }
}
