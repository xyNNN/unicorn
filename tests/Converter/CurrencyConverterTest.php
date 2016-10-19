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

use SteffenBrand\CurrCurr\Client\EcbClientMock;
use SteffenBrand\CurrCurr\Model\Currency;
use Xynnn\Unicorn\Converter\CurrencyConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

class CurrencyConverterTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertInstanceOf(CurrencyConverter::class, $converter);
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.currency', $converter->getName());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The given ConvertibleValue is not valid for conversion.
     */
    public function testWrongValuePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue('string', $converter::$eur), $converter::$usd);
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedUnitException
     * @expectedExceptionMessage The conversion of "eur" is not possible. Make sure to use the static units from the converter instance.
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue(10, $converter::$eur), new Unit('eur', '€', 1));
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue(10, $converter::$eur), $converter::$usd, (10*$converter::$usd->getFactor()), Currency::USD, '$'],
            [$converter, new ConvertibleValue((10*$converter::$usd->getFactor()), $converter::$usd), $converter::$eur, 10, 'EUR', '€']
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param CurrencyConverter $converter
     * @param ConvertibleValue $from
     * @param Unit $to
     * @param float $expectedValue
     * @param string $expectedUnitName
     * @param string $expectedUnitAbbreviation
     */
    public function testConversion(CurrencyConverter $converter, ConvertibleValue $from, Unit $to, float $expectedValue, string $expectedUnitName, string $expectedUnitAbbreviation)
    {
        $result = $converter->convert($from, $to);

        $this->assertEquals($expectedValue, $result->getValue());
        $this->assertEquals($expectedUnitName, $result->getUnit()->getName());
        $this->assertEquals($expectedUnitAbbreviation, $result->getUnit()->getAbbreviation());
    }

    /**
     * @return CurrencyConverter
     */
    private function getConverter() : CurrencyConverter
    {
        return new CurrencyConverter(new EcbClientMock('ValidResponse'));
    }
}
