.. title:: ConvertibleValue and Unit

=========================
ConvertibleValue and Unit
=========================

This section will provide you general information on units how to use the ConvertibleValue,
which is unicorns general data transfer object.

Unit
====

It consists of three properties:

- name: the full name of the unit, f.e. "centimeter"
- abbreviation: the abbreviation of the unit, f.e "cm"
- factor: the factor to normalize this unit to the converters base unit

It is important to understand how the factor is used in the internal process. Especially, if you want to add your
own units to a converter. The factor is used to normalize a value.

Let's say you want to normalize 1 kilometer to meter, as meter is the base unit of the LengthConverter.
The 1 meter is 0.001 kilometer, so the factor of the unit kilometer is 0.001. This example is taken directly from
the LengthConverter constructor, where the Unit kilometer is already set up.

.. code-block:: php

   <?php
   new Unit('kilometer', 'km', '0.001');

All converters already provide a number of units ready to use as static variables.
Have a look at the corresponding converters documentation to see which units are already provided.

.. code-block:: php

   <?php
   $converter = new LengthConverter();
   $converter::$kilometer; // the unit "meter" already set up and ready to use


ConvertibleValue
================

A ConvertibleValue is the general data transfer object of unicorn.
Before you start converting or performing mathematical operations, you have to wrap your data in a ConvertibleValue.

It consists of two properties:

- value: the actual value
- unit: the unit in which the value is represented

If you want to represent 1000 meters as a ConvertibleValue, it will look like this:

.. code-block:: php

   <?php
   $converter = new LengthConverter();
   new ConvertibleValue('1000', $converter::$meter);
   new ConvertibleValue('1000.1234567890134567890', $converter::$meter); // decimals are seperated with a "." (dot).

The value is supposed to be a string representation, since it allows endless decimals, while float is limited to 14 decimals.
Since php loves type juggling and is able to cast almost anything to string, you might use int or float as well.

.. code-block:: php

   <?php
   $converter = new LengthConverter();
   new ConvertibleValue(1000.12345678901234, $converter::$meter);