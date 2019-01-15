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

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;

use Smartwaiver\SmartwaiverRawResponse;
use Smartwaiver\SmartwaiverResponse;
use Smartwaiver\Tests\Factories\APISuccessResponses;

use Smartwaiver\Smartwaiver;
use Smartwaiver\Types\Data\SmartwaiverTemplateData;
use Smartwaiver\Types\SmartwaiverDynamicProcess;
use Smartwaiver\Types\SmartwaiverDynamicTemplate;
use Smartwaiver\Types\SmartwaiverPhotos;
use Smartwaiver\Types\SmartwaiverSearch;
use Smartwaiver\Types\SmartwaiverSignatures;
use Smartwaiver\Types\SmartwaiverTemplate;
use Smartwaiver\Types\SmartwaiverWaiver;
use Smartwaiver\Types\SmartwaiverWaiverSummary;
use Smartwaiver\Types\SmartwaiverWebhook;
use Smartwaiver\Types\Template\SmartwaiverTemplateConfig;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete;
use Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueues;

/**
 * Class SmartwaiverTest
 *
 * This class tests the specific responsibilities of the Smartwaiver class,
 * namely, turning the function calls with certain parameters into the correct
 * HTTP route calls.
 *
 * @package Smartwaiver\Tests
 */
class SmartwaiverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * API Key used for tests
     */
    const TEST_API_KEY = 'TestApiKey';

    /**
     * Test the 'getWaiverTemplates' function.
     */
    public function testGetWaiverTemplates()
    {
        $numTemplates = 3;
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::templates($numTemplates));

        $templates = $sw->getWaiverTemplates();

        $this->assertCount($numTemplates, $templates);
        foreach($templates as $template) {
            $this->assertInstanceOf(SmartwaiverTemplate::class, $template);
        }

        $this->checkGetRequests($container, ['/v4/templates']);
    }

    /**
     * Test the 'getWaiverTemplate' function.
     */
    public function testGetWaiverTemplate()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::template());

        $template = $sw->getWaiverTemplate('TestingTemplateId');
        $this->assertInstanceOf(SmartwaiverTemplate::class, $template);

        $this->checkGetRequests($container, ['/v4/templates/TestingTemplateId']);
    }

    /**
     * Test the getWaivers function with default parameters
     */
    public function testGetWaiversDefault()
    {
        $numWaivers = 5;
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waivers($numWaivers));

        $waivers = $sw->getWaiverSummaries();

        $this->assertCount($numWaivers, $waivers);
        foreach($waivers as $waiver) {
            $this->assertInstanceOf(SmartwaiverWaiverSummary::class, $waiver);
        }

        $this->checkGetRequests($container, ['/v4/waivers?limit=20']);
    }

    /**
     * Test all the individual parameters
     */
    public function testGetWaiversParams()
    {
        $paths = [
            '/v4/waivers?limit=5',
            '/v4/waivers?limit=20&verified=true',
            '/v4/waivers?limit=20&templateId=alkagaldeab',
            '/v4/waivers?limit=20&fromDts='.urlencode('2016-11-01 00:00:00'),
            '/v4/waivers?limit=20&toDts='.urlencode('2016-11-01 00:00:00'),
            '/v4/waivers?limit=20&firstName=Kyle',
            '/v4/waivers?limit=20&lastName=Smith',
            '/v4/waivers?limit=20&tag=testing'
        ];

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waivers(1), count($paths));

        $sw->getWaiverSummaries(5);
        $sw->getWaiverSummaries(20, true);
        $sw->getWaiverSummaries(20, null, 'alkagaldeab');
        $sw->getWaiverSummaries(20, null, '', '2016-11-01 00:00:00');
        $sw->getWaiverSummaries(20, null, '', '', '2016-11-01 00:00:00');
        $sw->getWaiverSummaries(20, null, '', '', '', 'Kyle');
        $sw->getWaiverSummaries(20, null, '', '', '', '', 'Smith');
        $sw->getWaiverSummaries(20, null, '', '', '', '', '', 'testing');

        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the getWaiver function
     */
    public function testGetWaiver()
    {
        $paths = [
            '/v4/waivers/6jebdfxzvrdkd?pdf=false',
            '/v4/waivers/6jebdfxzvrdkd?pdf=false',
            '/v4/waivers/6jebdfxzvrdkd?pdf=true',
        ];

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waiver(), count($paths));

        $waiver = $sw->getWaiver('6jebdfxzvrdkd');
        $this->assertInstanceOf(SmartwaiverWaiver::class, $waiver);

        $sw->getWaiver('6jebdfxzvrdkd', false);
        $sw->getWaiver('6jebdfxzvrdkd', true);

        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the getWaiverPhotos function
     */
    public function testGetWaiverPhotos()
    {
        $response = APISuccessResponses::photos(1);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $response, 1);

        $photos = $sw->getWaiverPhotos('6jebdfxzvrdkd');
        $this->assertInstanceOf(SmartwaiverPhotos::class, $photos);

        $paths = ['/v4/waivers/6jebdfxzvrdkd/photos'];
        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the getWaiverSignatures function
     */
    public function testGetWaiverSignatures()
    {
        $response = APISuccessResponses::signatures(1, 1, 1);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $response, 1);

        $signatures = $sw->getWaiverSignatures('6jebdfxzvrdkd');
        $this->assertInstanceOf(SmartwaiverSignatures::class, $signatures);

        $paths = ['/v4/waivers/6jebdfxzvrdkd/signatures'];
        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the search function with default parameters
     */
    public function testSearchDefault()
    {
        $guid = 'TestingGUID';
        $count = 105;
        $pageSize = 100;

        $apiResponse = APISuccessResponses::search($guid, $count, $pageSize);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse);

        $search = $sw->search();

        $this->assertEquals($guid, $search->guid);
        $this->assertEquals($count, $search->count);
        $this->assertEquals(2, $search->pages);
        $this->assertEquals(100, $search->pageSize);

        $this->checkGetRequests($container, ['/v4/search']);
    }

    /**
     * Test the search function with default parameters
     */
    public function testSearchParams()
    {
        $guid = 'TestingGUID';
        $count = 105;
        $pageSize = 100;

        $apiResponse = APISuccessResponses::search($guid, $count, $pageSize);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse, 15);

        $sw->search();
        $sw->search('testing123');
        $sw->search('', '2017-01-01');
        $sw->search('', '', '2017-01-02');
        $sw->search('', '2017-01-01', '2017-01-02');
        $sw->search('', '', '', 'Kyle');
        $sw->search('', '', '', '', 'Smith');
        $sw->search('', '', '', 'Kyle', 'Smith');
        $sw->search('', '', '', '', '', true);
        $sw->search('', '', '', '', '', false);
        $sw->search('', '', '', '', '', null);
        $sw->search('', '', '', '', '', null, true);
        $sw->search('', '', '', '', '', null, false);
        $sw->search('', '', '', '', '', null, true, 'testing');
        $sw->search('testing123', '', '', '', '', true);

        $this->checkGetRequests($container, [
            '/v4/search',
            '/v4/search?templateId=testing123',
            '/v4/search?fromDts=2017-01-01',
            '/v4/search?toDts=2017-01-02',
            '/v4/search?fromDts=2017-01-01&toDts=2017-01-02',
            '/v4/search?firstName=Kyle',
            '/v4/search?lastName=Smith',
            '/v4/search?firstName=Kyle&lastName=Smith',
            '/v4/search?verified=true',
            '/v4/search?verified=false',
            '/v4/search',
            '/v4/search',
            '/v4/search?sort=asc',
            '/v4/search?tag=testing',
            '/v4/search?templateId=testing123&verified=true'
        ]);
    }

    /**
     * Test the search results function
     */
    public function testSearchResults()
    {
        $search = new SmartwaiverSearch([
            'guid' => 'TestingGUID',
            'count' => 5,
            'pages' => 1,
            'pageSize' => 100
        ]);

        $numWaivers = 5;

        $apiResponse = APISuccessResponses::searchResults($numWaivers);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse);

        $waivers = $sw->searchResult($search, 0);

        $this->assertCount($numWaivers, $waivers);
        foreach($waivers as $waiver) {
            $this->assertInstanceOf(SmartwaiverWaiver::class, $waiver);
        }

        $this->checkGetRequests($container, [
            '/v4/search/' . $search->guid . '/results?page=0'
        ]);
    }

    /**
     * Test the search results function
     */
    public function testSearchResultsByGuid()
    {
        $guid = 'TestingGUID';
        $numWaivers = 5;

        $apiResponse = APISuccessResponses::searchResults($numWaivers);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse);

        $waivers = $sw->searchResultByGuid($guid, 0);

        $this->assertCount($numWaivers, $waivers);
        foreach($waivers as $waiver) {
            $this->assertInstanceOf(SmartwaiverWaiver::class, $waiver);
        }

        $this->checkGetRequests($container, [
            '/v4/search/' . $guid . '/results?page=0'
        ]);
    }

    /**
     * Test the getWebhookConfig function
     */
    public function testGetWebhookConfig()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $webhook = $sw->getWebhookConfig();
        $this->assertInstanceOf(SmartwaiverWebhook::class, $webhook);

        $this->checkGetRequests($container, ['/v4/webhooks/configure']);
    }

    /**
     * Test the setWebhookConfig function
     */
    public function testSetWebhookConfig()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $webhook = $sw->setWebhookConfig(
            'https://endpoint.example.org',
            SmartwaiverWebhook::WEBHOOK_BEFORE_AND_AFTER_EMAIL
        );
        $this->assertInstanceOf(SmartwaiverWebhook::class, $webhook);

        // Check that the right requests were sent
        $this->checkPutRequests($container, ['/v4/webhooks/configure'], [
            '{"endpoint":"https:\/\/endpoint.example.org","emailValidationRequired":"both"}'
        ]);
    }

    /**
     * Test the deleteWebhookConfig function
     */
    public function testDeleteWebhookConfig()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $sw->deleteWebhookConfig();

        $this->checkDeleteRequests($container, ['/v4/webhooks/configure']);
    }

    /**
     * Test the setWebhook function
     */
    public function testSetWebhook()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $swWebhook = new SmartwaiverWebhook([
            'endpoint' => 'https://endpoint.example.org',
            'emailValidationRequired' => SmartwaiverWebhook::WEBHOOK_BEFORE_AND_AFTER_EMAIL
        ]);

        $webhook = $sw->setWebhook($swWebhook);
        $this->assertInstanceOf(SmartwaiverWebhook::class, $webhook);

        // Check that the right requests were sent
        $this->checkPutRequests($container, ['/v4/webhooks/configure'], [
            '{"endpoint":"https:\/\/endpoint.example.org","emailValidationRequired":"both"}'
        ]);
    }

    /**
     * Test the getWebhookQueues function
     */
    public function testGetWebhookQueues()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueues());

        $webhook = $sw->getWebhookQueues();
        $this->assertInstanceOf(SmartwaiverWebhookQueues::class, $webhook);

        $this->checkGetRequests($container, ['/v4/webhooks/queues']);
    }

    /**
     * Test the getWebhookQueueAccountMessage function
     */
    public function testGetWebhookQueueAccountMessage()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueAccountMessage(), 3);

        $webhook = $sw->getWebhookQueueAccountMessage();
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $webhook = $sw->getWebhookQueueAccountMessage(false);
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $webhook = $sw->getWebhookQueueAccountMessage(true);
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $this->checkGetRequests($container, [
            '/v4/webhooks/queues/account?delete=false',
            '/v4/webhooks/queues/account?delete=false',
            '/v4/webhooks/queues/account?delete=true'
        ]);
    }

    /**
     * Test the getWebhookQueueAccountMessage function for null response
     */
    public function testGetWebhookQueueAccountMessageEmpty()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueAccountMessageNull());

        $webhook = $sw->getWebhookQueueAccountMessage();
        $this->assertNull($webhook);

        $this->checkGetRequests($container, ['/v4/webhooks/queues/account?delete=false']);
    }

    /**
     * Test the getWebhookQueueTemplateMessage function
     */
    public function testGetWebhookQueueTemplateMessage()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueTemplateMessage(), 3);

        $webhook = $sw->getWebhookQueueTemplateMessage('TestingGUID');
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $webhook = $sw->getWebhookQueueTemplateMessage('TestingGUID', false);
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $webhook = $sw->getWebhookQueueTemplateMessage('TestingGUID', true);
        $this->assertInstanceOf(SmartwaiverWebhookMessage::class, $webhook);

        $this->checkGetRequests($container, [
            '/v4/webhooks/queues/template/TestingGUID?delete=false',
            '/v4/webhooks/queues/template/TestingGUID?delete=false',
            '/v4/webhooks/queues/template/TestingGUID?delete=true'
        ]);
    }

    /**
     * Test the getWebhookQueueTemplateMessage function for null response
     */
    public function testGetWebhookQueueTemplateMessageEmpty()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueTemplateMessageNull());

        $webhook = $sw->getWebhookQueueTemplateMessage('TestingGUID');
        $this->assertNull($webhook);

        $this->checkGetRequests($container, ['/v4/webhooks/queues/template/TestingGUID?delete=false']);
    }

    /**
     * Test the deleteWebhookQueueAccountMessage function
     */
    public function testDeleteWebhookQueueAccountMessage()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueAccountMessageDelete());

        $webhook = $sw->deleteWebhookQueueAccountMessage('MessageID');
        $this->assertInstanceOf(SmartwaiverWebhookMessageDelete::class, $webhook);

        $this->checkDeleteRequests($container, ['/v4/webhooks/queues/account/MessageID']);
    }

    /**
     * Test the deleteWebhookQueueTemplateMessage function
     */
    public function testDeleteWebhookQueueTemplateMessage()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueTemplateMessageDelete());

        $webhook = $sw->deleteWebhookQueueTemplateMessage('TestingGUID', 'MessageID');
        $this->assertInstanceOf(SmartwaiverWebhookMessageDelete::class, $webhook);

        $this->checkDeleteRequests($container, ['/v4/webhooks/queues/template/TestingGUID/MessageID']);
    }

    /**
     * Test the createDynamicTemplate function
     */
    public function testCreateDynamicTemplate()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::createDynamicTemplate());

        $template = $sw->createDynamicTemplate(new SmartwaiverTemplateConfig(), new SmartwaiverTemplateData(), 300);
        $this->assertInstanceOf(SmartwaiverDynamicTemplate::class, $template);

        $this->checkPostRequests($container, ['/v4/dynamic/templates'], [
            '{"dynamic":{"expiration":300,"template":{},"data":{}}}'
        ]);
    }

    /**
     * Test the processDynamicTemplate function
     */
    public function testProcessDynamicTemplate()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::dynamicProcess());

        $process = $sw->processDynamicTemplate('transactionId');
        $this->assertInstanceOf(SmartwaiverDynamicProcess::class, $process);

        $this->checkPostRequests($container, ['/v4/dynamic/process/transactionId'], []);
    }

    /**
     * Test the 'getWaiverTemplatesRaw' function.
     */
    public function testGetWaiverTemplatesRaw()
    {
        $numTemplates = 3;
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::templates($numTemplates));

        $response = $sw->getWaiverTemplatesRaw();

        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/templates']);
    }

    /**
     * Test the 'getWaiverTemplateRaw' function.
     */
    public function testGetWaiverTemplateRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::template());

        $response = $sw->getWaiverTemplateRaw('TestingTemplateId');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/templates/TestingTemplateId']);
    }

    /**
     * Test the 'getWaiversRaw' function with default parameters
     */
    public function testGetWaiversDefaultRaw()
    {
        $numWaivers = 5;
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waivers($numWaivers));

        $response = $sw->getWaiverSummariesRaw();
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/waivers?limit=20']);
    }

    /**
     * Test all the individual parameters
     */
    public function testGetWaiversRawParams()
    {
        $paths = [
            '/v4/waivers?limit=5',
            '/v4/waivers?limit=20&verified=true',
            '/v4/waivers?limit=20&templateId=alkagaldeab',
            '/v4/waivers?limit=20&fromDts='.urlencode('2016-11-01 00:00:00'),
            '/v4/waivers?limit=20&toDts='.urlencode('2016-11-01 00:00:00'),
            '/v4/waivers?limit=20&firstName=Kyle',
            '/v4/waivers?limit=20&lastName=Smith',
            '/v4/waivers?limit=20&tag=testing'
        ];

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waivers(1), count($paths));

        $sw->getWaiverSummariesRaw(5);
        $sw->getWaiverSummariesRaw(20, true);
        $sw->getWaiverSummariesRaw(20, null, 'alkagaldeab');
        $sw->getWaiverSummariesRaw(20, null, '', '2016-11-01 00:00:00');
        $sw->getWaiverSummariesRaw(20, null, '', '', '2016-11-01 00:00:00');
        $sw->getWaiverSummariesRaw(20, null, '', '', '', 'Kyle');
        $sw->getWaiverSummariesRaw(20, null, '', '', '', '', 'Smith');
        $sw->getWaiverSummariesRaw(20, null, '', '', '', '', '', 'testing');

        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the 'getWaiverRaw' function
     */
    public function testGetWaiverRaw()
    {
        $paths = [
            '/v4/waivers/6jebdfxzvrdkd?pdf=false',
            '/v4/waivers/6jebdfxzvrdkd?pdf=false',
            '/v4/waivers/6jebdfxzvrdkd?pdf=true',
        ];

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::waiver(), count($paths));

        $response = $sw->getWaiverRaw('6jebdfxzvrdkd');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $sw->getWaiverRaw('6jebdfxzvrdkd', false);
        $sw->getWaiverRaw('6jebdfxzvrdkd', true);

        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the 'getWebhookRaw' function
     */
    public function testGetWaiverPhotosRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::photos(1));

        $response = $sw->getWaiverPhotosRaw('6jebdfxzvrdkd');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/waivers/6jebdfxzvrdkd/photos']);
    }

    /**
     * Test the search function with default parameters
     */
    public function testSearchRaw()
    {
        $paths = [
            '/v4/search',
            '/v4/search?templateId=testing123',
            '/v4/search?fromDts=2017-01-01',
            '/v4/search?toDts=2017-01-02',
            '/v4/search?fromDts=2017-01-01&toDts=2017-01-02',
            '/v4/search?firstName=Kyle',
            '/v4/search?lastName=Smith',
            '/v4/search?firstName=Kyle&lastName=Smith',
            '/v4/search?verified=true',
            '/v4/search?verified=false',
            '/v4/search',
            '/v4/search',
            '/v4/search?sort=asc',
            '/v4/search?tag=testing',
            '/v4/search?templateId=testing123&verified=true'
        ];

        $guid = 'TestingGUID';
        $count = 105;
        $pageSize = 100;

        $apiResponse = APISuccessResponses::search($guid, $count, $pageSize);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse, 15);

        $response = $sw->searchRaw();
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $sw->searchRaw('testing123');
        $sw->searchRaw('', '2017-01-01');
        $sw->searchRaw('', '', '2017-01-02');
        $sw->searchRaw('', '2017-01-01', '2017-01-02');
        $sw->searchRaw('', '', '', 'Kyle');
        $sw->searchRaw('', '', '', '', 'Smith');
        $sw->searchRaw('', '', '', 'Kyle', 'Smith');
        $sw->searchRaw('', '', '', '', '', true);
        $sw->searchRaw('', '', '', '', '', false);
        $sw->searchRaw('', '', '', '', '', null);
        $sw->searchRaw('', '', '', '', '', null, true);
        $sw->searchRaw('', '', '', '', '', null, false);
        $sw->searchRaw('', '', '', '', '', null, true, 'testing');
        $sw->searchRaw('testing123', '', '', '', '', true);

        $this->checkGetRequests($container, $paths);
    }

    /**
     * Test the search results function
     */
    public function testSearchResultsByGuidRaw()
    {
        $guid = 'TestingGUID';
        $numWaivers = 5;

        $apiResponse = APISuccessResponses::searchResults($numWaivers);

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, $apiResponse);

        $response = $sw->searchResultByGuidRaw($guid, 0);
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, [
            '/v4/search/' . $guid . '/results?page=0'
        ]);
    }

    /**
     * Test the 'getWebhookRaw' function
     */
    public function testGetWebhookRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $response = $sw->getWebhookConfigRaw();
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/webhooks/configure']);
    }

    /**
     * Test the 'setWebhookConfigRaw' function
     */
    public function testSetWebhookConfigRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhooks());

        $response = $sw->setWebhookConfigRaw(
            'https://endpoint.example.org',
            SmartwaiverWebhook::WEBHOOK_BEFORE_AND_AFTER_EMAIL
        );
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        // Check that the right requests were sent
        $this->checkPutRequests($container, ['/v4/webhooks/configure'], [
            '{"endpoint":"https:\/\/endpoint.example.org","emailValidationRequired":"both"}'
        ]);
    }

    /**
     * Test the 'getWebhookQueuesRaw' function
     */
    public function testGetWebhookQueuesRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueues());

        $response = $sw->getWebhookQueuesRaw();
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/webhooks/queues']);
    }

    /**
     * Test the 'getWebhookQueueAccountMessageRaw' function
     */
    public function testGetWebhookQueueAccountMessageRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueAccountMessage());

        $response = $sw->getWebhookQueueAccountMessageRaw();
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/webhooks/queues/account?delete=false']);
    }

    /**
     * Test the 'getWebhookQueueTemplateMessageRaw' function
     */
    public function testGetWebhookQueueTemplateMessageRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueTemplateMessage());

        $response = $sw->getWebhookQueueTemplateMessageRaw('TestingGUID');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkGetRequests($container, ['/v4/webhooks/queues/template/TestingGUID?delete=false']);
    }

    /**
     * Test the 'deleteWebhookQueueAccountMessageRaw' function
     */
    public function testDeleteWebhookQueueAccountMessageRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueAccountMessageDelete());

        $response = $sw->deleteWebhookQueueAccountMessageRaw('MessageId');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkDeleteRequests($container, ['/v4/webhooks/queues/account/MessageId']);
    }

    /**
     * Test the 'deleteWebhookQueueTemplateMessageRaw' function
     */
    public function testDeleteWebhookQueueTemplateMessageRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::webhookQueueTemplateMessageDelete());

        $response = $sw->deleteWebhookQueueTemplateMessageRaw('TestingGUID', 'MessageId');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkDeleteRequests($container, ['/v4/webhooks/queues/template/TestingGUID/MessageId']);
    }

    /**
     * Test the 'createDynamicTemplateRaw' function
     */
    public function testCreateDynamicTemplateRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::createDynamicTemplate());

        $response = $sw->createDynamicTemplateRaw(new SmartwaiverTemplateConfig(), new SmartwaiverTemplateData(), 300);
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkPostRequests($container, ['/v4/dynamic/templates'], [
            '{"dynamic":{"expiration":300,"template":{},"data":{}}}'
        ]);
    }

    /**
     * Test the 'processDynamicTemplateRaw' function
     */
    public function testProcessDynamicTemplateRaw()
    {
        $container = [];
        $sw = $this->createMockedSmartwaiver($container, APISuccessResponses::dynamicProcess());

        $response = $sw->processDynamicTemplateRaw('transactionId');
        $this->assertInstanceOf(SmartwaiverRawResponse::class, $response);

        $this->checkPostRequests($container, ['/v4/dynamic/process/transactionId'], []);
    }

    /**
     * Test the ability to get the last response the SDK received
     */
    public function testLastResponse()
    {
        $templateArray = APISuccessResponses::templateArray();

        $container = [];
        $sw = $this->createMockedSmartwaiver($container, json_encode($templateArray));

        $sw->getWaiverTemplate('TestingTemplateId');
        $swResponse = $sw->getLastResponse();
        $this->assertInstanceOf(SmartwaiverResponse::class, $swResponse);

        $this->assertEquals(4, $swResponse->version);
        $this->assertEquals('a0256461ca244278b412ab3238f5efd2', $swResponse->id);
        $this->assertEquals('2017-01-23T09:15:45.645Z', $swResponse->ts);
        $this->assertEquals('template', $swResponse->type);
        $this->assertEquals($templateArray['template'], $swResponse->responseData);
    }

    /**
     * Create a Smartwaiver Object with Mocked HTTP responses
     *
     * @param array $container The container to put the mocked requests in
     * @param string $response The response to send
     * @param int $numResponses The number of responses to send
     * @return Smartwaiver
     */
    private function createMockedSmartwaiver(&$container, $response, $numResponses = 1)
    {
        // Convert responses to Guzzle Responses
        $mockResponse = [];
        for($i=0; $i<$numResponses; $i++)
            array_push($mockResponse, new Response(200, [], $response));

        // Set up the Mock Handler
        $mock = new MockHandler($mockResponse);
        $history = Middleware::history($container);
        $handler = HandlerStack::create($mock);
        $handler->push($history);

        // Create the Smartwaiver object with the mocked handler
        $sw = new Smartwaiver(self::TEST_API_KEY, ['handler' => $handler]);

        return $sw;
    }

    /**
     * Check that the given container contains the appropriate GET requests
     * specified in the path array
     *
     * @param Request[] $container The container of mocked guzzle requests
     * @param string[] $paths The paths of the expected requests
     */
    private function checkGetRequests($container, $paths)
    {
        $this->checkRequests('GET', $container, $paths);
    }

    /**
     * Check that the given container contains the appropriate POST requests
     * specified in the path array
     *
     * @param Request[] $container The container of mocked guzzle requests
     * @param string[] $paths The paths of the expected requests
     * @param string[] $data The data of the request
     */
    private function checkPostRequests($container, $paths, $data)
    {
        $this->checkRequests('POST', $container, $paths, $data);
    }

    /**
     * Check that the given container contains the appropriate PUT requests
     * specified in the path array
     *
     * @param Request[] $container The container of mocked guzzle requests
     * @param string[] $paths The paths of the expected requests
     * @param string[] $data The data of the request
     */
    private function checkPutRequests($container, $paths, $data)
    {
        $this->checkRequests('PUT', $container, $paths, $data);
    }

    /**
     * Check that the given container contains the appropriate DELETE requests
     * specified in the path array
     *
     * @param Request[] $container The container of mocked guzzle requests
     * @param string[] $paths The paths of the expected requests
     */
    private function checkDeleteRequests($container, $paths)
    {
        $this->checkRequests('DELETE', $container, $paths);
    }

    /**
     * Check that the given container contains the appropriate requests
     * specified in the path array
     *
     * @param string $method The type of requests made
     * @param Request[] $container The container of mocked guzzle requests
     * @param string[] $paths The paths of the expected requests
     * @param string[] $data The data of the request (only used for post/put)
     */
    private function checkRequests($method, $container, $paths, $data = [])
    {
        // Check that the right requests were sent
        $this->assertCount(count($paths), $container);
        for($i=0; $i<count($paths); $i++) {
            $this->assertEquals($method, $container[$i]['request']->getMethod());
            $this->assertEquals($paths[$i], $container[$i]['request']->getRequestTarget());
            $this->assertEquals([self::TEST_API_KEY], $container[$i]['request']->getHeader('sw-api-key'));
            $this->assertEquals(['SmartwaiverSDK:4.3.1-php:'.phpversion()], $container[$i]['request']->getHeader('User-Agent'));
            if (array_key_exists($i, $data)) {
                $this->assertEquals($data[$i], $container[$i]['request']->getBody()->getContents());
            }
        }
    }
}