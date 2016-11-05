<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>, Steffen Brand <s.brand@steffenbrand.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Converter;

use Xynnn\Unicorn\Model\Unit;

class LengthConverter extends AbstractMathematicalConverter
{
    /**
     * @var Unit $nanometer Static instance for conversions
     */
    public static $nanometer;

    /**
     * @var Unit $micrometer Static instance for conversions
     */
    public static $micrometer;

    /**
     * @var Unit $millimeter Static instance for conversions
     */
    public static $millimeter;

    /**
     * @var Unit $centimeter Static instance for conversions
     */
    public static $centimeter;

    /**
     * @var Unit $decimeter Static instance for conversions
     */
    public static $decimeter;

    /**
     * @var Unit $meter Static instance for conversions
     */
    public static $meter;

    /**
     * @var Unit $kilometer Static instance for conversions
     */
    public static $kilometer;

    /**
     * @var Unit $inch Static instance for conversions
     */
    public static $inch;

    /**
     * @var Unit $feet Static instance for conversions
     */
    public static $feet;

    /**
     * @var Unit $yard Static instance for conversions
     */
    public static $yard;

    /**
     * @var Unit $mile Static instance for conversions
     */
    public static $mile;

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
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
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.length';
    }

    public function getBaseUnit(): Unit
    {
        return self::$meter;
    }

    /**
     * @param array $units
     */
    public function setUnits(array $units)
    {
        $this->units = $units;
    }

    /**
     * @param Unit $unit
     */
    public function addUnit(Unit $unit)
    {
        $this->units[] = $unit;
    }

}
