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

    /**
     * Names of length units
     */
    const UNIT_NANOMETER = 'nanometer';
    const UNIT_MICROMETER = 'micrometer';
    const UNIT_MILLIMETER = 'millimeter';
    const UNIT_CENTIMETER = 'centimeter';
    const UNIT_DECIMETER = 'decimeter';
    const UNIT_METER = 'meter';
    const UNIT_KILOMETER = 'kilometer';
    const UNIT_INCH = 'inch';
    const UNIT_FEET = 'feet';
    const UNIT_YARD = 'yard';
    const UNIT_MILE = 'mile';

    /**
     * Factors for normalization to meter
     */
    const FACTOR_NANOMETER = 1000000000;
    const FACTOR_MICROMETER = 1000000;
    const FACTOR_MILLIMETER = 1000;
    const FACTOR_CENTIMETER = 100;
    const FACTOR_DECIMETER = 10;
    const FACTOR_METER = 1;
    const FACTOR_KILOMETER = 0.001;
    const FACTOR_INCH = 39.37007874;
    const FACTOR_FEET = 3.280839895;
    const FACTOR_YARD = 1.093613298;
    const FACTOR_MILE = 0.0006213711922;

    /**
     * @var array List of convertible units
     */
    protected $units = [
        self::UNIT_NANOMETER,
        self::UNIT_MICROMETER,
        self::UNIT_MILLIMETER,
        self::UNIT_CENTIMETER,
        self::UNIT_DECIMETER,
        self::UNIT_METER,
        self::UNIT_KILOMETER,
        self::UNIT_INCH,
        self::UNIT_FEET,
        self::UNIT_YARD,
        self::UNIT_MILE
    ];

    /**
     * @return string Name of the converter
     */
    public function getName()
    {
        return 'unicorn.converter.length';
    }

    /**
     * @param float $value Value to be converted
     * @param string $from Unit from which is to be converted
     * @param string $to   Unit to which is to be converted
     * @return float       Converted value
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
        $convertedValue = $this->convertTo($value, $to);

        return $convertedValue;
    }

    /**
     * @param float $value Value to be normalized to meters
     * @param string $from Unit to be normalized from
     * @return float       Normalized value
     */
    protected function normalize($value, $from)
    {
        switch ($from) {
            case self::UNIT_NANOMETER:
                $value = $value / self::FACTOR_NANOMETER;
                break;

            case self::UNIT_MICROMETER:
                $value = $value / self::FACTOR_MICROMETER;
                break;

            case self::UNIT_MILLIMETER:
                $value = $value / self::FACTOR_MILLIMETER;
                break;

            case self::UNIT_CENTIMETER:
                $value = $value / self::FACTOR_CENTIMETER;
                break;

            case self::UNIT_DECIMETER:
                $value = $value / self::FACTOR_METER;
                break;

            case self::UNIT_KILOMETER:
                $value = $value / self::FACTOR_KILOMETER;
                break;

            case self::UNIT_INCH:
                $value = $value / self::FACTOR_INCH;
                break;

            case self::UNIT_FEET:
                $value = $value / self::FACTOR_FEET;
                break;

            case self::UNIT_YARD:
                $value = $value / self::FACTOR_YARD;
                break;

            case self::UNIT_MILE:
                $value = $value / self::FACTOR_MILE;
                break;
        }

        return floatval($value);
    }

    /**
     * @param float $value Value to be converted
     * @param string $to   Unit to which is to be converted
     * @return float       Converted value
     */
    protected function convertTo($value, $to)
    {
        switch ($to) {
            case self::UNIT_NANOMETER:
                $value = $value * self::FACTOR_NANOMETER;
                break;

            case self::UNIT_MICROMETER:
                $value = $value * self::FACTOR_MICROMETER;
                break;

            case self::UNIT_MILLIMETER:
                $value = $value * self::FACTOR_MILLIMETER;
                break;

            case self::UNIT_CENTIMETER:
                $value = $value * self::FACTOR_CENTIMETER;
                break;

            case self::UNIT_DECIMETER:
                $value = $value * self::FACTOR_DECIMETER;
                break;

            case self::UNIT_KILOMETER:
                $value = $value * self::FACTOR_KILOMETER;
                break;

            case self::UNIT_INCH:
                $value = $value * self::FACTOR_INCH;
                break;

            case self::UNIT_FEET:
                $value = $value * self::FACTOR_FEET;
                break;

            case self::UNIT_YARD:
                $value = $value * self::FACTOR_YARD;
                break;

            case self::UNIT_MILE:
                $value = $value * self::FACTOR_MILE;
                break;
        }

        return floatval($value);
    }
}
