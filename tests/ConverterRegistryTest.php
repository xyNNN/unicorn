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
use Xynnn\Unicorn\Converter\DataStorageConverter;
use Xynnn\Unicorn\Converter\DataTransferConverter;
use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\Converter\TemperatureConverter;
use Xynnn\Unicorn\ConverterRegistry;

class ConverterRegistryTest extends PHPUnit_Framework_TestCase
{
    public function testIsInstantiable()
    {
        $registry = $this->getRegistry();

        $this->assertEquals(ConverterRegistry::class, get_class($registry));
    }

    public function testGetConverter()
    {
        $registry = $this->getRegistry();

        $this->assertEquals(LengthConverter::class, get_class($registry->get('unicorn.converter.length')));
        $this->assertEquals(CurrencyConverter::class, get_class($registry->get('unicorn.converter.currency')));
        $this->assertEquals(TemperatureConverter::class, get_class($registry->get('unicorn.converter.temperature')));
        $this->assertEquals(DataStorageConverter::class, get_class($registry->get('unicorn.converter.datastorage')));
        $this->assertEquals(DataTransferConverter::class, get_class($registry->get('unicorn.converter.datatransfer')));
    }

    /**
     * @expectedException \Xynnn\Unicorn\Exception\UnsupportedConverterException
     * @expectedExceptionMessage The given converter "unicorn.converter.unsupported" is not known
     */
    public function testGetUnsupportedConverter()
    {
        $registry = $this->getRegistry();

        $registry->get('unicorn.converter.unsupported');
    }

    /**
     * @return ConverterRegistry
     */
    private function getRegistry() : ConverterRegistry
    {
        $registry = new ConverterRegistry([
            new LengthConverter(),
            new CurrencyConverter(),
            new TemperatureConverter(),
            new DataStorageConverter(),
            new DataTransferConverter()
        ]);

        return $registry;
    }
}
