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

class Convertible {

    /**
     * @var mixed $value The actual value
     */
    private $value;

    /**
     * @var Unit $unit The unit of the value
     */
    private $unit;

    /**
     * Value constructor.
     * @param mixed $value
     * @param Unit $unit
     */
    public function __construct($value, Unit $unit)
    {
        $this->value = $value;
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

}