.. title:: Converters

==========
Converters
==========

This section will provide you general information on how to use converters.

Converting
==========

To convert a ``ConvertibleValue`` to another ``Unit``, you have to call the ``convert`` method.
The method works as follows: convert `X of Unit Y` to `Unit Z`.
The ``convert`` method returns a ``ConvertibleValue``, that you can use for further operations.
Let's have a look at the convert methods signature:

.. code-block:: php

    <?php
    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue;

Here is a quick example that shows how to convert `110 centimeters` to `meters`:

.. code-block:: php

    <?php
    $converter = new LengthConverter();

    $result = $converter->convert(new ConvertibleValue('110', $converter::$centimeter), $converter::$meter);

    $result->getValue(); // '1.10...' with 999 decimals
    $result->getFloatValue(); // 1.1
    $result->getUnit()->getAbbreviation(); // 'm'
    $result->getUnit()->getName(); // 'meter'

Mathematical operations
=======================

Most converters extend the ``AbstractMathematicalConverter``, which provides some basic mathematical operations.
These are examples for adding and subtracting values, even if they are provided in different units.
Mathematical operations keep the ``Unit`` of the first ``ConvertibleValue``.

.. code-block:: php

    <?php
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

Feel free to nest mathematical operations and conversions as you like,
as they all work on ``ConvertibleValue``, which is the return type of all operations.

.. code-block:: php

    <?php
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

Adding your own units
=====================

All converters already provide a lot of units that you can use for conversions.
However, if you are missing a ``Unit``, you can add it to the converter and start using it.
To add a ``Unit`` to the converter, just use the ``addUnit`` or ``setUnits`` method.
Make sure to read about Unit_, before you start adding your own units.

.. code-block:: php

    <?php
    $converter = new LengthConverter();
    $myUnit = new Unit('myUnit', 'mu', '5');
    $converter->addUnit($myUnit);

    $result = $converter->convert(new ConvertibleValue('1', $converter::$meter), $myUnit);

    $result->getValue(); // '5.0' with 999 decimals
    $result->getFloatValue(); // 5
    $result->getUnit()->getAbbreviation(); // 'mu'
    $result->getUnit()->getName(); // 'myUnit'

.. note:: Not all converters are factor-based converters.
          Some converters, like the TemperatureConverter, convert based on formulas, so they don't provide
          a ``addUnit`` oder ``setUnits`` method. If you want to add your own units, you need to extend the converter.
          See `Extending converters`_ for further information.

Extending converters
====================

Not all converters are factor-based converters.
Some converters, like the TemperatureConverter, convert based on formulas, so they don't provide a ``addUnit`` oder ``setUnits`` method.
If you want to add your own units, you need to extend the converter.

This example shows you how to extend the ``TemperatureConverter`` and how you add your own unit `myUnit`.
The steps are:

- Extend the ``TemperatureConverter``
- Add your own Unit as static member variable `myUnit`
- Call the parent constructor and afterwards initialize your own unit `myUnit` and add it to the `units` array.
- Override the ``getName`` method and return your own name `mytemperature`
- Override the ``normalize`` method and add a case for your own unit `myUnit`
- Override the ``convertTo`` method and add a case for your own unit `myUnit`

.. code-block:: php

    <?php

    namespace Xynnn\Unicorn\Converter;

    use Xynnn\Unicorn\Model\Unit;
    use Xynnn\Unicorn\Model\ConvertibleValue;

    class MyOwnTemperatureConverter extends TemperatureConverter
    {

        /**
         * @var Unit $myUnit Static instance for conversions
         */
        public static $myUnit;

        /**
         * LengthConverter constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->units[] = self::$myUnit = new Unit('MyUnit ', 'mu');
        }

        /**
         * @return string Name of the converter
         */
        public function getName(): string
        {
            return 'unicorn.converter.mytemperature';
        }

        /**
         * @param ConvertibleValue $cv The Convertible to be normalized
         */
        protected function normalize(ConvertibleValue $cv)
        {
            switch ($cv->getUnit()) {

                case self::$fahrenheit:
                    $value = bcdiv(bcmul(bcsub($cv->getValue(), '32', self::MAX_DECIMALS), '5', self::MAX_DECIMALS), '9', self::MAX_DECIMALS);
                    break;

                case self::$kelvin:
                    $value = bcsub($cv->getValue(), '273.15', self::MAX_DECIMALS);
                    break;

                case self::$myUnit:
                    $value = 1 * 1; // add your own formula
                    break;

                default:
                    $value = $cv->getValue();

            }

            $cv->setValue($value);
            $cv->setUnit($this->getBaseUnit());
        }

        /**
         * @param ConvertibleValue $from The convertible to be converted
         * @param Unit $to               Unit to which is to be converted
         */
        protected function convertTo(ConvertibleValue $from, Unit $to)
        {
            switch ($to) {

                case self::$fahrenheit:
                    $value = bcadd(bcdiv(bcmul($from->getValue(), '9', self::MAX_DECIMALS), '5', self::MAX_DECIMALS), '32', self::MAX_DECIMALS);
                    break;

                case self::$kelvin:
                    $value = bcadd($from->getValue(), '273.15', self::MAX_DECIMALS);
                    break;

                case self::$myUnit:
                    $value = 1 * 1; // add your own formula
                    break;

                default:
                    $value = $from->getValue();

            }

            $from->setValue($value);
            $from->setUnit($to);
        }

    }

.. note:: If you're using a factor-based converter, normally there is no reason to extend a converter.
          Better use the ``addUnit`` oder ``setUnits`` methods instead.
          See `Adding your own units`_ for further information.

Converter Registry
==================

If you need to use more than one converter in your project, but you don't want to inject every single converter, you can add a set
of converters to the ``ConverterRegistry`` and inject the registry instead.

The ``ConverterRegistry`` can be instantiated with an array of converters:

.. code-block:: php

    <?php
    $registry = new ConverterRegistry([
        new LengthConverter(),
        new CurrencyConverter(),
        new TemperatureConverter(),
        new DataStorageConverter(),
        new DataTransferConverter()
    ]);

You can also add converters using the ``add`` method:

.. code-block:: php

    <?php
    $registry = new ConverterRegistry();
    $registry->add(new LengthConverter());

To get a converter instance from the ``ConverterRegistry``, use the ``get`` method with the name of the converter:

.. code-block:: php

    <?php
    $registry = new ConverterRegistry([
        new LengthConverter(),
        new CurrencyConverter()
    ]);

   $lengthConverter = $registry->get('unicorn.converter.length');

Converter Implementations
=========================

.. toctree::
   :maxdepth: 1

   length-converter
   currency-converter
   temperature-converter
   data-storage-converter
   data-transfer-converter

.. _Extending Converters:: http://unicorn.readthedocs.io/en/latest/converters.html#extending-converters
.. _Adding your own units:: http://unicorn.readthedocs.io/en/latest/converters.html#adding-your-own-units
.. _Unit:: http://unicorn.readthedocs.io/en/latest/convertible-value-unit.html#unit