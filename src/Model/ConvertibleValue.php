<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Model;

class ConvertibleValue
{
    /**
     * @var string $value The actual value
     */
    private $value;

    /**
     * @var Unit $unit The unit of the value
     */
    private $unit;

    /**
     * Value constructor.
     * @param string $value
     * @param Unit $unit
     */
    public function __construct(string $value, Unit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     */
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function getFloatValue(): float
    {
        return floatval($this->value);
    }

}