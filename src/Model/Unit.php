<?php
/**
 * Created by PhpStorm.
 * User: steffen
 * Date: 06.08.16
 * Time: 10:39
 */

namespace Xynnn\Unicorn\Model;


class Unit
{

    /**
     * @var string $name Name of the unit
     */
    private $name;

    /**
     * @var string $abbreviation Mathematical abbreviation of the unit
     */
    private $abbreviation;

    /**
     * @var float $factor Factor for normalization
     */
    private $factor;

    /**
     * Unit constructor.
     * @param string $name         Name of the unit
     * @param string $abbreviation Mathematical abbreviation of the unit
     * @param float $factor Factor for normalization
     */
    public function __construct($name, $abbreviation, $factor)
    {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->factor = $factor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * @return float
     */
    public function getFactor()
    {
        return $this->factor;
    }

    /**
     * @param float $factor
     */
    public function setFactor($factor)
    {
        $this->factor = $factor;
    }

}