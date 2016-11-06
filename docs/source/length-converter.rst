.. title:: LengthConverter

===============
LengthConverter
===============

Use the ``LengthConverter`` to convert between different length units, f.e. from meters to miles.

Base Unit
=========

- meter

Predefined Units
================

+-------------------+-------------------+-------------------+
| Name              | Abbreviation      | Factor            |
+===================+===================+===================+
| nanometer         | nm                | 1000000000        |
+-------------------+-------------------+-------------------+

        $this->units[] = self::$nanometer = new Unit('nanometer', 'nm', '1000000000');
        $this->units[] = self::$micrometer = new Unit('micrometer', 'µm', '1000000');
        $this->units[] = self::$millimeter = new Unit('millimeter', 'mm', '1000');
        $this->units[] = self::$centimeter = new Unit('centimeter', 'cm', '100');
        $this->units[] = self::$decimeter = new Unit('decimeter', 'dm', '10');
        $this->units[] = self::$meter = new Unit('meter', 'm', '1');
        $this->units[] = self::$kilometer = new Unit('kilometer', 'km', '0.001');
        $this->units[] = self::$inch = new Unit('inch', 'in', bcdiv('1', '0.0254', self::MAX_DECIMALS));
        $this->units[] = self::$feet = new Unit('feet', 'ft', bcdiv('1', '0.3048', self::MAX_DECIMALS));
        $this->units[] = self::$yard = new Unit('yard', 'yd', bcdiv('1', '0.9144', self::MAX_DECIMALS));
        $this->units[] = self::$mile = new Unit('mile', 'm', bcdiv('1', '1609.344', self::MAX_DECIMALS));