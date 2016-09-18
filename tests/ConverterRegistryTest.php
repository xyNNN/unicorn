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

use Xynnn\Unicorn\Converter\CurrencyConverter;
use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\ConverterRegistry;

class ConverterRegistryTest extends \PHPUnit_Framework_TestCase
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
        $registry = new ConverterRegistry([new LengthConverter(), new CurrencyConverter()]);

        return $registry;
    }
}
