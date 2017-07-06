# PHP Diff

This library simply gets the differences between strings with a few options to output the changes into raw `array`, `xml` or `text` formats.

[![Build Status](https://secure.travis-ci.org/ohmybrew/php-diff.png?branch=master)](http://travis-ci.org/ohmybrew/php-diff)
[![Coverage Status](https://coveralls.io/repos/github/ohmybrew/php-diff/badge.svg?branch=master)](https://coveralls.io/github/ohmybrew/php-diff?branch=master)
[![License](https://poser.pugx.org/ohmybrew/php-diff/license)](https://packagist.org/packages/ohmybrew/php-diff)

## Installation

The recommended way to install is [through composer](http://packagist.org).

    $ composer require ohmybrew/php-diff

## Usage

```php
<?php

use Wally\PHPDiff\Diff;
use Wally\PHPDiff\Format\Text;

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
use Wally\PHPDiff\Format\XML;

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