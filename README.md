# Unicorn

[![Code Coverage](https://scrutinizer-ci.com/g/xyNNN/unicorn/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/xyNNN/unicorn/?branch=master)
[![Build Status](https://travis-ci.org/xyNNN/unicorn.svg?branch=master)](https://travis-ci.org/xyNNN/unicorn)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/xyNNN/unicorn/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/xyNNN/unicorn/?branch=master)
[![License](https://poser.pugx.org/xynnn/unicorn/license)](https://github.com/xyNNN/unicorn/blob/master/LICENSE.md)

![Unicorn Logo](https://github.com/xynnn/unicorn/blob/master/unicorn.png?raw=true)

A PHP based framework agnostic library to convert several units

* [Unicorn on Packagist](https://packagist.org/packages/xynnn/unicorn)
* [Unicorn on GitHub](https://github.com/xynnn/unicorn)

## Documentation

[http://unicorn.readthedocs.io](http://unicorn.readthedocs.io)

## Conversion example

Here is a quick example that shows how to convert `110 centimeters` to `meters`:

```php
$converter = new LengthConverter();

try {
    $result = $converter->convert(
        new ConvertibleValue('110', $converter::$centimeter),
        $converter::$meter
    );
    
    $result->getValue(); // '1.10...' with 999 decimals
    $result->getFloatValue(); // 1.1
    $result->getUnit()->getAbbreviation(); // 'm'
    $result->getUnit()->getName(); // 'meter'
} catch (UnsupportedUnitException $e) {
    // Unit might not be present in the converters units array
} catch (InvalidArgumentException $e) {
    // Something is wrong with the provided ConvertibleValue or Unit
}
```

## Requirements

- PHP 7.0 or higher
- BCMath extension installed and enabled

## Installation

Open a command console, enter your project directory and execute the
following command to download the latest stable version of unicorn:

```bash
composer require xynnn/unicorn
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Authors

**Philipp Bräutigam**

+ [github/xyNNN](https://github.com/xyNNN)
+ [twitter/xyNNN](http://twitter.com/xyNNN)

**Steffen Brand**

+ [github/steffenbrand](https://github.com/steffenbrand)

## License

Copyright (c) 2016 Philipp Bräutigam, Steffen Brand and contributors.  
This repository is released under the GNU LGPL v3.0 license.
