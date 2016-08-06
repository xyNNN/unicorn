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
use Xynnn\Unicorn\Model\Convertible;

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
     * @param Convertible $convertible Value to be converted
     * @param Unit $to                 Unit to which is to be converted
     * @return Convertible             Converted result
     */
    public function convert(Convertible $convertible, Unit $to)
    {

        if (!$convertible instanceof Convertible || !is_numeric($convertible->getValue()) || !$convertible->getUnit() instanceof Unit) {
            throw new \InvalidArgumentException('The given Convertible is not valid for conversion.');
        }

        $this->validate([$convertible->getUnit(), $to]);
        $this->normalize($convertible);
        $this->convertTo($convertible, $to);

        return $convertible;
    }

    /**
     * @param Convertible $convertible The Convertible to be normalized
     * @return void
     */
    protected function normalize(Convertible $convertible)
    {
        switch ($convertible->getUnit()) {
            case self::$nanometer:
                $convertible->setValue($convertible->getValue() / self::$nanometer->getFactor());
                break;

            case self::$micrometer:
                $convertible->setValue($convertible->getValue() / self::$micrometer->getFactor());
                break;
        }

        $convertible->setUnit(self::$meter);
    }

    /**
     * @param Convertible $convertible The convertible to be converted
     * @param Unit $to                 Unit to which is to be converted
     * @return void
     */
    protected function convertTo(Convertible $convertible, Unit $to)
    {
        switch ($to) {
            case self::$nanometer:
                $convertible->setValue($convertible->getValue() * self::$nanometer->getFactor());
                $convertible->setUnit(self::$nanometer);
                break;

            case self::$micrometer:
                $convertible->setValue($convertible->getValue() * self::$micrometer->getFactor());
                $convertible->setUnit(self::$micrometer);
                break;
        }
    }

}
