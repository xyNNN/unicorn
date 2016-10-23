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
     * @var string $factor Factor for normalization
     */
    private $factor;

    /**
     * Unit constructor.
     * @param string $name         Name of the unit
     * @param string $abbreviation Mathematical abbreviation of the unit
     * @param string $factor        Factor for normalization
     */
    public function __construct(string $name, string $abbreviation, string $factor = null)
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
     * @return string
     */
    public function getFactor(): string
    {
        return $this->factor;
    }

    /**
     * @param string $factor
     */
    public function setFactor(string $factor)
    {
        $this->factor = $factor;
    }

    /**
     * @return boolean
     */
    public function isFactorSet(): bool
    {
        return !empty($this->factor);
    }

}