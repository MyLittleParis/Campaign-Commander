Campaign Commander
==================

> Campaign Commander is the stuff you need to manage your Campaign Commander.

# About

PHP Campaign Commander is a (wrapper)library to communicate with the [Campaign Commander](http://www.campaigncommander.com) API.

- this library is developed with PHP 5.4.4

# License

PHP Campaign Commander is [BSD](http://en.wikipedia.org/wiki/BSD_licenses) licensed.

# Documentation

## Installation

### With Composer
First install composer in your system with the [official documentation](https://getcomposer.org/doc/01-basic-usage.md#installation).

Add a file named composer.json to your project root
Edit this composer.json and add the following content to it :

```json
{
	"require": {
		"mylittleparis/campaign-commander": "dev-develop"
	},
}	
```

## Basic usage

```php
<?php
namespace Acme\Demo;

use MyLittle\CampaignCommander\API\SOAP\Client;
use MyLittle\CampaignCommander\Service\MemberService;

$client = new Client('LOGIN', 'PASSWORD', 'KEY', 'SERVER')
$memberService = new MemberService($client);

$id = '1';
$response = $memberService->getMemberById($id);

var_dump($response);
```

If you want to sent a file at the API, it is advisable to use Mtom attachment.
This library provides a client for it with the namespace following : 

```php
use MyLittle\CampaignCommander\API\SOAP\ClientWithMTOMAttachments;
```

You can use your own client but it need to implement the client interface provided in this library with the namespace following : 

```php
use MyLittle\CampaignCommander\API\SOAP\Model\ClientInterface;
```

## Testing
### PHPUnit
this library comes with some unit tests. if you plan to run these tests, you can do it simply by running phpunit in the project root directory like that : 

```bash
$ cd /path/to/lib
$ phpunit
```

For more information about PHPUnit, you can read the [official documentation](http://phpunit.de/manual/3.7/en/index.html)

The tests are located in the folder ```tests/```.


# Sites using this class

* [Music Hall Group](http://www.musichallgroup.be)
* [Vorst National](http://www.vorstnationaal.be)
* [Stadsschouwburg Antwerpen](http://www.stadsschouwburgantwerpen.be)
* [Capitole Gent](http://www.capitolegent.be)
* [Music Hall](http://www.musichall.be)
* [My Culture](http://www.myculture.be)
* [Zuiderkroon](http://www.zuiderkroon.be)