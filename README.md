![](https://d362q4tvy1elxj.cloudfront.net/header_logoheader.png)

PHP-SDK
==========

Table of Contents
=================

  * [Table of contents](#table-of-contents)
  * [Installation](#installation)
  * [Getting Started](#getting-started)
    * [Retrieve a Specific Template](#retrieve-a-specific-template)
    * [List all Signed Waivers](#list-all-signed-waivers)
    * [Retrieve a Specific Waiver](#retrieve-a-specific-waiver)
    * [Retrieve Photos on a Waiver](#retrieve-photos-on-a-waiver)
    * [Search for Waivers](#search-for-waivers)
    * [Retrieve/Set Webhook Config](#retrieveset-webhook-configuration)
    * [Retrieve Messages From Webhook Queues](#retrieve-messages-from-webhook-queues)
  * [Exception Handling](#exception-handling)
    * [Status Codes](#status-codes)
  * [Advanced](#advanced)
    * [Raw Responses](#raw-responses)
    * [URL Generation](#url-generation)
    * [Authentication](#authentication)
 * [API Documentation](#api-documentation)
    * [Smartwaiver/Exceptions/SmartwaiverHTTPException](#smartwaiverexceptionssmartwaiverhttpexception)
    * [Smartwaiver/Exceptions/SmartwaiverRateLimitException](#smartwaiverexceptionssmartwaiverratelimitexception)
    * [Smartwaiver/Exceptions/SmartwaiverSDKException](#smartwaiverexceptionssmartwaiversdkexception)
    * [Smartwaiver/Smartwaiver](#smartwaiversmartwaiver)
    * [Smartwaiver/SmartwaiverRawResponse](#smartwaiversmartwaiverrawresponse)
    * [Smartwaiver/SmartwaiverResponse](#smartwaiversmartwaiverresponse)
    * [Smartwaiver/SmartwaiverRoutes](#smartwaiversmartwaiverroutes)
    * [Smartwaiver/Types/Data/SmartwaiverTemplateData](#smartwaivertypesdatasmartwaivertemplatedata)
    * [Smartwaiver/Types/SmartwaiverCustomField](#smartwaivertypessmartwaivercustomfield)
    * [Smartwaiver/Types/SmartwaiverDynamicProcess](#smartwaivertypessmartwaiverdynamicprocess)
    * [Smartwaiver/Types/SmartwaiverDynamicTemplate](#smartwaivertypessmartwaiverdynamictemplate)
    * [Smartwaiver/Types/SmartwaiverFlag](#smartwaivertypessmartwaiverflag)
    * [Smartwaiver/Types/SmartwaiverGuardian](#smartwaivertypessmartwaiverguardian)
    * [Smartwaiver/Types/SmartwaiverParticipant](#smartwaivertypessmartwaiverparticipant)
    * [Smartwaiver/Types/SmartwaiverPhoto](#smartwaivertypessmartwaiverphoto)
    * [Smartwaiver/Types/SmartwaiverPhotos](#smartwaivertypessmartwaiverphotos)
    * [Smartwaiver/Types/SmartwaiverSearch](#smartwaivertypessmartwaiversearch)
    * [Smartwaiver/Types/SmartwaiverSignatures](#smartwaivertypessmartwaiversignatures)
    * [Smartwaiver/Types/SmartwaiverTemplate](#smartwaivertypessmartwaivertemplate)
    * [Smartwaiver/Types/SmartwaiverType](#smartwaivertypessmartwaivertype)
    * [Smartwaiver/Types/SmartwaiverWaiver](#smartwaivertypessmartwaiverwaiver)
    * [Smartwaiver/Types/SmartwaiverWaiverSummary](#smartwaivertypessmartwaiverwaiversummary)
    * [Smartwaiver/Types/SmartwaiverWebhook](#smartwaivertypessmartwaiverwebhook)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateBody](#smartwaivertypestemplatesmartwaivertemplatebody)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateCompletion](#smartwaivertypestemplatesmartwaivertemplatecompletion)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateConfig](#smartwaivertypestemplatesmartwaivertemplateconfig)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateElectronicConsent](#smartwaivertypestemplatesmartwaivertemplateelectronicconsent)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateGuardian](#smartwaivertypestemplatesmartwaivertemplateguardian)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateHeader](#smartwaivertypestemplatesmartwaivertemplateheader)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateMeta](#smartwaivertypestemplatesmartwaivertemplatemeta)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateParticipants](#smartwaivertypestemplatesmartwaivertemplateparticipants)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateProcessing](#smartwaivertypestemplatesmartwaivertemplateprocessing)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateSignatures](#smartwaivertypestemplatesmartwaivertemplatesignatures)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateStandardQuestions](#smartwaivertypestemplatesmartwaivertemplatestandardquestions)
    * [Smartwaiver/Types/Template/SmartwaiverTemplateStyling](#smartwaivertypestemplatesmartwaivertemplatestyling)
    * [Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessage](#smartwaivertypeswebhookqueuessmartwaiverwebhookmessage)
    * [Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessageDelete](#smartwaivertypeswebhookqueuessmartwaiverwebhookmessagedelete)
    * [Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessagePayload](#smartwaivertypeswebhookqueuessmartwaiverwebhookmessagepayload)
    * [Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookQueue](#smartwaivertypeswebhookqueuessmartwaiverwebhookqueue)
    * [Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookQueues](#smartwaivertypeswebhookqueuessmartwaiverwebhookqueues)

Installation
==========

To add the Smartwaiver SDK to your [Composer](https://getcomposer.org/) project:

    composer require smartwaiver/smartwaiver-sdk

Note: Smartwaiver SDK depends upon Guzzle so if you are not using composer you will need to handle those dependencies yourself.

Getting Started
==========

All that is required to start using the SDK is a Smartwaiver account and the API Key for that account.
In all of the examples you will need to put the API Key into the code wherever it says: `[INSERT API KEY]`

It's time to start making requests.
A good first request is to list all waiver templates for your account.
Here is the code to do that:

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Now request a list of all the waiver templates
$templates = $sw->getWaiverTemplates();
```

That's it! You've just requested all waiver templates in your account.
But, now it's time to do something with them.
Let's loop through those templates and print out the ID and Title of each template:

```php
foreach ($templates as $template) {
    echo $template->templateId . ': ' . $template->title . PHP_EOL;
}
```

Awesome! For more details on all the different properties a waiver template has, check out [TemplateProperties.php](examples/templates/TemplateProperties.php)

Now that you've got your first request, check out the sections below to accomplish specific actions.

Retrieve a Specific Template
---------

First let's set up the basic Smartwaiver object.
Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now we can request information about a specific template.
To do this we need the template ID.
If you don't know a template ID for your account, try listing all waiver templates for you account, as shown [here](#getting-started), and copying one of the ID's that is printed out.
Once we have a template ID we can execute a request to get the information about the template:

```php
// The unique ID of the template to be retrieved
$templateId = '[INSERT TEMPLATE ID]';

// Retrieve a specific template (SmartwaiverTemplate object)
$template = $sw->getWaiverTemplate($templateId);
```

Now let's print out some information about this template.

```php
// Access properties of the template
echo PHP_EOL . 'List single template:' . PHP_EOL;
echo $template->templateId . ': ' . $template->title . PHP_EOL;
```

To see all the different properties a waiver template has, check out [TemplateProperties.php](examples/templates/TemplateProperties.php)

List All Signed Waivers
----------

First let's set up the basic Smartwaiver object. Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now we can request signed waivers from your account.

```php
// Get a list of summaries of waivers
$waiverSummaries = $sw->getWaiverSummaries();
```

With this done, we can iterate over the returned summaries to see what is stored.
The default limit is 20, which means if you have more than 20 in your account, only the most recent 20 will be returned

```php
// Loop through the waivers and access their properties
echo 'List all waivers:' . PHP_EOL;
foreach ($waiverSummaries as $waiverSummary) {
    echo $waiverSummary->waiverId . ': ' . $waiverSummary->title . PHP_EOL;
}
```

To see all the different properties a waiver summary has, check out [WaiverSummaryProperties.php](examples/waivers/WaiverSummaryProperties.php)

Once we have a waiver summary, we can access all the detailed information about the waiver. To do that look [here](#retrieve-a-specific-waiver).

But, we can also restrict our query with some parameters.
For example, what if we only want to return 5 waivers, (the default is 20).
Here is the code to do that:

```php
// Set the limit
$limit = 5;

// Get a list of summaries of waivers
$waiverSummaries = $sw->getWaiverSummaries($limit);
```

Or what if we only want any waivers that have not been verified (either by email or at the kiosk)?

```php
// Set the limit
$limit = 5;

// Set the verified parameter
$verified = false;

// Get a list of summaries of waivers
$waiverSummaries = $sw->getWaiverSummaries($limit, $verified);
```

What other parameters can you use? Here is an example using all of them:

```php
// An example limiting the parameters
$limit = 5;                                     // Limit number returned to 5
$verified = true;                               // Limit only to waivers that were signed at a kiosk or verified over email
$templateId = '[INSERT TEMPLATE ID]';           // Limit query to waivers of this template ID
$fromDts = date('c', strtotime('2016-11-01'));  // Limit to waivers signed in November of 2016
$toDts = date('c', strtotime('2016-12-01'));
$firstName = 'Kyle';                            // Limit to waivers with a participant named Kyle Smith
$lastName = 'Smith';

// Get a list of summaries of waivers
$waiverSummaries = $sw->getWaiverSummaries($limit, $verified, $templateId, $fromDts, $toDts);
```

These examples are also available in [ListAllWaivers.php](examples/waivers/ListAllWaivers.php)

### Parameter Options

| Parameter Name | Default Value | Accepted Values   | Notes                                                                                   |
| -------------- | ------------- | ----------------- | --------------------------------------------------------------------------------------- |
| limit          | 20            | 1 - 100           | Limit number of returned waivers                                                        |
| verified       | null          | true/false/null   | Limit selection to waiver that have been verified (true), not (false), or both (null)   |
| templateId     |               | Valid Template ID | Limit signed waivers to only this template                                              |
| fromDts        |               | ISO 8601 Date     | Limit to signed waivers between from and to dates (requires toDts)                      |
| toDts          |               | ISO 8601 Date     | Limit to signed waivers between from and to dates (requires fromDts)                    |
| firstName      |               | Alpha-numeric     | Limit to signed waivers that have a participant with this first name (Case Insensitive) |
| lastName       |               | Alpha-numeric     | Limit to signed waivers that have a participant with this last name (Case Insensitive)  |

Retrieve a Specific Waiver
----------

What if we want to retrieve a specific waiver?
All we need for that is a waiver ID.
If you don't have a waiver ID to use, you can get a list of signed waivers in your account [here](#list-all-signed-waivers)

First let's set up the basic Smartwaiver object. Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now, we can request the information about a specific waiver.
Make sure to put your waiver ID in where it says `[INSERT WAIVER ID]`

```php
// The unique ID of the signed waiver to be retrieved
$waiverId = '[INSERT WAIVER ID]';

// Get a specific waiver
$waiver = $sw->getWaiver($waiverId);
```

The waiver object has many different properties that can be accessed.
For example, we can print out the waiver ID and title of the waiver.

```php
// Access properties of waiver
echo PHP_EOL . 'List single waiver:' . PHP_EOL;
echo $waiver->waiverId . ': ' . $waiver->title . PHP_EOL;
```

To see a full list of all properties that a waiver object contains, check out [WaiverProperties.php](examples/waivers/WaiverProperties.php)

We can also request that the PDF of the signed waiver as a Base 64 Encoded string be included. Here is the request to do that:

```php
// The unique ID of the signed waiver to be retrieved
$waiverId = '[INSERT WAIVER ID]';

$pdf = true;

// Get the waiver object
$waiver = $sw->getWaiver($waiverId, $pdf);
```

The code provided here is also combined in to one example in [RetrieveSingleWaiver.php](examples/waivers/RetrieveSingleWaiver.php)

Retrieve Photos on a Waiver
----------

We can also use the API to retrieve any photos taken when the waiver was signed or attached later with the console.
All we need is you're API key and the ID of a signed waiver, which has attached photos.


If you don't have a waiver ID to use, you can get a list of signed waivers in your account [here](#list-all-signed-waivers)

First let's set up the basic Smartwaiver object. Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now, we can request the photos on a specific waiver.
Make sure to put your waiver ID in where it says `[INSERT WAIVER ID]`

```php
// TThe unique ID of the signed waiver to retrieve the photos for
$waiverId = '[INSERT WAIVER ID]';

// Get the photos for a specific waiver
$photos = $sw->getWaiverPhotos($waiverId);
```

This photos object has a little meta-data we can print out:

```php
// Print a little header
echo PHP_EOL . 'Waiver Photos for: ' . $photos->title . PHP_EOL;
// echo $photos->waiverId;
// echo $photos->templateId;
// echo $photos->createdOn;
```

Using this photos object, we can loop through all the photos and process them however we like:

```php
// Loop through photos and print out some meta-data
foreach ($photos->photos as $photo) {
    echo $photo->photoId . ': ' . $photo->date;
    // Other fields
    // echo $photo->type;
    // echo $photo->tag;
    // echo $photo->fileType;
    // echo $photo->photo; // Base 64 encoded photo
}
```

The code provided here is also combined in to one example in [RetrieveWaiverPhotos.php](examples/waivers/RetrieveWaiverPhotos.php)

Search for Waivers
----------

First let's set up the basic Smartwaiver object. Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now we can request a search for signed waivers from your account.

```php
// Request all waivers signed in 2017
$search = $sw->search('', '2017-01-01 00:00:00');
```

**Note: The search route is a blocking search. Thus, a request to search for large amounts of data can take up to a few seconds.
As such, this route should not be used for anything where real-time performance is important. Instead use the Waivers route.**

This will return a search object containing metadata about the results of our search.
We can easily print out all that information:

```php
// Print out some information about the result of the search
echo 'Search Complete:' . PHP_EOL;
echo "\t" . 'Search ID: ' . $search->guid . PHP_EOL;
echo "\t" . 'Waiver Count: ' . $search->count . PHP_EOL;
echo "\t" . $search->pages . ' pages of size ' . $search->pageSize . PHP_EOL . PHP_EOL;
```

The server has stored the results of our search request under the GUID given.
We can now loop through the pages and request each page, which will be a list of up to 100 waivers.
For example, if we wanted to created a list of all first names from our search, we would do that like this:

```php
// First we set up our list
$nameList = [];

// Loop through all the pages in the search result
for($i = 0; $i < $search->pages; $i++) {
    echo 'Requesting page: ' . $i . '/' . $search->pages . '...' . PHP_EOL;

    // Request each page from the server
    $waivers = $sw->searchResult($search, $i);

    echo 'Processing page: ' . $i . '/' . $search->pages . '...' . PHP_EOL;

    // Loop through the waivers and create a comma separated list of first names
    foreach ($waivers as $waiver) {
        array_push($nameList, $waiver->firstName);

        // View all accessible properties of a waiver object in:
        // examples/waivers/WaiverProperties.php
    }
}
```

To see all the different properties a waiver has, check out [WaiverProperties.php](examples/waivers/WaiverProperties.php)

This examples is also available in [BasicSearch.php](examples/search/BasicSearch.php)

### Search Parameters

We can also restrict our search with more parameters.
For example, what if we only want to return waivers for one of the templates in our account.
Here is the code to do that:

```php
// The unique ID of the template to search for
$templateId = '[INSERT TEMPLATE ID]';

// Request all waivers signed for this template
$search = $sw->search($templateId);
```

Or what if we only want any waivers that have not been verified (either by email or at the kiosk)?

```php
// Request all waivers signed that not have been email verified
$search = $sw->search('', '', '', '', '', false);
```

What other parameters can you use? Here are some more examples:

```php
// Request all waivers signed for this template after the given date
$search = $sw->search($templateId, '2017-01-01 00:00:00');

// Request all waivers signed for this template before the given date
$search = $sw->search($templateId, '', '2017-01-01 00:00:00');

// Request all waivers signed for this template with a participant name Kyle
$search = $sw->search($templateId, '', '', 'Kyle');

// Request all waivers signed for this template with a participant name Kyle Smith
$search = $sw->search($templateId, '', '', 'Kyle', 'Smith');

// Request all waivers signed with a participant name Kyle that have been email verified
$search = $sw->search('', '', '', 'Kyle', '', true);

// Request all waivers signed in ascending sorted order
//$search = $sw->search($templateId, '', '', '', '', null, false);
```

These examples are also available in [SearchParams.php](examples/search/SearchParams.php)

### Parameter Options

| Parameter Name | Default Value | Accepted Values   | Notes                                                                                   |
| -------------- | ------------- | ----------------- | --------------------------------------------------------------------------------------- |
| templateId     |               | Valid Template ID | Limit signed waivers to only this template                                              |
| fromDts        |               | ISO 8601 Date     | Limit to signed waivers between after this date                                         |
| toDts          |               | ISO 8601 Date     | Limit to signed waivers between before this date                                        |
| firstName      |               | Alpha-numeric     | Limit to signed waivers that have a participant with this first name (Case Insensitive) |
| lastName       |               | Alpha-numeric     | Limit to signed waivers that have a participant with this last name (Case Insensitive)  |
| verified       | null          | true/false/null   | Limit selection to waiver that have been verified (true), not (false), or both (null)   |
| sortDesc       | true          | true/false        | Sort results in descending (latest signed waiver first) order                           |


Retrieve/Set Webhook Configuration
----------

You can both retrieve and set your account's webhook configuration through this SDK with a couple simple calls.
To view your current webhook settings, we first need to set a Smartwaiver object.
Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Now, it's easy to request the webhook configuration:

```php
// Get the current webhook settings
$webhooks = $sw->getWebhookConfig();
```

And, now we can print out the information:

```php
// Access the webhook config
echo 'Endpoint: ' . $webhooks->endpoint . PHP_EOL;
echo 'EmailValidationRequired: ' . $webhooks->emailValidationRequired . PHP_EOL;
```

The Email Validation Required is whether the webhook will fire before, after, or before and after a waiver is verified.
The endpoint is simply the endpoint URL for the webhook.

And changing your webhook configuration is just as easy.
The new configuration will be returned from the request and can be access just like the read request above.

```php
// The new values to set
$endpoint = 'http://endpoint.example.org';
$emailValidationRequired = SmartwaiverWebhook::WEBHOOK_AFTER_EMAIL_ONLY;

// Set the webhook to new values
$webhook = $sw->setWebhookConfig($endpoint, $emailValidationRequired);

// Access the new webhook config
echo 'Successfully set new configuration.' . PHP_EOL;
echo 'Endpoint: ' . $newWebhook->endpoint . PHP_EOL;
echo 'EmailValidationRequired: ' . $newWebhook->emailValidationRequired . PHP_EOL;
```

If you wish to remove a webhook completely from the account you may also do that like this:

```php
$sw->deleteWebhookConfig();
```


This code is also provided in [RetrieveWebhooks.php](examples/webhooks/RetrieveWebhooks.php),
[SetWebhooks.php](examples/webhooks/SetWebhooks.php),
and [DeleteWebhooks.php](examples/webhooks/DeleteWebhooks.php)


Retrieve Messages From Webhook Queues
----------

Instead of using a public webhook endpoint you can set up your account to put webhooks in a queue system, which can be accessed using this API.
Webhooks will be placed in the queue as soon as the waiver is finished processing and will remain there for 7 days.
Our webhook queues also have support for separate queues for every template if you wish.
To view your current webhook settings, we first need to set a Smartwaiver object.
Make sure to put in your account's API Key where it says `[INSERT API KEY]`

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

First we can see how many webhook queues we have set up!

```php
// Get the current webhook queue information
$queues = $sw->getWebhookQueues();
```

This returns a nice obejct that has information about how many messages are in our queues.
If our queues don't exist yet, there won't be any information!

```php
// Access the account level webhook information
if (is_null($queues->accountQueue)) {
    echo 'Account Queue: N/A' . PHP_EOL;
} else {
    echo 'Account Queue:' . PHP_EOL;
    echo "\tTotal Messages: " . $queues->accountQueue->messagesTotal . PHP_EOL;
    echo "\tMessages Not Visible: " . $queues->accountQueue->messagesNotVisible . PHP_EOL;
    echo "\tMessages Delayed: " . $queues->accountQueue->messagesDelayed . PHP_EOL;
}

// Access the template level webhook information
foreach ($queues->templateQueues as $templateId => $templateQueue) {
    echo 'Template Queue (' . $templateId . '):' . PHP_EOL;
    echo "\tTotal Messages: " . $queues->accountQueue->messagesTotal . PHP_EOL;
    echo "\tMessages Not Visible: " . $queues->accountQueue->messagesNotVisible . PHP_EOL;
    echo "\tMessages Delayed: " . $queues->accountQueue->messagesDelayed . PHP_EOL;
}
```

Now, if we have some messages in our queue (or not) we can poll to retrieve a message.

```php
// Retrieve a message from the account queue
$message = $sw->getWebhookQueueAccountMessage();
```

Or if we want to get a message from a template queue:

```php
// The Unique ID of the waiver template
$templateId = '[INSERT TEMPLATE ID]';

// Retrieve a message from the template queue
$message = $sw->getWebhookQueueAccountMessage($templateId);
```

This will retrieve one message and we can then access the body of the message.
If there are no messages a null object will be returned.

```php
// Check for empty queue
if (is_null($message)) {
    echo 'No messages in account queue.' . PHP_EOL;
    exit;
}

// Print out message info
echo 'Message in Account Queue' . PHP_EOL;
echo "\tMessage ID: " . $message->messageId . PHP_EOL;
echo "\tMessage Payload: " . PHP_EOL;
echo "\t\tWaiver ID: " . $message->body->uniqueId . PHP_EOL;
echo "\t\tEvent: " . $message->body->event . PHP_EOL;
```

Now that we have processed the message we can delete it.

```php
$delete = $sw->deleteWebhookQueueAccountMessage($message->messageId);

echo 'Deletion Success: ' . ($delete->success ? 'true' : 'false') . PHP_EOL;
```

If we instead wanted to delete it while we retrieved (not recommended since if errors occur in your processing that webhook is lost) we could do this:

```php
// Optionally we can delete the message when we retrieve it, by passing a delete flag
$message = $sw->getWebhookQueueAccountMessage(true);
```

This code is also provided in [RetrieveWebhookQueues.php](examples/queues/RetrieveWebhookQueues.php), RetrieveTemplateMessage.php](examples/queues/RetrieveTemplateMessage.php)
and [RetrieveAccountMessage.php](examples/queues/RetrieveAccountMessage.php)


Exception Handling
==========

Exceptions in this SDK are grouped into three different types.
 * A <b>SmartwaiverSDKException</b> occurs when the SDK itself encounters a problem.
   Examples of this include problems connecting to the API server, an unexpected response from the API server, bad input data, etc.
 * A <b>SmartwaiverHTTPException</b> occurs when the API encounters an error and properly relays that information back.
   Examples of this include '401 Unauthorized' or '404 Not Found' errors.
 * A <b>SmartwaiverRateLimitException</b> occurs when your account hits the rate limit.
   Info is contained in the object to figure out how long to wait before trying again.

Note that a <b>SmartwaiverRateLimitException</b> is a type <b>SmartwaiverHTTPException</b>, which is a type of <b>SmartwaiverSDKException</b> so it is possible to catch all possible exceptions at the same time.

Here is an example of catching an HTTP exception. First we set up the Smartwaiver account:

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);
```

Next, we attempt to get a waiver that does not exist:

```php
// The Waiver ID to access
$waiverId = 'InvalidWaiverId';

// Try to get the waiver object
$waiver = $sw->getWaiver($waiverId);
```

This will throw an exception because a waiver with that ID does not exist. So let's change the code to catch that exception:

```php
try
{
    // Try to get the waiver object
    $waiver = $sw->getWaiver($waiverId);
}
catch (SmartwaiverHTTPException $se)
{
    // Print out that we encountered an error
    echo 'Error retrieving waiver from API server...' . PHP_EOL . PHP_EOL;
}
```

But there is lot's of useful information in the exception object. Let's print some of that out too:

```php
// The code will be the HTTP Status Code returned
echo 'Error Code: ' . $se->getCode() . PHP_EOL;
// The message will be informative about what was wrong with the request
echo 'Error Message: ' . $se->getMessage() . PHP_EOL . PHP_EOL;

// Also included in the exception is the header information returned about
// the response.
$responseInfo = $se->getResponseInfo();
echo 'API Version: ' . $responseInfo['version'] . PHP_EOL;
echo 'UUID: ' . $responseInfo['id'] . PHP_EOL;
echo 'Timestamp: ' . $responseInfo['ts'] . PHP_EOL;
```

The code provided here is also combined in to one example in [ExceptionHandling.php](examples/intro/ExceptionHandling.php)

The <b>SmartwaiverRateLimitException</b> is a special type of <b>SmartwaiverHTTPException</b> and provides some additional information.
The exception can be caught in exactly the same way:

```php
try
{
    // Try to get the waiver object
    $waiver = $sw->getWaiver($waiverId);
}
catch (SmartwaiverRateLimitException $se)
{
    // The number of requests that have taken place in the current window
    echo 'Number of requests: ' . $se->requests . PHP_EOL;
    // The max number of requests for routes of this type in the current window
    echo 'Max requests: ' . $se->max . PHP_EOL;
    // The number of seconds to wait until trying again
    echo 'Retry after: ' . $se->retryAfter . PHP_EOL;
}
```

And the exception object has some additional information, seen being printed out above.

Status Codes
----------

The code of the exception will match the HTTP Status Code of the response and the message will be an informative string informing on what exactly was wrong with the request.

Possible status codes and their meanings:

| Status Code | Error Name            | Description                                                                                                                       |
| ----------- | --------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| 400         | Parameter Error       | Indicates that something was wrong with the parameters of the request (e.g. extra parameters, missing required parameters, etc.). |
| 401         | Unauthorized          | Indicates the request was missing an API Key or contained an invalid API Key.                                                     |
| 402         | Data Error            | Indicates that the parameters of the request was valid, but the data in those parameters was not.                                 |
| 404         | Not Found             | Indicates that whatever was being searched for (specific waiver, etc.) could not be found.                                        |
| 406         | Wrong Content Type    | Indicates that the Content Type of the request is inappropriate for the request.                                                  |
| 429         | Too Many Requests     | Indicates that your account rate limit has been hit and you should cease making requests.                                         |
| 500         | Internal Server Error | Indicates that the server encountered an internal error while processing the request.                                             |

Advanced
==========

This section contains notes about several more ways to use the SDK that are slightly more low level.

Raw Responses
----------
If you do not wish to use the Smartwaiver object types to facilitate easy use of the data you can also access the raw response from the API server.

Here is an example of getting the raw response from the server for retrieving a list of waiver summaries:

```php
// The API Key for your account
$apiKey = '[INSERT API KEY]';

// Set up your Smartwaiver connection using your API Key
$sw = new Smartwaiver($apiKey);

// Get a list of all signed waivers for this account
$response = $sw->getWaiverSummariesRaw();

// The response object has two variables, status code and response body
echo 'Status Code: ' . $response->statusCode . PHP_EOL;
echo 'Body: ' . $response->body . PHP_EOL;
```

All the standard methods have a 'Raw' counterpart that just has 'Raw' added to the function name.

The code provided here is also in [RawResponses.php](examples/advanced/RawResponses.php)

URL Generation
----------

If you would like handle all aspects of the request's yourself, you can simply use <b>SmartwaiverRoutes</b> class to generate the approriate URLs for your requests.

For example, to create the URL to list all templates is only one line:

```php
SmartwaiverRoutes::getWaiverTemplates();
```

For the list of possible routes see [SmartwaiverRoutes.php](src/Smartwaiver/SmartwaiverRoutes.php)

Note: to use this you must handle the proper authentication headers yourself.

Authentication
----------

If you are making custom requests you must include the proper authentication.
The Smartwaiver API expects a header called 'sw-api-key' to contain the API for the account you are accessing.

    sw-api-key: [INSERT API KEY]

If you do not have a Smartwaiver API key go [here](https://www.smartwaiver.com/p/API) to find out how to create one.

API Documentation
=================

## Smartwaiver/Exceptions/SmartwaiverHTTPException

Class SmartwaiverHTTPException

This class handles all exceptions that have to do with communicating with
the API and interpreting the responses.

* Full name: \Smartwaiver\Exceptions\SmartwaiverHTTPException
* Parent class: \Smartwaiver\Exceptions\SmartwaiverSDKException


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| private | `response` | **array** |

### __construct

SmartwaiverHTTPException constructor.

```php
SmartwaiverHTTPException::__construct( \GuzzleHttp\Psr7\Response $guzzleResponse, string $guzzleBody, string $content )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guzzleResponse` | **\GuzzleHttp\Psr7\Response** | The guzzle response object from the bad request |
| `$guzzleBody` | **string** | The body of the guzzle response from the bad request |
| `$content` | **string** | The processed content of the API response |

---

### getGuzzleResponse

Access the Guzzle Response object from the request that generated this
exception.

```php
SmartwaiverHTTPException::getGuzzleResponse(  ): \GuzzleHttp\Psr7\Response
```

**Return Value:**

The response object

---

### getGuzzleBody

Access the body of the guzzle response. This is provided since the body
is a stream that will be empty in the $guzzleResponse object.

```php
SmartwaiverHTTPException::getGuzzleBody(  ): string
```

**Return Value:**

The body contents of the response

---

### getResponseInfo

This method provides access to the parsed information from the API error
response. This includes the version, timestamp, and UUID of the response

```php
SmartwaiverHTTPException::getResponseInfo(  ): array
```

**Return Value:**

The response header information

---

## Smartwaiver/Exceptions/SmartwaiverRateLimitException

Class SmartwaiverRateLimitException

This class handles all exceptions that have to do with communicating with
the API and interpreting the responses.

* Full name: \Smartwaiver\Exceptions\SmartwaiverRateLimitException
* Parent class: \Smartwaiver\Exceptions\SmartwaiverHTTPException


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `requests` | **integer** |
| public | `max` | **integer** |
| public | `retryAfter` | **integer** |

### __construct

SmartwaiverRateLimitException constructor.

```php
SmartwaiverRateLimitException::__construct( \GuzzleHttp\Psr7\Response $guzzleResponse, string $guzzleBody, string $content )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guzzleResponse` | **\GuzzleHttp\Psr7\Response** | The guzzle response object from the bad request |
| `$guzzleBody` | **string** | The body of the guzzle response from the bad request |
| `$content` | **string** | The processed content of the API response |

---

### getResponseInfo

This method provides access to the parsed information from the API error
response. This includes the version, timestamp, and UUID of the response

```php
SmartwaiverRateLimitException::getResponseInfo(  ): array
```

**Return Value:**

The response header information

---

### getGuzzleResponse

Access the Guzzle Response object from the request that generated this
exception.

```php
SmartwaiverRateLimitException::getGuzzleResponse(  ): \GuzzleHttp\Psr7\Response
```

**Return Value:**

The response object

---

### getGuzzleBody

Access the body of the guzzle response. This is provided since the body
is a stream that will be empty in the $guzzleResponse object.

```php
SmartwaiverRateLimitException::getGuzzleBody(  ): string
```

**Return Value:**

The body contents of the response

---

## Smartwaiver/Exceptions/SmartwaiverSDKException

Class SmartwaiverSDKException

This class handles all exceptions that have to do with communicating with
the API and interpreting the responses.

* Full name: \Smartwaiver\Exceptions\SmartwaiverSDKException
* Parent class: 


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| private | `guzzleResponse` | **\GuzzleHttp\Psr7\Response** |
| private | `guzzleBody` | **string** |

### __construct

SmartwaiverSDKException constructor.

```php
SmartwaiverSDKException::__construct( \GuzzleHttp\Psr7\Response $guzzleResponse, string $guzzleBody, string $message, integer $code )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guzzleResponse` | **\GuzzleHttp\Psr7\Response** |  |
| `$guzzleBody` | **string** |  |
| `$message` | **string** |  |
| `$code` | **integer** |  |

---

### getGuzzleResponse

Access the Guzzle Response object from the request that generated this
exception.

```php
SmartwaiverSDKException::getGuzzleResponse(  ): \GuzzleHttp\Psr7\Response
```

**Return Value:**

The response object

---

### getGuzzleBody

Access the body of the guzzle response. This is provided since the body
is a stream that will be empty in the $guzzleResponse object.

```php
SmartwaiverSDKException::getGuzzleBody(  ): string
```

**Return Value:**

The body contents of the response

---

## Smartwaiver/Smartwaiver

Main class, which provides basic methods to interact with Smartwaiver API.



* Full name: \Smartwaiver\Smartwaiver


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| protected | `client` | **\GuzzleHttp\Client** |
| protected | `lastResponse` | **\Smartwaiver\SmartwaiverResponse&#124;null** |

### __construct

Creates a new Smartwaiver object.

```php
Smartwaiver::__construct( string $apiKey, array&lt;mixed,array&gt; $guzzleOptions = array() )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$apiKey` | **string** | The API Key for the account |
| `$guzzleOptions` | **array<mixed,array>** | Optional options to pass to guzzle client |

---

### getWaiverTemplates

Retrieve a list of all waiver templates in the account.

```php
Smartwaiver::getWaiverTemplates(  ): array&lt;mixed,\Smartwaiver\Types\SmartwaiverTemplate&gt;
```

**Return Value:**

An array (may be empty) of SmartwaiverTemplates

---

### getWaiverTemplate

Retrieve information about a specific waiver template.

```php
Smartwaiver::getWaiverTemplate( string $templateId ): \Smartwaiver\Types\SmartwaiverTemplate
```

If the waiver template is not found a NotFoundException will be thrown.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The Unique ID of waiver template to get |


**Return Value:**

The requested template

---

### getWaiverSummaries

Retrieve a list of waiver summaries matching the given criteria.

```php
Smartwaiver::getWaiverSummaries( integer $limit = 20, boolean|null $verified = null, string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, string $tag = &#039;&#039; ): array&lt;mixed,\Smartwaiver\Types\SmartwaiverWaiverSummary&gt;
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$limit` | **integer** | Limit to this number of the most recent waivers. |
| `$verified` | **boolean&#124;null** | Limit to waivers that have been verified by email (true), not verified (false), or both (null). |
| `$templateId` | **string** | Limit to waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit to waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter). |
| `$toDts` | **string** | Limit to waivers between fromDts and this ISO 8601 date (requires fromDts parameter). |
| `$firstName` | **string** | Limit to waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit to waivers with any participant having this for a last name (Case Insensitive). |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

The list of signed waiver summary objects

---

### getWaiver

Retrieve a waiver with the given waiver ID

```php
Smartwaiver::getWaiver( string $waiverId, boolean $pdf = false ): \Smartwaiver\Types\SmartwaiverWaiver
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver to retrieve |
| `$pdf` | **boolean** | Whether to include the Base64 Encoded PDF |


**Return Value:**

The waiver object corresponding to the given waiver ID

---

### getWaiverPhotos

Retrieve all waiver photos for the given waiver ID

```php
Smartwaiver::getWaiverPhotos( string $waiverId ): \Smartwaiver\Types\SmartwaiverPhotos
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

The photos object containing all the photos

---

### getWaiverSignatures

Retrieve all drawn signatures for the given waiver ID

```php
Smartwaiver::getWaiverSignatures( string $waiverId ): \Smartwaiver\Types\SmartwaiverSignatures
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

The signatures object containing all the signatures

---

### search

Perform a large search matching the given criteria. This will return a
guid that can then be used to access the results of the search.

```php
Smartwaiver::search( string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, boolean|null $verified = null, boolean $sortDesc = true, string $tag = &#039;&#039; ): \Smartwaiver\Types\SmartwaiverSearch
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | Limit to waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit to waivers after this ISO 8601 date. |
| `$toDts` | **string** | Limit to waivers before this ISO 8601 date. |
| `$firstName` | **string** | Limit to waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit to waivers with any participant having this for a last name (Case Insensitive). |
| `$verified` | **boolean&#124;null** | Limit to waivers that have been verified by email (true), not verified (false) or both (null). |
| `$sortDesc` | **boolean** | Sort results in descending (latest signed waiver first) order. |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

The object representing the results of the search

---

### searchResult

Retrieve a page of the given search.

```php
Smartwaiver::searchResult( \Smartwaiver\Types\SmartwaiverSearch $search, integer $page ): array&lt;mixed,\Smartwaiver\Types\SmartwaiverWaiver&gt;
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$search` | **\Smartwaiver\Types\SmartwaiverSearch** | The search object to get the results of |
| `$page` | **integer** | The page number to retrieve |


**Return Value:**

A list of the waiver objects in the given page

---

### searchResultByGuid

Retrieve a page of the given search.

```php
Smartwaiver::searchResultByGuid( string $guid, integer $page ): array&lt;mixed,\Smartwaiver\Types\SmartwaiverWaiver&gt;
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guid` | **string** | The guid of the search results |
| `$page` | **integer** | The page number to retrieve |


**Return Value:**

A list of the waiver objects in the given page

---

### getWebhookConfig

Retrieve the current webhook configuration for the account

```php
Smartwaiver::getWebhookConfig(  ): \Smartwaiver\Types\SmartwaiverWebhook
```

**Return Value:**

The current webhook configuration

---

### setWebhookConfig

Set the webhook configuration for this account

```php
Smartwaiver::setWebhookConfig( string $endpoint, string $emailValidationRequired ): \Smartwaiver\Types\SmartwaiverWebhook
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$endpoint` | **string** | A valid url to set as the webhook endpoint |
| `$emailValidationRequired` | **string** | Sets when the webhook is fired (use constants from SmartwaiverWebhook). |


**Return Value:**

The new webhook configuration will be returned

---

### setWebhook

Set the webhook configuration for this account

```php
Smartwaiver::setWebhook( \Smartwaiver\Types\SmartwaiverWebhook $webhook ): \Smartwaiver\Types\SmartwaiverWebhook
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhook` | **\Smartwaiver\Types\SmartwaiverWebhook** | The webhook configuration to set |


**Return Value:**

The new webhook configuration will be returned

---

### getWebhookQueues

Retrieve the current message counts for all webhook queues enabled

```php
Smartwaiver::getWebhookQueues(  ): \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueues
```

**Return Value:**

The status information for all queues

---

### getWebhookQueueAccountMessage

Retrieve a message from the webhook account queue

```php
Smartwaiver::getWebhookQueueAccountMessage( boolean $delete = false ): \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage|null
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delete` | **boolean** | Whether to delete the message as it's retrieved |


**Return Value:**

A message from the account queue

---

### getWebhookQueueTemplateMessage

Retrieve a message from a webhook template queue

```php
Smartwaiver::getWebhookQueueTemplateMessage( string $templateId, boolean $delete = false ): \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The template ID to retrieve the message from |
| `$delete` | **boolean** | Whether to delete the message as it's retrieved |


**Return Value:**

A message from the template queue

---

### deleteWebhookQueueAccountMessage

Delete a message from the webhook account queue

```php
Smartwaiver::deleteWebhookQueueAccountMessage( string $messageId ): \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$messageId` | **string** | The message to delete from the queue |


**Return Value:**

Whether the message was deleted

---

### deleteWebhookQueueTemplateMessage

Delete a message from a webhook template queue

```php
Smartwaiver::deleteWebhookQueueTemplateMessage( string $templateId, string $messageId ): \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The template ID to retrieve the message from |
| `$messageId` | **string** | The message to delete from the queue |


**Return Value:**

Whether the message was deleted

---

### createDynamicTemplate

Create a dynamic template for your participant to fill out

```php
Smartwaiver::createDynamicTemplate( \Smartwaiver\Types\Template\SmartwaiverTemplateConfig $templateConfig, \Smartwaiver\Types\Data\SmartwaiverTemplateData $data, integer $expiration ): \Smartwaiver\Types\SmartwaiverDynamicTemplate
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateConfig` | **\Smartwaiver\Types\Template\SmartwaiverTemplateConfig** | The config for display of the dyanamic template |
| `$data` | **\Smartwaiver\Types\Data\SmartwaiverTemplateData** | The data to fill on the dynamic template |
| `$expiration` | **integer** | The expiration of the dynamic template |


**Return Value:**

An object representing your new dynamic template

---

### processDynamicTemplate

Create a dynamic template for your participant to fill out

```php
Smartwaiver::processDynamicTemplate( string $transactionId ): \Smartwaiver\Types\SmartwaiverDynamicProcess
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transactionId` | **string** | The transaction ID you are requesting processing of |


**Return Value:**

An object representing info about your processed waiver

---

### getWaiverTemplatesRaw

Retrieve a list of all waiver templates in the account.

```php
Smartwaiver::getWaiverTemplatesRaw(  ): \Smartwaiver\SmartwaiverRawResponse
```

**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWaiverTemplateRaw

Retrieve information about a specific waiver template.

```php
Smartwaiver::getWaiverTemplateRaw( string $templateId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The Unique ID of waiver template to get |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWaiverSummariesRaw

Retrieve a list of waiver summaries matching the given criteria.

```php
Smartwaiver::getWaiverSummariesRaw( integer $limit = 20, boolean|null $verified = null, string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, string $tag = &#039;&#039; ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$limit` | **integer** | Limit to this number of the most recent waivers. |
| `$verified` | **boolean&#124;null** | Limit to waivers that have been verified by email (true), not verified (false), or both (null). |
| `$templateId` | **string** | Limit to waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit to waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter). |
| `$toDts` | **string** | Limit to waivers between fromDts and this ISO 8601 date (requires fromDts parameter). |
| `$firstName` | **string** | Limit to waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit to waivers with any participant having this for a last name (Case Insensitive). |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWaiverRaw

Retrieve a waiver with the given waiver ID

```php
Smartwaiver::getWaiverRaw( string $waiverId, boolean $pdf = false ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver to retrieve |
| `$pdf` | **boolean** | Include the Base64 Encoded PDF |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWaiverPhotosRaw

Retrieve all photos attached to the given waiver ID

```php
Smartwaiver::getWaiverPhotosRaw( string $waiverId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWaiverSignaturesRaw

Retrieve all drawn signatures attached to the given waiver ID

```php
Smartwaiver::getWaiverSignaturesRaw( string $waiverId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### searchRaw

Perform a large search matching the given criteria. This will return a
guid that can then be used to access the results of the search.

```php
Smartwaiver::searchRaw( string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, boolean|null $verified = null, boolean $sortDesc = true, string $tag = &#039;&#039; ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | Limit to waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit to waivers after this ISO 8601 date. |
| `$toDts` | **string** | Limit to waivers before this ISO 8601 date. |
| `$firstName` | **string** | Limit to waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit to waivers with any participant having this for a last name (Case Insensitive). |
| `$verified` | **boolean&#124;null** | Limit to waivers that have been verified by email (true), not verified (false) or both (null). |
| `$sortDesc` | **boolean** | Sort results in descending (latest signed waiver first) order. |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### searchResultByGuidRaw

Retrieve a page of the given search.

```php
Smartwaiver::searchResultByGuidRaw( string $guid, integer $page ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guid` | **string** | The guid of the search results |
| `$page` | **integer** | The page number to retrieve |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWebhookConfigRaw

Retrieve the current webhook configuration for the account

```php
Smartwaiver::getWebhookConfigRaw(  ): \Smartwaiver\SmartwaiverRawResponse
```

**Return Value:**

An object that holds the status code and
unprocessed json.

---

### setWebhookConfigRaw

Set the webhook configuration for this account

```php
Smartwaiver::setWebhookConfigRaw( string $endpoint, string $emailValidationRequired ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$endpoint` | **string** | A valid url to set as the webhook endpoint |
| `$emailValidationRequired` | **string** | Sets when the webhook is fired (use constants from SmartwaiverWebhook). |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWebhookQueuesRaw

Retrieve the current message counts for all webhook queues enabled

```php
Smartwaiver::getWebhookQueuesRaw(  ): \Smartwaiver\SmartwaiverRawResponse
```

**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWebhookQueueAccountMessageRaw

Retrieve a message from the webhook account queue

```php
Smartwaiver::getWebhookQueueAccountMessageRaw( boolean $delete = false ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delete` | **boolean** | Whether to delete the message as it's retrieved |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getWebhookQueueTemplateMessageRaw

Retrieve a message from a webhook template queue

```php
Smartwaiver::getWebhookQueueTemplateMessageRaw( string $templateId, boolean $delete = false ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The template ID to retrieve the message from |
| `$delete` | **boolean** | Whether to delete the message as it's retrieved |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### deleteWebhookQueueAccountMessageRaw

Delete a message from the webhook account queue

```php
Smartwaiver::deleteWebhookQueueAccountMessageRaw( string $messageId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$messageId` | **string** | The message to delete from the queue |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### deleteWebhookQueueTemplateMessageRaw

Delete a message from a webhook template queue

```php
Smartwaiver::deleteWebhookQueueTemplateMessageRaw( string $templateId, string $messageId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The template ID to retrieve the message from |
| `$messageId` | **string** | The message to delete from the queue |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### createDynamicTemplateRaw

Create a dynamic template for your participant to fill out

```php
Smartwaiver::createDynamicTemplateRaw( \Smartwaiver\Types\Template\SmartwaiverTemplateConfig $templateConfig, \Smartwaiver\Types\Data\SmartwaiverTemplateData $data, integer $expiration ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateConfig` | **\Smartwaiver\Types\Template\SmartwaiverTemplateConfig** | The config for display of the dyanamic template |
| `$data` | **\Smartwaiver\Types\Data\SmartwaiverTemplateData** | The data to fill on the dynamic template |
| `$expiration` | **integer** | The expiration of the dynamic template |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### processDynamicTemplateRaw

Create a dynamic template for your participant to fill out

```php
Smartwaiver::processDynamicTemplateRaw( string $transactionId ): \Smartwaiver\SmartwaiverRawResponse
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transactionId` | **string** | The transaction ID you are requesting processing of |


**Return Value:**

An object that holds the status code and
unprocessed json.

---

### getLastResponse

Get the SmartwaiverResponse objected created for the most recent API
request. Useful for error handling if an exception is thrown.

```php
Smartwaiver::getLastResponse(  ): \Smartwaiver\SmartwaiverResponse|null
```

**Return Value:**

The last response this object received from the API

---

## Smartwaiver/SmartwaiverRawResponse

Class SmartwaiverRawResponse

This class provides a simple response from the API server containing the
status code and raw body.

* Full name: \Smartwaiver\SmartwaiverRawResponse


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `statusCode` | **integer** |
| public | `body` | **string** |

### __construct

Pulls out the appropriate information from the Guzzle Response

```php
SmartwaiverRawResponse::__construct( \GuzzleHttp\Psr7\Response $guzzleResponse )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guzzleResponse` | **\GuzzleHttp\Psr7\Response** | The entire Guzzle HTTP Response from the request |

---

## Smartwaiver/SmartwaiverResponse

Class SmartwaiverResponse

This class processes general information for all HTTP responses from the API
server. Version, Unique ID, and Timestamp information for every request are
stored in this class.

* Full name: \Smartwaiver\SmartwaiverResponse


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `version` | **string** |
| public | `id` | **string** |
| public | `ts` | **string** |
| public | `type` | **string** |
| public | `responseData` | **array** |
| private | `guzzleResponse` | **\GuzzleHttp\Psr7\Response** |

### __construct

Parses all responses from the server and throws an exception if any error occurred.

```php
SmartwaiverResponse::__construct( \GuzzleHttp\Psr7\Response $guzzleResponse )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guzzleResponse` | **\GuzzleHttp\Psr7\Response** | The entire Guzzle HTTP Response from the request |

---

### getGuzzleResponse

Get the actual Guzzle response object that underlies the data in this
response object. Note that the body will be empty because it is read by
this class's constructor. If you need the body, call getGuzzleBody()

```php
SmartwaiverResponse::getGuzzleResponse(  ): \GuzzleHttp\Psr7\Response
```

**Return Value:**

The underlying Guzzle response object

---

### getGuzzleBody

Access the body of the guzzle response. This is provided since the body
is a stream that will be empty in the $guzzleResponse object.

```php
SmartwaiverResponse::getGuzzleBody(  ): string
```
---

## Smartwaiver/SmartwaiverRoutes

Class SmartwaiverRoutes

This class provides and easy way to create the actual URLs for the routes.

* Full name: \Smartwaiver\SmartwaiverRoutes

### getWaiverTemplates

Get the URL to retrieve a list of all waiver templates in the account.

```php
SmartwaiverRoutes::getWaiverTemplates(  ): string
```

* This method is **static**.

**Return Value:**

The URL to retrieve the information.

---

### getWaiverTemplate

Get the URL to retrieve information about a specific waiver template.

```php
SmartwaiverRoutes::getWaiverTemplate( string $templateId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The Unique ID of waiver template to get |


**Return Value:**

The URL to retrieve the information.

---

### getWaiverSummaries

Get the URL to retrieve a list of waiver summaries matching the given criteria.

```php
SmartwaiverRoutes::getWaiverSummaries( integer $limit = 20, boolean|null $verified = null, string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, string $tag = &#039;&#039; ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$limit` | **integer** | Limit to this number of the most recent waivers. |
| `$verified` | **boolean&#124;null** | Limit to waivers that have been verified by email (true), not verified (false), or both (null). |
| `$templateId` | **string** | Limit to waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit to waivers between this ISO 8601 date and the toDts parameter (requires toDts parameter). |
| `$toDts` | **string** | Limit to waivers between fromDts and this ISO 8601 date (requires fromDts parameter). |
| `$firstName` | **string** | Limit to waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit to waivers with any participant having this for a last name (Case Insensitive). |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

The URL to retrieve the information.

---

### getWaiver

Get the URL to retrieve a waiver with the given waiver ID

```php
SmartwaiverRoutes::getWaiver( string $waiverId, boolean $pdf = false ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver to retrieve |
| `$pdf` | **boolean** | Whether to include the Base64 Encoded PDF |


**Return Value:**

The URL to retrieve the information.

---

### getWaiverPhotos

Get the URL to retrieve all photos attached to the given waiver ID

```php
SmartwaiverRoutes::getWaiverPhotos( string $waiverId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

The URL to retrieve the information.

---

### getWaiverSignatures

Get the URL to retrieve all drawn signatures attached to the given waiver ID

```php
SmartwaiverRoutes::getWaiverSignatures( string $waiverId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiverId` | **string** | The Unique identifier of the waiver |


**Return Value:**

The URL to retrieve the information.

---

### search

Get the URL to search for waivers matching the given criteria.

```php
SmartwaiverRoutes::search( string $templateId = &#039;&#039;, string $fromDts = &#039;&#039;, string $toDts = &#039;&#039;, string $firstName = &#039;&#039;, string $lastName = &#039;&#039;, boolean|null $verified = null, boolean $sortDesc = true, string $tag = &#039;&#039; ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | Limit query to signed waivers of the given waiver template ID. |
| `$fromDts` | **string** | Limit query to signed waivers after this ISO 8601 date. |
| `$toDts` | **string** | Limit query to signed waivers before this ISO 8601 date. |
| `$firstName` | **string** | Limit query to signed waivers with any participant having this for a first name (Case Insensitive). |
| `$lastName` | **string** | Limit query to signed waivers with any participant having this for a last name (Case Insensitive). |
| `$verified` | **boolean&#124;null** | Limit query to waivers that have been verified by email (true), not verified (false) or both (null). |
| `$sortDesc` | **boolean** | Sort results in descending (latest signed waiver first) order. |
| `$tag` | **string** | Limit to waivers with this primary tag. |


**Return Value:**

The URL to retrieve the information.

---

### searchResults

Get the URL to retrieve a specific page of a search result

```php
SmartwaiverRoutes::searchResults( string $guid, integer $page ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guid` | **string** | The guid returned by the search request |
| `$page` | **integer** | Which page to retrieve |


**Return Value:**

The URL to retrieve the information.

---

### getWebhookConfig

Get the URL to retrieve the current webhook configuration for the account

```php
SmartwaiverRoutes::getWebhookConfig(  ): string
```

* This method is **static**.

**Return Value:**

The URL to retrieve the information.

---

### setWebhookConfig

Get the URL to set the webhook configuration for this account

```php
SmartwaiverRoutes::setWebhookConfig(  ): string
```

* This method is **static**.

**Return Value:**

The URL to retrieve the information.

---

### getWebhookQueues

Get the URL to retrieve information about state of all webhook queues

```php
SmartwaiverRoutes::getWebhookQueues(  ): string
```

* This method is **static**.

**Return Value:**

The URL to retrieve the information.

---

### getWebhookQueueAccountMessage

Get the URL to retrieve a message from the account queue

```php
SmartwaiverRoutes::getWebhookQueueAccountMessage( boolean $delete = false ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delete` | **boolean** |  |


**Return Value:**

The URL to retrieve the information.

---

### getWebhookQueueTemplateMessage

Get the URL to retrieve a message from the account queue

```php
SmartwaiverRoutes::getWebhookQueueTemplateMessage( string $templateId, boolean $delete = false ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The ID of the waiver template specifying the queue to retrieve from |
| `$delete` | **boolean** | Whether the message should be deleted from the queue while it's retrieved |


**Return Value:**

The URL to retrieve the information.

---

### deleteWebhookQueueAccountMessage

Get the URL to delete a message from the account queue

```php
SmartwaiverRoutes::deleteWebhookQueueAccountMessage( string $messageId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$messageId` | **string** | The ID of the message to delete |


**Return Value:**

The URL to retrieve the information.

---

### deleteWebhookQueueTemplateMessage

Get the URL to delete a message from the account queue

```php
SmartwaiverRoutes::deleteWebhookQueueTemplateMessage( string $templateId, string $messageId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$templateId` | **string** | The ID of the waiver template specifying the queue to delete from |
| `$messageId` | **string** | The ID of the message to delete |


**Return Value:**

The URL to retrieve the information.

---

### createDynamicTemplate

Get the URL to create a new dynamic template

```php
SmartwaiverRoutes::createDynamicTemplate(  ): string
```

* This method is **static**.

**Return Value:**

The URL to create the template.

---

### processDynamicTemplate

Get the URL to request the processing of a signed dynamic waiver

```php
SmartwaiverRoutes::processDynamicTemplate( string $transactionId ): string
```

* This method is **static**.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transactionId` | **string** | The returned transaction Id after the waiver is signed |


**Return Value:**

The URL to request processing.

---

## Smartwaiver/Types/Data/SmartwaiverTemplateData

Class SmartwaiverTemplateData

This class the settings for the body section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Data\SmartwaiverTemplateData
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `adult` | **boolean** |
| public | `addressLineOne` | **string** |
| public | `addressLineTwo` | **string** |
| public | `addressCountry` | **string** |
| public | `addressCity` | **string** |
| public | `addressState` | **string** |
| public | `addressZip` | **string** |
| public | `email` | **string** |
| public | `emergencyContactName` | **string** |
| public | `emergencyContactPhone` | **string** |
| public | `insuranceCarrier` | **string** |
| public | `insurancePolicyNumber` | **string** |
| public | `driversLicenseState` | **string** |
| public | `driversLicenseNumber` | **string** |
| protected | `participants` | **array** |
| protected | `guardian` | **array** |

### addParticipant

Add a participant to the end of the participant array. First Name and Last Name are required, everything else is
optional.

```php
SmartwaiverTemplateData::addParticipant( string $firstName, string $lastName, string|null $middleName = null, string|null $phone = null, string|null $gender = null, string|null $dob = null )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$firstName` | **string** | The first name of the participant |
| `$lastName` | **string** | The last name of the participant |
| `$middleName` | **string&#124;null** | The middle name of the participant |
| `$phone` | **string&#124;null** | The phone number of the participant |
| `$gender` | **string&#124;null** | The gender of the participant |
| `$dob` | **string&#124;null** | The DOB of the participant in ISO 8601 format. |

---

### setGuardian

Set prefill data for the guardian

```php
SmartwaiverTemplateData::setGuardian( string $firstName, string $lastName, string|null $middleName = null, string|null $relationship = null, string|null $phone = null, string|null $gender = null, string|null $dob = null, boolean|null $participant = null )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$firstName` | **string** | The first name of the guardian |
| `$lastName` | **string** | The last name of the guardian |
| `$middleName` | **string&#124;null** | The middle name of the guardian |
| `$relationship` | **string&#124;null** | The relationship of the guardian to the minor |
| `$phone` | **string&#124;null** | The phone number of the guardian |
| `$gender` | **string&#124;null** | The gender of the guardian |
| `$dob` | **string&#124;null** | The DOB of the guardian |
| `$participant` | **boolean&#124;null** | Whether the guardian is also a participant or not |

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateData::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/SmartwaiverCustomField

Class SmartwaiverCustomField

This class represents a custom field inside of a signed waiver.

* Full name: \Smartwaiver\Types\SmartwaiverCustomField
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `value` | **string** |
| public | `displayText` | **string** |

### __construct

Create a SmartwaiverCustomField object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverCustomField::__construct( array $field )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverCustomField::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverDynamicProcess

Class SmartwaiverDynamicProcess

This class represents a newly created dynamic template response.

* Full name: \Smartwaiver\Types\SmartwaiverDynamicProcess
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `transactionId` | **string** |
| public | `waiverId` | **string** |

### __construct

Create a SmartwaiverDynamicProcess object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverDynamicProcess::__construct( array $dynamicProcess )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dynamicProcess` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverDynamicProcess::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverDynamicTemplate

Class SmartwaiverDynamicTemplate

This class represents a newly created dynamic template response.

* Full name: \Smartwaiver\Types\SmartwaiverDynamicTemplate
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `expiration` | **integer** |
| public | `uuid` | **string** |
| public | `url` | **string** |

### __construct

Create a SmartwaiverDynamicTemplate object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverDynamicTemplate::__construct( array $dynamicTemplate )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dynamicTemplate` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverDynamicTemplate::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverFlag

Class SmartwaiverFlag

This class represents a flag on a signed waiver.

* Full name: \Smartwaiver\Types\SmartwaiverFlag
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `displayText` | **string** |
| public | `reason` | **string** |

### __construct

Create a SmartwaiverFlag object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverFlag::__construct( array $field )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverFlag::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverGuardian

Class SmartwaiverGuardian

This class represents all the data for the guardian field

* Full name: \Smartwaiver\Types\SmartwaiverGuardian
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `firstName` | **string** |
| public | `middleName` | **string** |
| public | `lastName` | **string** |
| public | `phone` | **string** |
| public | `relationship` | **string** |

### __construct

Create a SmartwaiverGuardian object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverGuardian::__construct( array $guardian )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guardian` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverGuardian::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverParticipant

Class SmartwaiverParticipant

This class represents a single participant on a signed waiver.

* Full name: \Smartwaiver\Types\SmartwaiverParticipant
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `firstName` | **string** |
| public | `middleName` | **string** |
| public | `lastName` | **string** |
| public | `dob` | **string** |
| public | `isMinor` | **boolean** |
| public | `gender` | **string** |
| public | `phone` | **string** |
| public | `tags` | **array<mixed,string>** |
| public | `flags` | **array<mixed,\Smartwaiver\Types\SmartwaiverFlag>** |
| public | `customParticipantFields` | **array<mixed,\Smartwaiver\Types\SmartwaiverCustomField>** |
| public | `customParticipantFieldsByGuid` | **array<mixed,\Smartwaiver\Types\SmartwaiverCustomField>** |

### __construct

Create a SmartwaiverParticipant object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverParticipant::__construct( array $participant )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$participant` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverParticipant::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverPhoto

Class SmartwaiverPhoto

This class represents all the data a single photo on a waiver

* Full name: \Smartwaiver\Types\SmartwaiverPhoto
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `type` | **string** |
| public | `date` | **string** |
| public | `tag` | **string** |
| public | `fileType` | **string** |
| public | `photoId` | **string** |
| public | `photo` | **string** |

### __construct

Create a SmartwaiverPhoto object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverPhoto::__construct( array $photo )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$photo` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverPhoto::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverPhotos

Class SmartwaiverPhotos

This class represents all the data for the photos of a waiver

* Full name: \Smartwaiver\Types\SmartwaiverPhotos
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `waiverId` | **string** |
| public | `templateId` | **string** |
| public | `title` | **string** |
| public | `createdOn` | **string** |
| public | `photos` | **array<mixed,\Smartwaiver\Types\SmartwaiverPhoto>** |

### __construct

Create a SmartwaiverPhotos object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverPhotos::__construct( array $photos )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$photos` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverPhotos::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverSearch

Class SmartwaiverSearch

This class represents all the data for the result of a search

* Full name: \Smartwaiver\Types\SmartwaiverSearch
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `guid` | **string** |
| public | `count` | **string** |
| public | `pages` | **string** |
| public | `pageSize` | **string** |

### __construct

Create a SmartwaiverSearch object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverSearch::__construct( array $search )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$search` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverSearch::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverSignatures

Class SmartwaiverSignatures

This class represents the data for signatures drawn on a waiver

* Full name: \Smartwaiver\Types\SmartwaiverSignatures
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `waiverId` | **string** |
| public | `templateId` | **string** |
| public | `title` | **string** |
| public | `createdOn` | **string** |
| public | `participantSignatures` | **array<mixed,string>** |
| public | `guardianSignatures` | **array<mixed,string>** |
| public | `bodySignatures` | **array<mixed,string>** |
| public | `bodyInitials` | **array<mixed,string>** |

### __construct

Create a SmartwaiverSignatures object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverSignatures::__construct( array $signatures )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$signatures` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverSignatures::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverTemplate

Class SmartwaiverTemplate

This class represents a waiver template response from the API.

* Full name: \Smartwaiver\Types\SmartwaiverTemplate
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `templateId` | **string** |
| public | `title` | **string** |
| public | `publishedVersion` | **string** |
| public | `publishedOn` | **string** |
| public | `webUrl` | **string** |
| public | `kioskUrl` | **string** |
| public | `vanityUrls` | **array<mixed,string>** |

### __construct

Create a SmartwaiverWaiver object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplate::__construct( array $template )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$template` | **array** | An array to create the template object from |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplate::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverType

Class SmartwaiverType

Base class for all types of returned objects from the API.

* Full name: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| protected | `input` | **array** |

### __construct

SmartwaiverType constructor.

```php
SmartwaiverType::__construct( array $input, array $requiredKeys, string $type )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | **array** | All the data to be put into the object |
| `$requiredKeys` | **array** | The required keys in the input |
| `$type` | **string** | The name of the object type (for errors) |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverType::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverWaiver

Class SmartwaiverWaiver

This class represents a waiver response from the API. Fields from the
response are placed in public variables.

* Full name: \Smartwaiver\Types\SmartwaiverWaiver
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `waiverId` | **string** |
| public | `templateId` | **string** |
| public | `title` | **string** |
| public | `createdOn` | **string** |
| public | `expirationDate` | **string** |
| public | `expired` | **boolean** |
| public | `verified` | **boolean** |
| public | `kiosk` | **boolean** |
| public | `firstName` | **string** |
| public | `middleName` | **string** |
| public | `lastName` | **string** |
| public | `dob` | **string** |
| public | `isMinor` | **boolean** |
| public | `clientIP` | **string** |
| public | `tags` | **array<mixed,string>** |
| public | `flags` | **array<mixed,\Smartwaiver\Types\SmartwaiverFlag>** |
| public | `participants` | **array<mixed,\Smartwaiver\Types\SmartwaiverParticipant>** |
| public | `email` | **string** |
| public | `marketingAllowed` | **boolean** |
| public | `addressLineOne` | **string** |
| public | `addressLineTwo` | **string** |
| public | `addressCity` | **string** |
| public | `addressState` | **string** |
| public | `addressZip` | **string** |
| public | `addressCountry` | **string** |
| public | `emergencyContactName` | **string** |
| public | `emergencyContactPhone` | **string** |
| public | `insuranceCarrier` | **string** |
| public | `insurancePolicyNumber` | **string** |
| public | `driversLicenseNumber` | **string** |
| public | `driversLicenseState` | **string** |
| public | `customWaiverFields` | **array<mixed,\Smartwaiver\Types\SmartwaiverCustomField>** |
| public | `customWaiverFieldsByGuid` | **array<mixed,\Smartwaiver\Types\SmartwaiverCustomField>** |
| public | `guardian` | **\Smartwaiver\Types\SmartwaiverGuardian** |
| public | `photos` | **integer** |
| public | `pdf` | **string** |

### __construct

Create a SmartwaiverWaiver object by providing an array with all the
required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWaiver::__construct( array $waiver )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$waiver` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWaiver::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverWaiverSummary

Class SmartwaiverWaiverSummary

This class represents a waiver summary response from the API. These are
found in the waiver list call.

* Full name: \Smartwaiver\Types\SmartwaiverWaiverSummary
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `waiverId` | **string** |
| public | `templateId` | **string** |
| public | `title` | **string** |
| public | `createdOn` | **string** |
| public | `expirationDate` | **string** |
| public | `expired` | **boolean** |
| public | `verified` | **boolean** |
| public | `kiosk` | **boolean** |
| public | `firstName` | **string** |
| public | `middleName` | **string** |
| public | `lastName` | **string** |
| public | `dob` | **string** |
| public | `isMinor` | **boolean** |
| public | `tags` | **array<mixed,string>** |
| public | `flags` | **array<mixed,\Smartwaiver\Types\SmartwaiverFlag>** |

### __construct

Create a SmartwaiverWaiverSummary object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWaiverSummary::__construct( array $summary )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$summary` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWaiverSummary::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/SmartwaiverWebhook

Class SmartwaiverWebhook

This class represents a webhook configuration.

* Full name: \Smartwaiver\Types\SmartwaiverWebhook
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `endpoint` | **string** |
| public | `emailValidationRequired` | **string** |

### __construct

Create a SmartwaiverWebhook object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhook::__construct( array $webhook )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhook` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhook::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/Template/SmartwaiverTemplateBody

Class SmartwaiverTemplateBody

This class the settings for the body section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateBody
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `text` | **string** |

### __construct

Create a SmartwaiverTemplateBody object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateBody::__construct( array $body = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$body` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateBody::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateBody::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateCompletion

Class SmartwaiverTemplateCompletion

This class the settings for the completion section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateCompletion
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `redirectSuccess` | **string** |
| public | `redirectCancel` | **string** |

### __construct

Create a SmartwaiverTemplateCompletion object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateCompletion::__construct( array $completion = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$completion` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateCompletion::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateCompletion::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateConfig

Class SmartwaiverTemplateConfig

This class the settings for the config section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateConfig
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `meta` | **\Smartwaiver\Types\Template\SmartwaiverTemplateMeta** |
| public | `header` | **\Smartwaiver\Types\Template\SmartwaiverTemplateHeader** |
| public | `body` | **\Smartwaiver\Types\Template\SmartwaiverTemplateBody** |
| public | `participants` | **\Smartwaiver\Types\Template\SmartwaiverTemplateParticipants** |
| public | `standardQuestions` | **\Smartwaiver\Types\Template\SmartwaiverTemplateStandardQuestions** |
| public | `guardian` | **\Smartwaiver\Types\Template\SmartwaiverTemplateGuardian** |
| public | `electronicConsent` | **\Smartwaiver\Types\Template\SmartwaiverTemplateElectronicConsent** |
| public | `styling` | **\Smartwaiver\Types\Template\SmartwaiverTemplateStyling** |
| public | `completion` | **\Smartwaiver\Types\Template\SmartwaiverTemplateCompletion** |
| public | `signatures` | **\Smartwaiver\Types\Template\SmartwaiverTemplateSignatures** |
| public | `processing` | **\Smartwaiver\Types\Template\SmartwaiverTemplateProcessing** |

### __construct

Create a SmartwaiverTemplateConfig object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateConfig::__construct( array $config = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$config` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateConfig::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateConfig::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateElectronicConsent

Class SmartwaiverTemplateElectronicConsent

This class the settings for the electronicConsent section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateElectronicConsent
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `title` | **string** |
| public | `verbiage` | **string** |

### __construct

Create a SmartwaiverTemplateElectronicConsent object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateElectronicConsent::__construct( array $electronicConsent = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$electronicConsent` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateElectronicConsent::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateElectronicConsent::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateGuardian

Class SmartwaiverTemplateGuardian

This class the settings for the guardian section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateGuardian
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `verbiage` | **string** |
| public | `verbiageParticipantAddendum` | **string** |
| public | `label` | **string** |
| public | `relationship` | **boolean** |
| public | `ageVerification` | **boolean** |

### __construct

Create a SmartwaiverTemplateGuardian object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateGuardian::__construct( array $guardian = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$guardian` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateGuardian::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateGuardian::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateHeader

Class SmartwaiverTemplateHeader

This class the settings for the header section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateHeader
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `logoImage` | **string** |
| public | `text` | **string** |

### __construct

Create a SmartwaiverTemplateHeader object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateHeader::__construct( array $header = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$header` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateHeader::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateHeader::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateMeta

Class SmartwaiverTemplateMeta

This class the settings for the meta section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateMeta
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `title` | **string** |
| public | `language` | **string** |

### __construct

Create a SmartwaiverTemplateMeta object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateMeta::__construct( array $meta = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateMeta::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateMeta::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateParticipants

Class SmartwaiverTemplateParticipants

This class the settings for the participants section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateParticipants
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `adults` | **boolean** |
| public | `minorsEnabled` | **boolean** |
| public | `multipleMinors` | **boolean** |
| public | `minorsWithoutAdults` | **boolean** |
| public | `adultsAndMinors` | **boolean** |
| public | `ageOfMajority` | **integer** |
| public | `participantLabel` | **string** |
| public | `participatingText` | **string** |
| public | `middleName` | **boolean** |
| public | `phone` | **boolean** |
| public | `gender` | **boolean** |
| public | `dobType` | **string** |

### __construct

Create a SmartwaiverTemplateParticipants object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateParticipants::__construct( array $participants = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$participants` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateParticipants::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateParticipants::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateProcessing

Class SmartwaiverTemplateProcessing

This class the settings for the processing section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateProcessing
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `emailBusinessName` | **string** |
| public | `emailReplyTo` | **string** |
| public | `emailCustomTextEnabled` | **boolean** |
| public | `emailCustomTextWeb` | **string** |
| public | `emailCCEnabled` | **boolean** |
| public | `emailCCWebEnabled` | **boolean** |
| public | `emailCCEmails` | **array** |
| public | `emailIncludeBarcodes` | **boolean** |

### __construct

Create a SmartwaiverTemplateProcessing object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateProcessing::__construct( array $processing = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$processing` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateProcessing::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateProcessing::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateSignatures

Class SmartwaiverTemplateSignatures

This class the settings for the signatures section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateSignatures
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `type` | **string** |
| public | `minor` | **boolean** |
| public | `defaultChoice` | **string** |

### __construct

Create a SmartwaiverTemplateSignatures object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateSignatures::__construct( array $signatures = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$signatures` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateSignatures::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateSignatures::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateStandardQuestions

Class SmartwaiverTemplateStandardQuestions

This class the settings for the standardQuestions section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateStandardQuestions
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `addressEnabled` | **boolean** |
| public | `addressRequired` | **boolean** |
| public | `addressDefaultCountry` | **string** |
| public | `addressDefaultState` | **string** |
| public | `emailVerification` | **boolean** |
| public | `emailMarketingEnabled` | **boolean** |
| public | `emailMarketingOptInText` | **string** |
| public | `emailMarketingDefaultChecked` | **boolean** |
| public | `emergencyContactEnabled` | **boolean** |
| public | `insuranceEnabled` | **boolean** |
| public | `idCardEnabled` | **boolean** |

### __construct

Create a SmartwaiverTemplateStandardQuestions object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateStandardQuestions::__construct( array $standardQuestions = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$standardQuestions` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateStandardQuestions::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateStandardQuestions::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/Template/SmartwaiverTemplateStyling

Class SmartwaiverTemplateStyling

This class the settings for the styling section of a Smartwaiver Template

* Full name: \Smartwaiver\Types\Template\SmartwaiverTemplateStyling
* Parent class: \Smartwaiver\Types\SmartwaiverType
* This class implements: \Smartwaiver\Types\SmartwaiverInputType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `style` | **string** |
| public | `customBackground` | **string** |
| public | `customBorder` | **string** |
| public | `customShadow` | **string** |

### __construct

Create a SmartwaiverTemplateStyling object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverTemplateStyling::__construct( array $styling = array() )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$styling` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverTemplateStyling::getArrayInput(  ): array
```

**Return Value:**

The input array

---

### apiArray

Return the array to be passed to the api representing this object

```php
SmartwaiverTemplateStyling::apiArray(  ): \ArrayObject
```
---

## Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessage

Class SmartwaiverWebhookMessage

This class represents information about a smartwaiver webhook message

* Full name: \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessage
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `messageId` | **string** |
| public | `payload` | **\Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessagePayload** |

### __construct

Create a SmartwaiverWebhookMessage object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhookMessage::__construct( array $webhookMessage )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhookMessage` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhookMessage::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessageDelete

Class SmartwaiverWebhookMessageDelete

This class represents information returned from deleting a webhook message

* Full name: \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessageDelete
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `success` | **boolean** |

### __construct

Create a SmartwaiverWebhookMessageDelete object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhookMessageDelete::__construct( array $webhookMessageDelete )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhookMessageDelete` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhookMessageDelete::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookMessagePayload

Class SmartwaiverWebhookMessagePayload

This class represents information about a webhook message payload

* Full name: \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookMessagePayload
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `uniqueId` | **string** |
| public | `event` | **string** |

### __construct

Create a SmartwaiverWebhookMessagePayload object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhookMessagePayload::__construct( array $webhookMessagePayload )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhookMessagePayload` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhookMessagePayload::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookQueue

Class SmartwaiverWebhookQueue

This class represents information about a smartwaiver webhook queue

* Full name: \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueue
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `messagesTotal` | **integer** |
| public | `messagesNotVisible` | **integer** |
| public | `messagesDelayed` | **integer** |

### __construct

Create a SmartwaiverWebhookQueue object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhookQueue::__construct( array $webhookQueue )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhookQueue` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhookQueue::getArrayInput(  ): array
```

**Return Value:**

The input array

---

## Smartwaiver/Types/WebhookQueues/SmartwaiverWebhookQueues

Class SmartwaiverWebhookQueues

This class contains information about counts in all your webhook queues.

* Full name: \Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueues
* Parent class: \Smartwaiver\Types\SmartwaiverType


**Properties:**

| Visibility | Name | Type |
|------------|------|------|
| public | `accountQueue` | **\Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueue** |
| public | `templateQueues` | **array<mixed,\Smartwaiver\Types\WebhookQueues\SmartwaiverWebhookQueue>** |

### __construct

Create a SmartwaiverWebhookQueues object by providing an array with all
the required keys. See REQUIRED_KEYS for that information.

```php
SmartwaiverWebhookQueues::__construct( array $webhookQueues )
```

Checks that all the required keys for the given object type exist

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$webhookQueues` | **array** | The input array containing all the information |

---

### getArrayInput

Retrieve the input array this object was constructed from

```php
SmartwaiverWebhookQueues::getArrayInput(  ): array
```

**Return Value:**

The input array

---

