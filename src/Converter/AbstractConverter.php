<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Converter;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Xynnn\Unicorn\ConverterInterface;
use Xynnn\Unicorn\Exception\UnsupportedConverterException;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @var array
     */
    protected $units;

    /**
     * @return string
     */
    abstract public function getName();

    /**
     * @param mixed  $value
     * @param string $from
     * @param string $to
     *
     * @return mixed
     */
    abstract public function convert($value, $from, $to);

    /**
     * @param array $units
     */
    protected function validate(array $units)
    {
        foreach ($units as $unit) {
            if (!in_array($unit, $this->units)) {
                throw new UnsupportedConverterException($unit);
            }
        }
    }

    /**
     * @param mixed  $value
     * @param string $from
     *
     * @return mixed
     */
    abstract protected function normalize($value, $from);

    /**
     * @param mixed  $value
     * @param string $to
     *
     * @return mixed
     */
    abstract protected function convertTo($value, $to);
}