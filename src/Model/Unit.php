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
     * @param float $factor        Factor for normalization
     */
    public function __construct(string $name, string $abbreviation, float $factor = null)
    {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->factor = $factor;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation)
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
    public function setFactor(float $factor)
    {
        $this->factor = $factor;
    }

}