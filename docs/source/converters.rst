.. title:: Converters

==========
Converters
==========

This section will provide you general information on how to use converters.

Converting
==========

To convert a ConvertibleValue to another Unit, you have to call the convert method.
The method works as follows: convert "X of Unit Y" to "Unit Z".
The convert method returns a ConvertibleValue, that you can use for further operations.
Let's have a look at the convert methods signature:

.. code-block:: php

    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue;

Here is a quick example that shows how to convert 110 centimeters to meters:

.. code-block:: php

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
    $myUnit = new Unit('myUnit', 'mu', '5');
    $converter->addUnit($myUnit);

    $result = $converter->convert(new ConvertibleValue('1', $converter::$meter), $myUnit);

    $result->getValue(); // '5.0' with 999 decimals
    $result->getFloatValue(); // 5
    $result->getUnit()->getAbbreviation(); // 'mu'
    $result->getUnit()->getName(); // 'myUnit'

The converters currently providing the addUnit method are:

- LengthConverter
- CurrencyConverter
- DataStorageConverter
- DataTransferConverter

Mathematical operations
=======================

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

Converter Registry
==================

some text here

Converter Implementations
=========================

.. toctree::
   :maxdepth: 3

   length-converter
   currency-converter
   temperature-converter
   data-storage-converter
   data-transfer-converter