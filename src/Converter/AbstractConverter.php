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
use Xynnn\Unicorn\Model\Convertible;
use Xynnn\Unicorn\Model\Unit;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @var array
     */
    protected $units;

    /**
     * @return string
     */
    abstract public function getName();

    /**$from
     * @param Convertible $convertible
     * @param Unit $to
     * @return void
     */
    abstract public function convert($convertible, $to);

    /**
     * @param array $units
     * @return void
     */
    protected function validate(array $units)
    {
        foreach ($units as $unit) {
            // make sure the unit is not just an instance of Unit, but the real same instance from the LengthConverter
            if (!in_array($unit, $this->units, true)) {
                throw new UnsupportedUnitException($unit);
            }
        }
    }

    /**
     * @param Convertible $convertible
     * @return void
     */
    abstract protected function normalize($convertible);

    /**
     * @param $convertible
     * @param Unit $to
     * @return void
     */
    abstract protected function convertTo($convertible, $to);

    /**
     * @param Convertible $c2
     * @param Convertible $c1
     * @return Convertible
     */
    abstract public function add($c1, $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    abstract public function substract($c1, $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    abstract public function multiply($c1, $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    abstract public function divide($c1, $c2);

}