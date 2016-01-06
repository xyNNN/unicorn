<?php

namespace Xynnn\Unicorn\Tests\Converter;

use Xynnn\Unicorn\Converter\LengthConverter;
use Xynnn\Unicorn\ConverterInterface;
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
    private function getRegistry()
    {
        $registry = new ConverterRegistry([new LengthConverter()]);

        return $registry;
    }
}
