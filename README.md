Campaign Commander
==================

> Campaign Commander is the stuff you need to manage your Campaign Commander.

# About

PHP Campaign Commander is a library to communicate with the [Campaign Commander](http://www.campaigncommander.com) API.

# License

PHP Campaign Commander is [BSD](http://en.wikipedia.org/wiki/BSD_licenses) licensed.

# Documentation

## Requirements
* PHP >= 5.4.4
* soap extension

## Installation through Composer

```json
{
	"require": {
		"mylittleparis/campaign-commander": "dev-master"
	},
}	
```

## Architecture

This library is structured on 2 layers:

* Low-level API clients : only SOAP (using [BeSimple lib](https://github.com/BeSimple/BeSimpleSoapClient)) clients are provided (one for standard requests, one for requests containing attachments)
* Mid-level API services : using low-level clients, they are mapped to CampaignCommander API methods and allow you to really work with CampaignCommander

## Basic usage

### Principle:

1. Instantiate a mid-level service with an appropriate low-level API client factory
2. Enjoy the service methods :)

### Example : create an export from a segment

```php
use BeSimple\SoapClient as Soap;
use MyLittle\CampaignCommander\API\SOAP as Client;
use MyLittle\CampaignCommander\Service as Service;

$clientFactory = new Client\StandardClientFactory(new Soap\SoapClientBuilder(), 'login', 'password', 'key', 'http://emvapi.emv3.com');
$service = new Service\MemberExportService($clientFactory);
try {
	$result = $service->createDownloadByMailinglist('ID_SEGMENT', 'ALL_MEMBERS', 'EMAIL,FIELD1', 'PIPE', 'true', 'EMAIL', 'true');
}
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
