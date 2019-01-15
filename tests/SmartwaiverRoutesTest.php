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

use GuzzleHttp\Psr7\Response;
use Smartwaiver\SmartwaiverRoutes;

/**
 * Class SmartwaiverRoutesTest
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverRoutesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Base URI for all URLs
     */
    const BASE_URI = 'https://api.smartwaiver.com';

    /**
     * Test get waiver templates route
     */
    public function testGetWaiverTemplates()
    {
        $url = SmartwaiverRoutes::getWaiverTemplates();
        $this->assertEquals(self::BASE_URI . '/v4/templates', $url);
    }

    /**
     * Test get waiver template route
     */
    public function testGetWaiverTemplate()
    {
        $url = SmartwaiverRoutes::getWaiverTemplate('TestingTemplateId');
        $this->assertEquals(self::BASE_URI . '/v4/templates/TestingTemplateId', $url);
    }

    /**
     * Test get waiver summaries route
     */
    public function testGetWaiverSummaries()
    {
        $url = SmartwaiverRoutes::getWaiverSummaries();
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(5);
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=5', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, true);
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&verified=true', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, 'TestingTemplateId');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&templateId=TestingTemplateId', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, '', '2016-11-01 00:00:00');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&fromDts='.urlencode('2016-11-01 00:00:00'), $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, '', '', '2016-11-01 00:00:00');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&toDts='.urlencode('2016-11-01 00:00:00'), $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, '', '', '', 'Kyle');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&firstName=Kyle', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, '', '', '', '', 'Smith');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&lastName=Smith', $url);

        $url = SmartwaiverRoutes::getWaiverSummaries(20, null, '', '', '', '', '', 'testing');
        $this->assertEquals(self::BASE_URI . '/v4/waivers?limit=20&tag=testing', $url);
    }

    /**
     * Test get waiver route
     */
    public function testGetWaiver()
    {
        $url = SmartwaiverRoutes::getWaiver('TestingWaiverId');
        $this->assertEquals(self::BASE_URI . '/v4/waivers/TestingWaiverId?pdf=false', $url);

        $url = SmartwaiverRoutes::getWaiver('TestingWaiverId', false);
        $this->assertEquals(self::BASE_URI . '/v4/waivers/TestingWaiverId?pdf=false', $url);

        $url = SmartwaiverRoutes::getWaiver('TestingWaiverId', true);
        $this->assertEquals(self::BASE_URI . '/v4/waivers/TestingWaiverId?pdf=true', $url);
    }

    /**
     * Test get waiver photos route
     */
    public function testGetWaiverPhotos()
    {
        $url = SmartwaiverRoutes::getWaiverPhotos('TestingWaiverId');
        $this->assertEquals(self::BASE_URI . '/v4/waivers/TestingWaiverId/photos', $url);
    }

    /**
     * Test get waiver signatures route
     */
    public function testGetWaiverSignatures()
    {
        $url = SmartwaiverRoutes::getWaiverSignatures('TestingWaiverId');
        $this->assertEquals(self::BASE_URI . '/v4/waivers/TestingWaiverId/signatures', $url);
    }

    /**
     * Test search route
     */
    public function testSearch()
    {
        $url = SmartwaiverRoutes::search();
        $this->assertEquals(self::BASE_URI . '/v4/search', $url);

        $url = SmartwaiverRoutes::search('TestingTemplateId');
        $this->assertEquals(self::BASE_URI . '/v4/search?templateId=TestingTemplateId', $url);

        $url = SmartwaiverRoutes::search('', '2016-11-01 00:00:00');
        $this->assertEquals(self::BASE_URI . '/v4/search?fromDts='.urlencode('2016-11-01 00:00:00'), $url);

        $url = SmartwaiverRoutes::search('', '', '2016-11-01 00:00:00');
        $this->assertEquals(self::BASE_URI . '/v4/search?toDts='.urlencode('2016-11-01 00:00:00'), $url);

        $url = SmartwaiverRoutes::search('', '', '', 'Kyle');
        $this->assertEquals(self::BASE_URI . '/v4/search?firstName='.urlencode('Kyle'), $url);

        $url = SmartwaiverRoutes::search('', '', '', '', 'Smith');
        $this->assertEquals(self::BASE_URI . '/v4/search?lastName='.urlencode('Smith'), $url);

        $url = SmartwaiverRoutes::search('', '', '', '', '', true);
        $this->assertEquals(self::BASE_URI . '/v4/search?verified=true', $url);

        $url = SmartwaiverRoutes::search('', '', '', '', '', false);
        $this->assertEquals(self::BASE_URI . '/v4/search?verified=false', $url);

        $url = SmartwaiverRoutes::search('', '', '', '', '', null, true);
        $this->assertEquals(self::BASE_URI . '/v4/search', $url);

        $url = SmartwaiverRoutes::search('', '', '', '', '', null, false);
        $this->assertEquals(self::BASE_URI . '/v4/search?sort=asc', $url);

        $url = SmartwaiverRoutes::search('', '', '', '', '', null, true, 'testing');
        $this->assertEquals(self::BASE_URI . '/v4/search?tag=testing', $url);

        $url = SmartwaiverRoutes::search('', '', '', 'Kyle', 'Smith');
        $this->assertEquals(self::BASE_URI . '/v4/search?firstName='.urlencode('Kyle').'&lastName='.urlencode('Smith'), $url);
    }

    /**
     * Test search results route
     */
    public function testSearchResults()
    {
        $url = SmartwaiverRoutes::searchResults('TestingGUID', 0);
        $this->assertEquals(self::BASE_URI . '/v4/search/TestingGUID/results?page=0', $url);

        $url = SmartwaiverRoutes::searchResults('TestingGUID', 1);
        $this->assertEquals(self::BASE_URI . '/v4/search/TestingGUID/results?page=1', $url);
    }

    /**
     * Test get webhook config route
     */
    public function testGetWebhookConfig()
    {
        $url = SmartwaiverRoutes::getWebhookConfig();
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/configure', $url);
    }

    /**
     * Test set webhook config route
     */
    public function testSetWebhookConfig()
    {
        $url = SmartwaiverRoutes::setWebhookConfig();
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/configure', $url);
    }

    /**
     * Test delete webhook config route
     */
    public function testDeleteWebhookConfig()
    {
        $url = SmartwaiverRoutes::deleteWebhookConfig();
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/configure', $url);
    }

    /**
     * Test webhook queues route
     */
    public function testWebhookQueues()
    {
        $url = SmartwaiverRoutes::getWebhookQueues();
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues', $url);
    }

    /**
     * Test webhook queues account message route
     */
    public function testWebhookQueueAccountMessage()
    {
        $url = SmartwaiverRoutes::getWebhookQueueAccountMessage();
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/account?delete=false', $url);

        $url = SmartwaiverRoutes::getWebhookQueueAccountMessage(false);
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/account?delete=false', $url);

        $url = SmartwaiverRoutes::getWebhookQueueAccountMessage(true);
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/account?delete=true', $url);
    }

    /**
     * Test webhook queues template message route
     */
    public function testWebhookQueueTemplateMessage()
    {
        $url = SmartwaiverRoutes::getWebhookQueueTemplateMessage('TestingGUID');
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/template/TestingGUID?delete=false', $url);

        $url = SmartwaiverRoutes::getWebhookQueueTemplateMessage('TestingGUID', false);
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/template/TestingGUID?delete=false', $url);

        $url = SmartwaiverRoutes::getWebhookQueueTemplateMessage('TestingGUID', true);
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/template/TestingGUID?delete=true', $url);
    }

    /**
     * Test webhook queues account message delete route
     */
    public function testWebhookQueueAccountMessageDelete()
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueAccountMessage('MessageID');
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/account/MessageID', $url);
    }

    /**
     * Test webhook queues template message delete route
     */
    public function testWebhookQueueTemplateMessageDelete()
    {
        $url = SmartwaiverRoutes::deleteWebhookQueueTemplateMessage('TestingGUID', 'MessageID');
        $this->assertEquals(self::BASE_URI . '/v4/webhooks/queues/template/TestingGUID/MessageID', $url);
    }

    /**
     * Test create dynamic template route
     */
    public function testCreateDynamicTemplate()
    {
        $url = SmartwaiverRoutes::createDynamicTemplate();
        $this->assertEquals(self::BASE_URI . '/v4/dynamic/templates', $url);
    }

    /**
     * Test process dynamic waiver route
     */
    public function testProcessDynamicTemplate()
    {
        $url = SmartwaiverRoutes::processDynamicTemplate('TestingGUID');
        $this->assertEquals(self::BASE_URI . '/v4/dynamic/process/TestingGUID', $url);
    }
}