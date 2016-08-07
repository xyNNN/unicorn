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
     * @expectedExceptionMessage The given Convertible is not valid for conversion.
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

    public function testConversion()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(new ConvertibleValue(10000, $converter::$nanometer), $converter::$micrometer);

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
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
