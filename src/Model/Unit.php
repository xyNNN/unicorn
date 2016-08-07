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
     * @param float $factor Factor for normalization
     */
    public function __construct(string $name, string $abbreviation, float $factor)
    {
        $this->name = $name;
        $this->abbreviation = $abbreviation;
        $this->factor = $factor;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAbbreviation() : string
    {
        return $this->abbreviation;
    }

    /**
     * @return float
     */
    public function getFactor() : float
    {
        return $this->factor;
    }
}