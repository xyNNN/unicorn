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

use Xynnn\Unicorn\Converter\DataStorageConverter;
use Xynnn\Unicorn\Model\ConvertibleValue;

class DataStorageConverterTest extends AbstractConverterTest
{
    public function testIsInstantiable()
    {
        $converter = $this->getConverter();

        $this->assertInstanceOf(DataStorageConverter::class, $converter);
    }

    public function testGetName()
    {
        $converter = $this->getConverter();

        $this->assertEquals('unicorn.converter.datastorage', $converter->getName());
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $converter = $this->getConverter();

        return [
            [$converter, new ConvertibleValue('1', $converter::$gigabyte), $converter::$megabyte, '1000', $converter::$megabyte->getName(), $converter::$megabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibyte), $converter::$mebibyte, '1024', $converter::$mebibyte->getName(), $converter::$mebibyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$tebibyte), $converter::$gibibyte, '1024', $converter::$gibibyte->getName(), $converter::$gibibyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$tebibyte), $converter::$mebibyte, '1048576', $converter::$mebibyte->getName(), $converter::$mebibyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibyte), $converter::$megabyte, '1073.741824', $converter::$megabyte->getName(), $converter::$megabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibyte), $converter::$megabyte, '1073.741824', $converter::$megabyte->getName(), $converter::$megabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$pebibyte), $converter::$gigabyte, '1125899.906842624', $converter::$gigabyte->getName(), $converter::$gigabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gigabit), $converter::$megabit, '1000', $converter::$megabit->getName(), $converter::$megabit->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gigabit), $converter::$megabyte, '125', $converter::$megabyte->getName(), $converter::$megabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibit), $converter::$mebibit, '1024', $converter::$mebibit->getName(), $converter::$mebibit->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$gibibit), $converter::$megabyte, '134.217728', $converter::$megabyte->getName(), $converter::$megabyte->getAbbreviation()],
            [$converter, new ConvertibleValue('1', $converter::$megabyte), $converter::$mebibyte, '0.95367431640625', $converter::$mebibyte->getName(), $converter::$mebibyte->getAbbreviation()]
        ];
    }

    /**
     * @return DataStorageConverter
     */
    private function getConverter() : DataStorageConverter
    {
        return new DataStorageConverter();
    }
}
