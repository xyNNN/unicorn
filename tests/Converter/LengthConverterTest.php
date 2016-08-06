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

    public function testConvert()
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

    /**
     * @return LengthConverter
     */
    private function getConverter()
    {
        return new LengthConverter();
    }
}
