# Courier - HTTP Requests Made Easy #

[![Build Status](https://travis-ci.org/codezero-be/courier.svg?branch=master)](https://travis-ci.org/codezero-be/courier)
[![Latest Stable Version](https://poser.pugx.org/codezero/courier/v/stable.svg)](https://packagist.org/packages/codezero/courier)
[![Total Downloads](https://poser.pugx.org/codezero/courier/downloads.svg)](https://packagist.org/packages/codezero/courier)
[![License](https://poser.pugx.org/codezero/courier/license.svg)](https://packagist.org/packages/codezero/courier)

This package offers an easy to use set of functions to send HTTP requests in PHP.

## Features ##

- Easy to use GET, POST, PUT, PATCH and DELETE functions (see [usage](#usage))
- Send optional data and headers with your requests
- Use optional basic authentication with your requests
- Optional Caching (only [Laravel](http://www.laravel.com/ "Laravel") implementation included)
- Optional [Laravel](http://www.laravel.com/ "Laravel") ServiceProvider included

> Currently there is only one library that this package uses internally to make the HTTP requests: [codezero-be/curl](https://github.com/codezero-be/curl "codezero-be/curl"). This library uses the cURL extention behind the scenes. It is possible however to write other implementations by implementing the `CodeZero\Courier\Courier` interface.

## Installation ##

Install this package through Composer:

    "require": {
    	"codezero/courier": "1.*"
    }

## Manual Implementation ##

At this point there is only one Courier implementation: `CurlCourier`. All of its arguments are optional, including a `Cache` driver which is only available for Laravel at the moment. 

    use CodeZero\Courier\CurlCourier;

    $courier = new CurlCourier();

## Laravel 5 Implementation ##

After installing, update your `config/app.php` file to include a reference to this package's service provider in the providers array:

    'providers' => [
	    'CodeZero\Courier\CourierServiceProvider'
    ]

## Usage ##

##### Inject the Courier instance into your own class: #####

    use CodeZero\Courier\Courier; //=> The interface

    class MyClass {

	    private $courier;
	
	    public function __construct(Courier $courier)
	    {
	        $this->courier = $courier;
	    }
    }

Laravel will then find the `Courier` class automatically if you registered the service provider.
Or you can inject an instance manually: `$myClass = new MyClass($courier);`

##### Configure your request: #####

	$url = 'http://my.site/api';
    $data = ['do' => 'something', 'with' => 'this']; //=> Optional
    $headers = ['Some Header' => 'Some Value']; //=> Optional

	// Optional number of minutes to cache the request/response.
	// Until it expires Courier will not actually hit the 
	// requested URL, but return a cached response!
	// At the moment this is only usable for Laravel
	// Default = 0 (no caching)
	$cacheMinutes = 30;

##### Send the request: (one of the following) #####

	$response = $this->courier->get($url, $data, $headers, $cacheMinutes);
	$response = $this->courier->post($url, $data, $headers, $cacheMinutes);
	$response = $this->courier->put($url, $data, $headers, $cacheMinutes);
	$response = $this->courier->patch($url, $data, $headers, $cacheMinutes);
	$response = $this->courier->delete($url, $data, $headers, $cacheMinutes);

All of these methods will return an instance of the `CodeZero\Courier\Response` class.

##### Get the response body #####

	$body = $response->getBody();

##### Get additional request info #####

	$httpCode = $response->getHttpCode(); //=> "200"
	$httpMessage = $response->getHttpMessage(); //=> "OK"
	$responseType = $response->getResponseType(); //=> "application/json"
	$responseCharset = $response->getResponseCharset(); //=> "UTF-8" 

##### Convert the response to an array #####

If you are sending API requests, chances are high that you get JSON data in return. To convert this data to a PHP array just run:

	$array = $response->toArray();

This will also work if the response is of type `application/binary` and serializable (like the Flickr API `php_serial` responses).

If the conversion fails, a `CodeZero\Courier\Exceptions\ResponseConversionException` will be thrown.

## Caching ##

To enable caching, there are 2 conditions:

1. Courier needs to be instantiated with the `CodeZero\Courier\Cache\Cache` class and a valid implementation of the `CodeZero\Courier\Cache\CacheManager` has to be provided to this dependency.
2. Caching minutes need to be greater than zero (default: 0)

##### Each request can have a different cache time: #####

Just specify it in the method call: 

	$this->courier->get($url, $data, $headers, $cacheMinutes); 

##### Clear the cache at runtime: #####

	$this->courier->forgetCache();

## Basic Authentication ##

If you require the use of basic authentication, you can enable this before sending the request:

	$this->courier->setBasicAuthentication('username', 'password');

You can also undo this:

	$this->courier->unsetBasicAuthentication();

## Exceptions ##

#### Request issues ####

A `CodeZero\Courier\Exceptions\RequestException` will be thrown, if  the request could not be executed. This might be the case if your request is not properly configured (unsupported protocol, etc.).

#### Response issues ####

A `CodeZero\Courier\Exceptions\HttpRequestException` will be thrown, if there was a HTTP response error >= 400.

---
[![Analytics](https://ga-beacon.appspot.com/UA-58876018-1/codezero-be/courier)](https://github.com/igrigorik/ga-beacon)