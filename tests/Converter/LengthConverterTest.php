<?php

namespace Xynnn\Unicorn\Tests\Converter;

use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\Model\Convertible;
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
        $converter->convert(new Convertible('string', $converter::$nanometer), $converter::$micrometer);
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedUnitException
     * @expectedExceptionMessage The conversion of "micrometer" is not possible. Make sure to use the static units from the converter instance.
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new Convertible(10000, $converter::$nanometer), new Unit('micrometer', 'µm', 1000000));
    }

    public function testConversion()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(new Convertible(10000, $converter::$nanometer), $converter::$micrometer);

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testNestedConversion()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->convert(new Convertible(10000, $converter::$nanometer), $converter::$micrometer),
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
                new Convertible(10000, $converter::$nanometer),
                new Convertible(10, $converter::$micrometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals(20, $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedAddition()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->add(
                $converter->add(
                    new Convertible(10000, $converter::$nanometer),
                    new Convertible(10, $converter::$micrometer)
                ),
                new Convertible(30000, $converter::$nanometer)
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
                new Convertible(20000, $converter::$nanometer),
                new Convertible(10, $converter::$micrometer)
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
                    new Convertible(100000, $converter::$nanometer),
                    new Convertible(10, $converter::$micrometer)
                ),
                new Convertible(30000, $converter::$nanometer)
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
                new Convertible(1, $converter::$meter),
                new Convertible(2, $converter::$meter)
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
                    new Convertible(50, $converter::$meter),
                    new Convertible(10, $converter::$meter)
                ),
                new Convertible(10, $converter::$meter)
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
                new Convertible(50, $converter::$meter),
                new Convertible(5, $converter::$meter)
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
                    new Convertible(1000, $converter::$meter),
                    new Convertible(10, $converter::$meter)
                ),
                new Convertible(10, $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals(10, $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    /**
     * @return LengthConverter
     */
    private function getConverter()
    {
        return new LengthConverter();
    }
}
