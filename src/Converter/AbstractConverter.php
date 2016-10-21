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

use Xynnn\Unicorn\ConverterInterface;
use Xynnn\Unicorn\Exception\UnsupportedUnitException;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

abstract class AbstractConverter implements ConverterInterface
{

    /**
     * @var array List of convertible units
     */
    protected $units = [];

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
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
     * @param array $units
     */
    protected function validate(array $units)
    {
        foreach ($units as $unit) {
            // make sure the unit is not just an instance of Unit, but the real same instance from the Converter
            if (!in_array($unit, $this->units)) {
                throw new UnsupportedUnitException($unit);
            }
        }
    }

    /**
     * @param ConvertibleValue $cv
     */
    protected function normalize(ConvertibleValue $cv)
    {
        $cv->setValue($cv->getValue() / $cv->getUnit()->getFactor());
    }

    /**
     * @param ConvertibleValue $from The convertible to be converted
     * @param Unit $to               Unit to which is to be converted
     */
    protected function convertTo(ConvertibleValue $from, Unit $to)
    {
        $from->setValue($from->getValue() * $to->getFactor());
        $from->setUnit($to);
    }

    /**
     * @return array
     */
    public function getUnits(): array
    {
        return $this->units;
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