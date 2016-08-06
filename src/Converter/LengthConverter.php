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

class LengthConverter extends AbstractConverter
{

    /**
     * @var Unit $nanometer Static nanometer instance for conversions
     */
    public static $nanometer;

    /**
     * @var Unit $micrometer Static nanometer instance for conversions
     */
    public static $micrometer;

    /**
     * @var Unit $meter Static nanometer instance for conversions
     */
    public static $meter;

    /**
     * @var array List of convertible units
     */
    protected $units = [];

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        array_push($this->units, self::$nanometer = new Unit('nanometer', 'nm', 1000000000));
        array_push($this->units, self::$micrometer = new Unit('micrometer', 'µm', 1000000));
        array_push($this->units, self::$meter = new Unit('meter', 'm', 1));
    }

    /**
     * @return string Name of the converter
     */
    public function getName()
    {
        return 'unicorn.converter.length';
    }

    /**
     * @param ConvertibleValue $from ConvertibleValue to be converted
     * @param Unit $to               Unit to which is to be converted
     * @return ConvertibleValue      Converted result
     */
    public function convert(ConvertibleValue $from, Unit $to)
    {

        if (!$from instanceof ConvertibleValue || !is_numeric($from->getValue()) || !$from->getUnit() instanceof Unit) {
            throw new \InvalidArgumentException('The given Convertible is not valid for conversion.');
        }

        $this->validate([$from->getUnit(), $to]);
        $this->normalize($from);
        $this->convertTo($from, $to);

        return $from;
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     * @return void
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
        }

        $cv->setUnit(self::$meter);
    }

    /**
     * @param ConvertibleValue $from The convertible to be converted
     * @param Unit $to               Unit to which is to be converted
     * @return void
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
        }
    }

}
