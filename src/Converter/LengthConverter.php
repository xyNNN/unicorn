<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Converter;

use Xynnn\Unicorn\Model\Unit;
use Xynnn\Unicorn\Model\ConvertibleValue;

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
     * @var array List of convertible units
     */
    protected $units = [];

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$nanometer = new Unit('nanometer', 'nm', 1000000000);
        $this->units[] = self::$micrometer = new Unit('micrometer', 'µm', 1000000);
        $this->units[] = self::$millimeter = new Unit('millimeter', 'mm', 1000);
        $this->units[] = self::$centimeter = new Unit('centimeter', 'cm', 100);
        $this->units[] = self::$decimeter = new Unit('decimeter', 'dm', 10);
        $this->units[] = self::$meter = new Unit('meter', 'm', 1);
        $this->units[] = self::$kilometer = new Unit('kilometer', 'km', 0.001);
        $this->units[] = self::$inch = new Unit('inch', 'in', 1 / 0.0254);
        $this->units[] = self::$feet = new Unit('feet', 'ft', 1 / 0.3048);
        $this->units[] = self::$yard = new Unit('yard', 'yd', 1 / 0.9144);
        $this->units[] = self::$mile = new Unit('mile', 'm', 1 / 1609.344);
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.length';
    }

    /**
     * @param ConvertibleValue $from ConvertibleValue to be converted
     * @param Unit $to               Unit to which is to be converted
     * @return ConvertibleValue      Converted result
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue
    {
        if (!$from instanceof ConvertibleValue || !is_numeric($from->getValue()) || !$from->getUnit() instanceof Unit) {
            throw new \InvalidArgumentException('The given ConvertibleValue is not valid for conversion.');
        }

        $this->validate([$from->getUnit(), $to]);
        $this->normalize($from);
        $this->convertTo($from, $to);

        return $from;
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        switch ($cv->getUnit()) {
            case self::$nanometer:
                $cv->setValue($cv->getValue() / self::$nanometer->getFactor());
                break;

            case self::$micrometer:
                $cv->setValue($cv->getValue() / self::$micrometer->getFactor());
                break;

            case self::$millimeter:
                $cv->setValue($cv->getValue() / self::$millimeter->getFactor());
                break;

            case self::$centimeter:
                $cv->setValue($cv->getValue() / self::$centimeter->getFactor());
                break;

            case self::$decimeter:
                $cv->setValue($cv->getValue() / self::$decimeter->getFactor());
                break;

            case self::$kilometer:
                $cv->setValue($cv->getValue() / self::$kilometer->getFactor());
                break;

            case self::$inch:
                $cv->setValue($cv->getValue() / self::$inch->getFactor());
                break;

            case self::$feet:
                $cv->setValue($cv->getValue() / self::$feet->getFactor());
                break;

            case self::$yard:
                $cv->setValue($cv->getValue() / self::$yard->getFactor());
                break;

            case self::$mile:
                $cv->setValue($cv->getValue() / self::$mile->getFactor());
                break;
        }

        $cv->setUnit(self::$meter);
    }

    /**
     * @param ConvertibleValue $from The convertible to be converted
     * @param Unit $to               Unit to which is to be converted
     */
    protected function convertTo(ConvertibleValue $from, Unit $to)
    {
        switch ($to) {
            case self::$nanometer:
                $from->setValue($from->getValue() * self::$nanometer->getFactor());
                $from->setUnit(self::$nanometer);
                break;

            case self::$micrometer:
                $from->setValue($from->getValue() * self::$micrometer->getFactor());
                $from->setUnit(self::$micrometer);
                break;

            case self::$millimeter:
                $from->setValue($from->getValue() * self::$millimeter->getFactor());
                $from->setUnit(self::$millimeter);
                break;

            case self::$centimeter:
                $from->setValue($from->getValue() * self::$centimeter->getFactor());
                $from->setUnit(self::$centimeter);
                break;

            case self::$decimeter:
                $from->setValue($from->getValue() * self::$decimeter->getFactor());
                $from->setUnit(self::$decimeter);
                break;

            case self::$kilometer:
                $from->setValue($from->getValue() * self::$kilometer->getFactor());
                $from->setUnit(self::$kilometer);
                break;

            case self::$inch:
                $from->setValue($from->getValue() * self::$inch->getFactor());
                $from->setUnit(self::$inch);
                break;

            case self::$feet:
                $from->setValue($from->getValue() * self::$feet->getFactor());
                $from->setUnit(self::$feet);
                break;

            case self::$yard:
                $from->setValue($from->getValue() * self::$yard->getFactor());
                $from->setUnit(self::$yard);
                break;

            case self::$mile:
                $from->setValue($from->getValue() * self::$mile->getFactor());
                $from->setUnit(self::$mile);
                break;
        }
    }

}
