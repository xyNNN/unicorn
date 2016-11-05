<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>, Steffen Brand <s.brand@steffenbrand.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Tests\Converter;

use Xynnn\Unicorn\Converter\TemperatureConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;

class TemperatureConverterTest extends AbstractConverterTest
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertInstanceOf(TemperatureConverter::class, $converter);
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.temperature', $converter->getName());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue('10', $converter::$celsius), $converter::$fahrenheit, '50', $converter::$fahrenheit->getName(), $converter::$fahrenheit->getAbbreviation()],
            [$converter, new ConvertibleValue('50', $converter::$fahrenheit), $converter::$celsius, '10', $converter::$celsius->getName(), $converter::$celsius->getAbbreviation()],
            [$converter, new ConvertibleValue('100', $converter::$celsius), $converter::$fahrenheit, '212', $converter::$fahrenheit->getName(), $converter::$fahrenheit->getAbbreviation()],
            [$converter, new ConvertibleValue('10', $converter::$celsius), $converter::$kelvin, '283.15', $converter::$kelvin->getName(), $converter::$kelvin->getAbbreviation()],
            [$converter, new ConvertibleValue('100', $converter::$celsius), $converter::$kelvin, '373.15', $converter::$kelvin->getName(), $converter::$kelvin->getAbbreviation()]
        ];
    }

    /**
     * @return TemperatureConverter
     */
    private function getConverter() : TemperatureConverter
    {
        return new TemperatureConverter();
    }
}
