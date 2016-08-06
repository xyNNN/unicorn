<?php

namespace Xynnn\Unicorn\Tests\Converter;

use Xynnn\Unicorn\Converter\LengthConverter;

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
     * @expectedExceptionMessage The value "string" is not a numeric value
     */
    public function testWrongValuePassed()
    {
        $converter = $this->getConverter();
        $converter->convert('string', LengthConverter::UNIT_KILOMETER, LengthConverter::UNIT_METER);
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedConverterException
     * @expectedExceptionMessage The given converter "undefined_type" is not known
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(100, LengthConverter::UNIT_KILOMETER, 'undefined_type');
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [100, LengthConverter::UNIT_NANOMETER, 100, LengthConverter::UNIT_NANOMETER],
            [10000, LengthConverter::UNIT_NANOMETER, 10, LengthConverter::UNIT_MICROMETER],
            [100, LengthConverter::UNIT_NANOMETER, 0.0001, LengthConverter::UNIT_MILLIMETER],
            [100, LengthConverter::UNIT_NANOMETER, 1.0E-5, LengthConverter::UNIT_CENTIMETER],
            [100, LengthConverter::UNIT_NANOMETER, 1.0E-6, LengthConverter::UNIT_DECIMETER],
            [1000, LengthConverter::UNIT_METER, 0.62137119219999992, LengthConverter::UNIT_MILE],
            [1000, LengthConverter::UNIT_METER, 1093.613298, LengthConverter::UNIT_YARD],
            [10, LengthConverter::UNIT_METER, 10.93613298, LengthConverter::UNIT_YARD],
            [100, LengthConverter::UNIT_METER, 328.08398950000003, LengthConverter::UNIT_FEET],
            [1609.344, LengthConverter::UNIT_METER, 1, LengthConverter::UNIT_MILE],
            [1, LengthConverter::UNIT_METER, 1, LengthConverter::UNIT_METER],
            [1, LengthConverter::UNIT_INCH, 2.54, LengthConverter::UNIT_CENTIMETER],
            [1, LengthConverter::UNIT_DECIMETER, 10, LengthConverter::UNIT_CENTIMETER]
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param float  $value
     * @param string $from
     * @param float  $expected
     * @param string $to
     */
    public function testConvert($value, $from, $expected, $to)
    {
        $converter = $this->getConverter();
        $result = $converter->convert($value, $from, $to);

        $this->assertEquals($expected, $result);
    }

    public function testMetricToImperialTwoWayConversion()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->convert(1000, LengthConverter::UNIT_METER, LengthConverter::UNIT_FEET),
            LengthConverter::UNIT_FEET,
            LengthConverter::UNIT_KILOMETER
        );

        $this->assertEquals(1, $result);
    }

    /**
     * @return LengthConverter
     */
    private function getConverter()
    {
        return new LengthConverter();
    }
}
