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
use Xynnn\Unicorn\Converter\CurrencyConverter;
use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;

class SimplifiedExamplesTest extends PHPUnit_Framework_TestCase
{

    public function testSimpleLengthConversion()
    {
        // example for simple conversion of 100 centimeter to meter
        $converter = new LengthConverter();
        $result = $converter->convert(new ConvertibleValue('110', $converter::$centimeter), $converter::$meter);

        // $result is an instance of ConvertibleValue that you can also use for following conversions, mathematical operations, etc.
        $result->getValue(); // '1.10...' with 999 decimals
        $result->getFloatValue(); // 1.1
        $result->getUnit()->getAbbreviation(); // 'm'
        $result->getUnit()->getName(); // 'meter'
    }

    public function testSimpleCurrencyConversion()
    {
        // example for simple conversion of 10 EUR to USD
        $converter = new CurrencyConverter();
        $result = $converter->convert(new ConvertibleValue('10', $converter::$eur), $converter::$usd);

        // $result is an instance of ConvertibleValue that you can also use for following conversions, mathematical operations, etc.
        $result->getValue(); // something around '10.90...' with 999 decimals, depends on current exchange rate
        $result->getFloatValue(); // something around 10.9, depends on current exchange rate
        $result->getUnit()->getAbbreviation(); // '$'
        $result->getUnit()->getName(); // 'USD'
    }

    public function testSimpleLengthConversionWithTypeJuggling()
    {
        // example for simple conversion of 1.1 meter to centimeter
        // php is able and will try to automatically convert almost anything to the expected string, so you may also use float values
        $converter = new LengthConverter();
        $result = $converter->convert(new ConvertibleValue(1.1, $converter::$meter), $converter::$centimeter);

        // $result is an instance of ConvertibleValue that you can also use for following conversions, mathematical operations, etc.
        $result->getValue(); // '110.0...' with 999 decimals
        $result->getFloatValue(); // 110
        $result->getUnit()->getAbbreviation(); // 'cm'
        $result->getUnit()->getName(); // 'centimeter'
    }

    public function testSimpleAddition()
    {
        // example for adding two values, even with using different units
        // mathematical operations keep the unit of the first ConvertibleValue
        $converter = new LengthConverter();
        $result = $converter->add(
            new ConvertibleValue('1', $converter::$meter),
            new ConvertibleValue('200', $converter::$centimeter)
        );

        // $result is an instance of ConvertibleValue that you can also use for following conversions, mathematical operations, etc.
        $result->getValue(); // '2.0' with 999 decimals
        $result->getFloatValue(); // 2
        $result->getUnit()->getAbbreviation(); // 'm'
        $result->getUnit()->getName(); // 'meter'
    }

    public function testSimpleSubtraction()
    {
        // example for adding two values, even with using different units
        // mathematical operations keep the unit of the first ConvertibleValue
        $converter = new LengthConverter();
        $result = $converter->subtract(
            new ConvertibleValue('500', $converter::$centimeter),
            new ConvertibleValue('3', $converter::$meter)
        );

        // $result is an instance of ConvertibleValue that you can also use for following conversions, mathematical operations, etc.
        $result->getValue(); // '200.0' with 999 decimals
        $result->getFloatValue(); // 200
        $result->getUnit()->getAbbreviation(); // 'cm'
        $result->getUnit()->getName(); // 'centimeter'
    }

}
