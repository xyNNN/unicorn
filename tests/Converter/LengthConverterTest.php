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
use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

class LengthConverterTest extends PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertInstanceOf(LengthConverter::class, $converter);
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.length', $converter->getName());
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedUnitException
     * @expectedExceptionMessage The conversion of "noUnit" is not possible. Make sure to add it to the converters units array first.
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue('10000', $converter::$nanometer), new Unit('noUnit', 'nu', '1'));
    }

    public function testOwnTypePassed()
    {
        $converter = $this->getConverter();
        $converter->addUnit(new Unit('myUnit', 'mu', '5'));
        $result = $converter->convert(new ConvertibleValue('1', $converter::$meter), new Unit('myUnit', 'mu', '5'));

        $this->assertEquals('5', $result->getValue());
        $this->assertEquals(new Unit('myUnit', 'mu', '5'), $result->getUnit());
        $this->assertEquals('mu', $result->getUnit()->getAbbreviation());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue('0.000000001', $converter::$meter), $converter::$nanometer, '1', 'nanometer', 'nm'],
            [$converter, new ConvertibleValue('0.000001', $converter::$meter), $converter::$micrometer, '1', 'micrometer', 'µm'],
            [$converter, new ConvertibleValue('0.001', $converter::$meter), $converter::$millimeter, '1', 'millimeter', 'mm'],
            [$converter, new ConvertibleValue('0.01', $converter::$meter), $converter::$centimeter, '1', 'centimeter', 'cm'],
            [$converter, new ConvertibleValue('0.1', $converter::$meter), $converter::$decimeter, '1', 'decimeter', 'dm'],
            [$converter, new ConvertibleValue('1', $converter::$meter), $converter::$meter, '1', 'meter', 'm'],
            [$converter, new ConvertibleValue('1000', $converter::$meter), $converter::$kilometer, '1', 'kilometer', 'km'],
            [$converter, new ConvertibleValue('0.0254', $converter::$meter), $converter::$inch, '1', 'inch', 'in'],
            [$converter, new ConvertibleValue('0.3048', $converter::$meter), $converter::$feet, '1', 'feet', 'ft'],
            [$converter, new ConvertibleValue('0.9144', $converter::$meter), $converter::$yard, '1', 'yard', 'yd'],
            [$converter, new ConvertibleValue('1609.344', $converter::$meter), $converter::$mile, '1', 'mile', 'm'],
            [$converter, new ConvertibleValue(bcdiv('1', '1609344000000', $converter::MAX_DECIMALS), $converter::$mile), $converter::$nanometer, '1', 'nanometer', 'nm'],
            [$converter, new ConvertibleValue(bcdiv('1', '1609344000', $converter::MAX_DECIMALS), $converter::$mile), $converter::$micrometer, '1', 'micrometer', 'µm'],
            [$converter, new ConvertibleValue(bcdiv('1', '1609344', $converter::MAX_DECIMALS), $converter::$mile), $converter::$millimeter, '1', 'millimeter', 'mm'],
            [$converter, new ConvertibleValue(bcdiv('1', '160934.4', $converter::MAX_DECIMALS), $converter::$mile), $converter::$centimeter, '1', 'centimeter', 'cm'],
            [$converter, new ConvertibleValue(bcdiv('1', '16093.44', $converter::MAX_DECIMALS), $converter::$mile), $converter::$decimeter, '1', 'decimeter', 'dm'],
            [$converter, new ConvertibleValue(bcdiv('1', '1609.344', $converter::MAX_DECIMALS), $converter::$mile), $converter::$meter, '1', 'meter', 'm'],
            [$converter, new ConvertibleValue(bcdiv('1', '1.609344', $converter::MAX_DECIMALS), $converter::$mile), $converter::$kilometer, '1', 'kilometer', 'km'],
            [$converter, new ConvertibleValue(bcdiv('1', '63360', $converter::MAX_DECIMALS), $converter::$mile), $converter::$inch, '1', 'inch', 'in'],
            [$converter, new ConvertibleValue(bcdiv('1', '5280', $converter::MAX_DECIMALS), $converter::$mile), $converter::$feet, '1', 'feet', 'ft'],
            [$converter, new ConvertibleValue(bcdiv('1', '1760', $converter::MAX_DECIMALS), $converter::$mile), $converter::$yard, '1', 'yard', 'yd'],
            [$converter, new ConvertibleValue('1', $converter::$mile), $converter::$mile, '1', 'mile', 'm']
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
            $converter->convert(new ConvertibleValue('10000', $converter::$nanometer), $converter::$micrometer),
            $converter::$nanometer
        );

        $this->assertEquals('10000', $result->getValue());
        $this->assertEquals($converter::$nanometer, $result->getUnit());
        $this->assertEquals('nm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithAddition()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->add(
                new ConvertibleValue('1', $converter::$kilometer),
                new ConvertibleValue('1000', $converter::$meter)
            ),
            $converter::$meter
        );

        $this->assertEquals('2000', $result->getValue());
        $this->assertEquals($converter::$meter, $result->getUnit());
        $this->assertEquals('m', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedAddition()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->add(
                $converter->add(
                    new ConvertibleValue('10000', $converter::$nanometer),
                    new ConvertibleValue('10', $converter::$micrometer)
                ),
                new ConvertibleValue('30000', $converter::$nanometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals('50', $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithSubtraction()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->sub(
                new ConvertibleValue('20000', $converter::$nanometer),
                new ConvertibleValue('10', $converter::$micrometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals('10', $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testConversionWithNestedSubtraction()
    {
        $converter = $this->getConverter();
        $result = $converter->convert(
            $converter->sub(
                $converter->sub(
                    new ConvertibleValue('100000', $converter::$nanometer),
                    new ConvertibleValue('10', $converter::$micrometer)
                ),
                new ConvertibleValue('30000', $converter::$nanometer)
            ),
            $converter::$micrometer
        );

        $this->assertEquals('60', $result->getValue());
        $this->assertEquals($converter::$micrometer, $result->getUnit());
        $this->assertEquals('µm', $result->getUnit()->getAbbreviation());
    }

    public function testAdditionMustNotChangeUnit()
    {
        $converter = $this->getConverter();
        $result = $converter->add(
            new ConvertibleValue('2', $converter::$kilometer),
            new ConvertibleValue('1000', $converter::$meter)
        );

        $this->assertEquals('3', $result->getValue());
        $this->assertEquals($converter::$kilometer, $result->getUnit());
        $this->assertEquals('km', $result->getUnit()->getAbbreviation());
        $this->assertEquals('kilometer', $result->getUnit()->getName());
    }

    public function testSubtractionMustNotChangeUnit()
    {
        $converter = $this->getConverter();
        $result = $converter->sub(
            new ConvertibleValue('2', $converter::$kilometer),
            new ConvertibleValue('1000', $converter::$meter)
        );

        $this->assertEquals('1', $result->getValue());
        $this->assertEquals($converter::$kilometer, $result->getUnit());
        $this->assertEquals('km', $result->getUnit()->getAbbreviation());
        $this->assertEquals('kilometer', $result->getUnit()->getName());
    }

    /**
     * @return LengthConverter
     */
    private function getConverter() : LengthConverter
    {
        return new LengthConverter();
    }
}
