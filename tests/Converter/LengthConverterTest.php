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

use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

class LengthConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertEquals(LengthConverter::class, get_class($converter));
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.length', $converter->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The given ConvertibleValue is not valid for conversion.
     */
    public function testWrongValuePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue('string', $converter::$nanometer), $converter::$micrometer);
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedUnitException
     * @expectedExceptionMessage The conversion of "micrometer" is not possible. Make sure to use the static units from the converter instance.
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue(10000, $converter::$nanometer), new Unit('micrometer', 'µm', 1000000));
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue(0.000000001, $converter::$meter), $converter::$nanometer, 1, 'nanometer', 'nm'],
            [$converter, new ConvertibleValue(0.000001, $converter::$meter), $converter::$micrometer, 1, 'micrometer', 'µm'],
            [$converter, new ConvertibleValue(0.001, $converter::$meter), $converter::$millimeter, 1, 'millimeter', 'mm'],
            [$converter, new ConvertibleValue(0.01, $converter::$meter), $converter::$centimeter, 1, 'centimeter', 'cm'],
            [$converter, new ConvertibleValue(0.1, $converter::$meter), $converter::$decimeter, 1, 'decimeter', 'dm'],
            [$converter, new ConvertibleValue(1, $converter::$meter), $converter::$meter, 1, 'meter', 'm'],
            [$converter, new ConvertibleValue(1000, $converter::$meter), $converter::$kilometer, 1, 'kilometer', 'km'],
            [$converter, new ConvertibleValue(0.0254, $converter::$meter), $converter::$inch, 1, 'inch', 'in'],
            [$converter, new ConvertibleValue(0.3048, $converter::$meter), $converter::$feet, 1, 'feet', 'ft'],
            [$converter, new ConvertibleValue(0.9144, $converter::$meter), $converter::$yard, 1, 'yard', 'yd'],
            [$converter, new ConvertibleValue(1609.344, $converter::$meter), $converter::$mile, 1, 'mile', 'm'],
            [$converter, new ConvertibleValue(1 / 1609344000000, $converter::$mile), $converter::$nanometer, 1, 'nanometer', 'nm'],
            [$converter, new ConvertibleValue(1 / 1609344000, $converter::$mile), $converter::$micrometer, 1, 'micrometer', 'µm'],
            [$converter, new ConvertibleValue(1 / 1609344, $converter::$mile), $converter::$millimeter, 1, 'millimeter', 'mm'],
            [$converter, new ConvertibleValue(1 / 160934.4, $converter::$mile), $converter::$centimeter, 1, 'centimeter', 'cm'],
            [$converter, new ConvertibleValue(1 / 16093.44, $converter::$mile), $converter::$decimeter, 1, 'decimeter', 'dm'],
            [$converter, new ConvertibleValue(1 / 1609.344, $converter::$mile), $converter::$meter, 1, 'meter', 'm'],
            [$converter, new ConvertibleValue(1 / 1.609344, $converter::$mile), $converter::$kilometer, 1, 'kilometer', 'km'],
            [$converter, new ConvertibleValue(1 / 63360, $converter::$mile), $converter::$inch, 1, 'inch', 'in'],
            [$converter, new ConvertibleValue(1 / 5280, $converter::$mile), $converter::$feet, 1, 'feet', 'ft'],
            [$converter, new ConvertibleValue(1 / 1760, $converter::$mile), $converter::$yard, 1, 'yard', 'yd'],
            [$converter, new ConvertibleValue(1, $converter::$mile), $converter::$mile, 1, 'mile', 'm']
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param LengthConverter $converter
     * @param ConvertibleValue $from
     * @param Unit $to
     * @param float $expectedValue
     * @param string $expectedUnitName
     * @param string $expectedUnitAbbreviation
     */
    public function testConversion(LengthConverter $converter, ConvertibleValue $from, Unit $to, float $expectedValue, string $expectedUnitName, string $expectedUnitAbbreviation)
    {
        $result = $converter->convert($from, $to);

        $this->assertEquals($expectedValue, $result->getValue());
        $this->assertEquals($expectedUnitName, $result->getUnit()->getName());
        $this->assertEquals($expectedUnitAbbreviation, $result->getUnit()->getAbbreviation());
    }

    public function testNestedConversion()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->convert(new ConvertibleValue(10000, $converter::$nanometer), $converter::$micrometer),
            $converter::$nanometer
        );

        $this->assertEquals(10000, $result->getValue());
        $this->assertEquals($converter::$nanometer, $result->getUnit());
        $this->assertEquals('nm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithAddition()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->add(
                new ConvertibleValue(1, $converter::$kilometer),
                new ConvertibleValue(10000, $converter::$centimeter)
            ),
            $converter::$meter
        );

        $this->assertEquals(1100, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedAddition()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->add(
                $converter->add(
                    new ConvertibleValue(10000, $converter::$nanometer),
                    new ConvertibleValue(10, $converter::$micrometer)
                ),
                new ConvertibleValue(30000, $converter::$nanometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals(50, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithSubstraction()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->substract(
                new ConvertibleValue(20000, $converter::$nanometer),
                new ConvertibleValue(10, $converter::$micrometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedSubstraction()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->substract(
                $converter->substract(
                    new ConvertibleValue(100000, $converter::$nanometer),
                    new ConvertibleValue(10, $converter::$micrometer)
                ),
                new ConvertibleValue(30000, $converter::$nanometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals(60, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithMultiplication()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->multiply(
                new ConvertibleValue(1, $converter::$meter),
                new ConvertibleValue(2, $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals(2, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedMultiplication()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->multiply(
                $converter->multiply(
                    new ConvertibleValue(50, $converter::$meter),
                    new ConvertibleValue(10, $converter::$meter)
                ),
                new ConvertibleValue(10, $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals(5000, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithDivision()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->divide(
                new ConvertibleValue(50, $converter::$meter),
                new ConvertibleValue(5, $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedDivision()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->divide(
                $converter->divide(
                    new ConvertibleValue(1000, $converter::$meter),
                    new ConvertibleValue(10, $converter::$meter)
                ),
                new ConvertibleValue(10, $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithExponentiation()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->exponentiate(
                new ConvertibleValue(2, $converter::$meter),
                3
            ),
            $converter::$meter
        );

        $this->assertEquals(8, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedExponentiation()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->exponentiate(
                $converter->exponentiate(
                    new ConvertibleValue(2, $converter::$meter),
                    3
                ),
                2
            ),
            $converter::$meter
        );

        $this->assertEquals(64, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithRoot()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->root(
                new ConvertibleValue(8, $converter::$meter),
                3
            ),
            $converter::$meter
        );

        $this->assertEquals(2, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedRoot()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->root(
                $converter->root(
                    new ConvertibleValue(64, $converter::$meter),
                    2
                ),
                3
            ),
            $converter::$meter
        );

        $this->assertEquals(2, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    /**
     * @return LengthConverter
     */
    private function getConverter() : LengthConverter
    {
        return new LengthConverter();
    }
}
