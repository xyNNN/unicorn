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

use Xynnn\Unicorn\Converter\DataTransferConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;

class DataTransferConverterTest extends AbstractConverterTest
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertInstanceOf(DataTransferConverter::class, $converter);
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.datatransfer', $converter->getName());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue('1', $converter::$megabit_per_second), $converter::$kilobit_per_second, '1000', $converter::$kilobit_per_second->getName(), $converter::$kilobit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$megabit_per_second), $converter::$megabit_per_second, '1', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gigabit_per_second), $converter::$kilobit_per_second, '1000000', $converter::$kilobit_per_second->getName(), $converter::$kilobit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$megabit_per_second), $converter::$mebibit_per_second, '0.95367431640625', $converter::$mebibit_per_second->getName(), $converter::$mebibit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$megabyte_per_second), $converter::$kilobyte_per_second, '1000', $converter::$kilobyte_per_second->getName(), $converter::$kilobyte_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$megabyte_per_second), $converter::$megabit_per_second, '8', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gigabyte_per_second), $converter::$megabit_per_second, '8000', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$mebibyte_per_second), $converter::$megabit_per_second, '8.38860796838904', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibyte_per_second), $converter::$megabit_per_second, '8589.93455963037780', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()],
            [$converter, new ConvertibleValue('1000000', $converter::$kibibyte_per_second), $converter::$megabit_per_second, '8191.99996912992267', $converter::$megabit_per_second->getName(), $converter::$megabit_per_second->getAbbreviation()]

        ];
    }

    /**
     * @return DataTransferConverter
     */
    private function getConverter() : DataTransferConverter
    {
        return new DataTransferConverter();
    }
}
