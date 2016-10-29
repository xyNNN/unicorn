<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Xynnn\Unicorn\Tests\Converter;

use PHPUnit_Framework_TestCase;
use Xynnn\Unicorn\ConverterInterface;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

abstract class AbstractConverterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     * @param ConverterInterface $converter
     * @param ConvertibleValue $from
     * @param Unit $to
     * @param string $expectedValue
     * @param string $expectedUnitName
     * @param string $expectedUnitAbbreviation
     */
    public function testConversion(ConverterInterface $converter, ConvertibleValue $from, Unit $to, string $expectedValue, string $expectedUnitName, string $expectedUnitAbbreviation)
    {
        $result = $converter->convert($from, $to);

        $this->assertEquals($expectedValue, $result->getValue());
        $this->assertEquals($expectedUnitName, $result->getUnit()->getName());
        $this->assertEquals($expectedUnitAbbreviation, $result->getUnit()->getAbbreviation());
    }

}
