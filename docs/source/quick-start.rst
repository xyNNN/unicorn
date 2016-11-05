.. title:: Quick Start

===========
Quick Start
===========

For those who are in a hurry, this section provides examples to get started very quickly.
We also provide some simplified, working examples_ in our source code.

.. _examples: https://github.com/xyNNN/unicorn/blob/master/tests/Converter/SimplifiedExamplesTest.php

Installation
============

.. code-block:: bash

    composer require xynnn/unicorn

Simple conversion
=================

All operations require you to wrap your values in a ConvertibleValue.
A ConvertibleValue contains the value itself and its unit.
All converters provide a number of predefined units as static variables, that you can use.
The schema of the convert method is: convert ("x" of "unit") to ("unit").
The convert method returns a ConvertibleValue, that you can use for further operations.

.. code-block:: php

    // example for simple conversion of 100 centimeter to meter
    $converter = new LengthConverter();

    $result = $converter->convert(new ConvertibleValue('110', $converter::$centimeter), $converter::$meter);

    $result->getValue(); // '1.10...' with 999 decimals
    $result->getFloatValue(); // 1.1
    $result->getUnit()->getAbbreviation(); // 'm'
    $result->getUnit()->getName(); // 'meter'

Adding your own units
=====================

Most converters already provide a lot of units that you can use for conversions.
However, if you are missing a Unit, you can add it to the converter and start using it.
The method addUnit is only present on converters with factor-based conversion.
F.e. the Factor to convert from centimeter to meter is 100, while the factor to convert from kilometer to meter is 0.001.
So the factor tells the converter how to normalize the given value to its base unit.
Adding units to formula-based converters, like the TemperatureConverter, is currently not supported.

.. code-block:: php

    $converter = new LengthConverter();
    $converter->addUnit(new Unit('myUnit', 'mu', '5'));

    $result = $converter->convert(new ConvertibleValue('1', $converter::$meter), new Unit('myUnit', 'mu', '5'));

    $result->getValue(); // '5.0' with 999 decimals
    $result->getFloatValue(); // 5
    $result->getUnit()->getAbbreviation(); // 'mu'
    $result->getUnit()->getName(); // 'myUnit'

Simple mathematical operations
==============================

Most converters extend the AbstractMathematicalConverter, which provides some basic mathematical operations.
These are examples for adding and subtracting values, even if they are provided in different units.
Mathematical operations keep the unit of the first ConvertibleValue.

.. code-block:: php

    $converter = new LengthConverter();

    // addition
    $resultAdd = $converter->add(
        new ConvertibleValue('1', $converter::$meter),
        new ConvertibleValue('200', $converter::$centimeter)
    );

    $resultAdd->getValue(); // '2.0' with 999 decimals
    $resultAdd->getFloatValue(); // 2
    $resultAdd->getUnit()->getAbbreviation(); // 'm'
    $resultAdd->getUnit()->getName(); // 'meter'

    // subtraction
    $resultSub = $converter->sub(
        new ConvertibleValue('500', $converter::$centimeter),
        new ConvertibleValue('3', $converter::$meter)
    );

    $resultSub->getValue(); // '200.0' with 999 decimals
    $resultSub->getFloatValue(); // 200
    $resultSub->getUnit()->getAbbreviation(); // 'cm'
    $resultSub->getUnit()->getName(); // 'centimeter'

Nesting
=======

Feel free to nest mathematical operations and conversions as you like, as they all work on ConvertibleValue, which
is the return type of all operations.

.. code-block:: php

    $converter = new LengthConverter();

    $result = $converter->convert(
        $converter->add(
            $converter->add(
                new ConvertibleValue('10000', $converter::$nanometer),
                new ConvertibleValue('10', $converter::$micrometer)
            ),
            new ConvertibleValue('30000', $converter::$nanometer)
        ),
        $converter::$micrometer
    );