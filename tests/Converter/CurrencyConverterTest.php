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
use SteffenBrand\CurrCurr\Client\EcbClientMock;
use SteffenBrand\CurrCurr\Model\Currency;
use Xynnn\Unicorn\Converter\CurrencyConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

class CurrencyConverterTest extends PHPUnit_Framework_TestCase
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
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedUnitException
     * @expectedExceptionMessage The conversion of "eur" is not possible. Make sure to add it to the converters units array first.
     */
    public function testWrongTypePassed()
    {
        $converter = $this->getConverter();
        $converter->convert(new ConvertibleValue('10', $converter::$eur), new Unit('eur', '€', '1'));
    }

    public function testOwnTypePassed()
    {
        $converter = $this->getConverter();
        $converter->addUnit(new Unit('myCurrency', 'mc', '5'));
        $result = $converter->convert(new ConvertibleValue('1', $converter::$eur), new Unit('myCurrency', 'mc', '5'));

        $this->assertEquals('5', $result->getValue());
        $this->assertEquals(new Unit('myCurrency', 'mc', '5'), $result->getUnit());
        $this->assertEquals('mc', $result->getUnit()->getAbbreviation());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();
        $converter->loadExchangeRates();

        return [
            [$converter, new ConvertibleValue('10', $converter::$eur), $converter::$usd, bcmul('10', $converter::$usd->getFactor(), $converter::MAX_DECIMALS), Currency::USD, $converter::$usd->getAbbreviation()],
            [$converter, new ConvertibleValue(bcmul('10', $converter::$usd->getFactor(), $converter::MAX_DECIMALS), $converter::$usd), $converter::$eur, '10', 'EUR', '€']
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

    public function testNoRoundingErrorDuringAdditionAndSubtractionAndConversion()
    {
        $converter = $this->getConverter();

        // sum up two different units
        $addition = $converter->add(
            new ConvertibleValue('10.12345678908745', $converter::$eur),
            new ConvertibleValue('100.77', $converter::$usd)
        );

        // convert them to jpy
        $jpy = $converter->convert($addition, $converter::$jpy);

        // subtract eur from jpy
        $subtraction = $converter->subtract(
            $jpy,
            new ConvertibleValue('10.12345678908745', $converter::$eur)
        );

        // convert back to usd
        $usd = $converter->convert($subtraction, $converter::$usd);

        // make sure no rounding error occured
        $this->assertEquals('100.77', $usd->getValue(), 'unexpected rounding error occured');
    }

    public function testGetFloatValTrimsTrailingZeros()
    {
        $converter = $this->getConverter();
        $cv = new ConvertibleValue('10.12345678900000', $converter::$eur);
        $this->assertEquals(10.123456789, $cv->getFloatValue());
    }

    /**
     * @return CurrencyConverter
     */
    private function getConverter() : CurrencyConverter
    {
        return new CurrencyConverter(new EcbClientMock(EcbClientMock::VALID_RESPONSE));
    }
}
