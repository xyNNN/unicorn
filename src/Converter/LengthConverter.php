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

class LengthConverter extends AbstractConverter
{
    const UNIT_NANOMETER = 'nanometer';
    const UNIT_MICROMETER = 'micrometer';
    const UNIT_MILLIMETER = 'millimeter';
    const UNIT_CENTIMETER = 'centimeter';
    const UNIT_DECIMETER = 'decimeter';
    const UNIT_METER = 'meter';
    const UNIT_KILOMETER = 'kilometer';

    /**
     * @var array
     */
    protected $units = [
        self::UNIT_NANOMETER,
        self::UNIT_MICROMETER,
        self::UNIT_MILLIMETER,
        self::UNIT_CENTIMETER,
        self::UNIT_DECIMETER,
        self::UNIT_METER,
        self::UNIT_KILOMETER,
    ];

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'unicorn.converter.length';
    }

    /**
     * {@inheritdoc}
     */
    public function convert($value, $from, $to)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException(sprintf(
                'The value "%s" is not a numeric value',
                $value
            ));
        }

        $this->validate([$from, $to]);

        $value = $this->normalize($value, $from);
        return $this->convertTo($value, $to);
    }

    /**
     * {@inheritdoc}
     */
    protected function normalize($value, $from)
    {
        switch ($from) {
            case self::UNIT_NANOMETER:
                $value = $value / 1000000000;
                break;

            case self::UNIT_MICROMETER:
                $value = $value / 1000000;
                break;

            case self::UNIT_MILLIMETER:
                $value = $value / 1000;
                break;

            case self::UNIT_CENTIMETER:
                $value = $value / 100;
                break;

            case self::UNIT_DECIMETER:
                $value = $value / 10;
                break;

            case self::UNIT_KILOMETER:
                $value = $value * 1000;
                break;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function convertTo($value, $to)
    {
        switch ($to) {
            case self::UNIT_NANOMETER:
                $value = $value * 1000000000;
                break;

            case self::UNIT_MICROMETER:
                $value = floatval($value * 1000000);
                break;

            case self::UNIT_MILLIMETER:
                $value = $value * 1000;
                break;

            case self::UNIT_CENTIMETER:
                $value = $value * 100;
                break;

            case self::UNIT_DECIMETER:
                $value = $value * 10;
                break;

            case self::UNIT_KILOMETER:
                $value = $value * 0.001;
                break;
        }

        return $value;
    }
}
