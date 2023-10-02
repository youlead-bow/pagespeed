PageSpeed Insights API
======================

A PHP module to interact with the [PageSpeed Insights API](https://developers.google.com/speed/docs/insights/v2/getting-started) on Symfony project.

Installation
============

The best way to install the library is by using [Composer](http://getcomposer.org). Add the following to `composer.json` in the root of your project:

``` javascript
{
    "require": {
        "youlead-bow/pagespeed": "~1.0"
    }
}
```

Then, on the command line:

``` bash
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

Use the generated `vendor/.composer/autoload.php` file to autoload the library classes.

Basic usage
===================

```php
<?php

$pageSpeed = new PageSpeed\Service();
$pageSpeed->getResults('http://www.example.com');
```
