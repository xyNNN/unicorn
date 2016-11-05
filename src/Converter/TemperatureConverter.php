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
use Xynnn\Unicorn\Model\ConvertibleValue;

class TemperatureConverter extends AbstractMathematicalConverter
{

    /**
     * @var Unit $celsius Static instance for conversions
     */
    public static $celsius;

    /**
     * @var Unit $fahrenheit Static instance for conversions
     */
    public static $fahrenheit;

    /**
     * @var Unit $kelvin Static instance for conversions
     */
    public static $kelvin;

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$celsius = new Unit('Celsius ', '°C');
        $this->units[] = self::$fahrenheit = new Unit('Fahrenheit ', '°F');
        $this->units[] = self::$kelvin = new Unit('Kelvin ', 'K');
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.temperature';
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

            default:
                $value = $from->getValue();

        }

        $from->setValue($value);
        $from->setUnit($to);
    }

    public function getBaseUnit(): Unit
    {
        return self::$celsius;
    }

}
