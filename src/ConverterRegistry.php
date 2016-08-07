<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn;

use Xynnn\Unicorn\Exception\UnsupportedConverterException;

class ConverterRegistry
{
    /**
     * @var ConverterInterface[]
     */
    private $converters;

    /**
     * ConverterRegistry constructor.
     *
     * @param ConverterInterface[] $converters
     */
    public function __construct(array $converters)
    {
        $this->converters = [];
        foreach ($converters as $converter) {
            $this->add($converter);
        }
    }

    /**
     * @param string $name
     *
     * @return ConverterInterface
     */
    public function get(string $name): ConverterInterface
    {
        if (!isset($this->converters[$name])) {
            throw new UnsupportedConverterException($name);
        }

        return $this->converters[$name];
    }

    /**
     * @param ConverterInterface $converter
     */
    private function add(ConverterInterface $converter)
    {
        $this->converters[$converter->getName()] = $converter;
    }
}