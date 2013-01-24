# PHP Diff

This library simply gets the differences between strings with a few options to output the changes into raw `array`, `xml` or `text` formats.

[![Build Status](https://secure.travis-ci.org/tyler-king/php-diff.png?branch=master)](http://travis-ci.org/tyler-king/php-diff)

## Fetch

The recommended way to install PHP Difff is [through composer](http://packagist.org).

Just create a composer.json file for your project:

```JSON
{
    "minimum-stability" : "dev",
    "require": {
        "tyler-king/php-diff": "dev-master"
    }
}
```

And run these two commands to install it:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar install

Now you can add the autoloader, and you will have access to the library:

```php
<?php
require 'vendor/autoload.php';
```

## Usage

```php
<?php

use Wally\Diff;
use Wally\Format\Text;

$diff = new Diff;
$diff->setStringOne(
<<<EOF
one
two
three
EOF
);
$diff->setStringTwo(
<<<EOF
one
two
threes
six
EOF
);
$diff->execute();

$result = $diff->getResult(); // This outputs a raw array of line, delete and insert operations.

$format = new Text($result);
$format->execute();

header('Content-Type: '.$format->getFormatMime());
print $format->getResult();
```

The output is:

```
one
two
- three
+ threes
+ six
```

Above was the use of the `text` output. You may also output the raw `array` via `$diff->getResult()` or you can ouput in XML format like below:

```php
use Wally\Format\XML;

...

$result = $diff->getResult();

$format = new XML($result);
$format->execute();

header('Content-Type: '.$format->getFormatMime());
print $format->getResult();
```

The output is:

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<data>
<line>one</line>
<line>two</line>
<delete>three</delete>
<insert>threes</insert>
<insert>six</insert>
</data>
```