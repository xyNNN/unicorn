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

use Xynnn\Unicorn\Model\Unit;
use Xynnn\Unicorn\Model\ConvertibleValue;

class DataTransferConverter extends AbstractMathematicalConverter
{

    /**
     * @var Unit $bit_per_second Static instance for conversions
     */
    public static $bit_per_second;

    /**
     * @var Unit $kilobit_per_second Static instance for conversions
     */
    public static $kilobit_per_second;

    /**
     * @var Unit $megabit_per_second Static instance for conversions
     */
    public static $megabit_per_second;

    /**
     * @var Unit $gigabit_per_second Static instance for conversions
     */
    public static $gigabit_per_second;

    /**
     * @var Unit $terabit_per_second Static instance for conversions
     */
    public static $terabit_per_second;

    /**
     * @var Unit $petabit_per_second Static instance for conversions
     */
    public static $petabit_per_second;

    /**
     * @var Unit $exabit_per_second Static instance for conversions
     */
    public static $exabit_per_second;

    /**
     * @var Unit $zettabit_per_second Static instance for conversions
     */
    public static $zettabit_per_second;

    /**
     * @var Unit $yottabit_per_second Static instance for conversions
     */
    public static $yottabit_per_second;

    /**
     * @var Unit $kibibit_per_second Static instance for conversions
     */
    public static $kibibit_per_second;

    /**
     * @var Unit $mebibit_per_second Static instance for conversions
     */
    public static $mebibit_per_second;

    /**
     * @var Unit $gibibit_per_second Static instance for conversions
     */
    public static $gibibit_per_second;

    /**
     * @var Unit $tebibit_per_second Static instance for conversions
     */
    public static $tebibit_per_second;

    /**
     * @var Unit $pebibit_per_second Static instance for conversions
     */
    public static $pebibit_per_second;

    /**
     * @var Unit $exibit_per_second Static instance for conversions
     */
    public static $exibit_per_second;

    /**
     * @var Unit $zebibit_per_second Static instance for conversions
     */
    public static $zebibit_per_second;

    /**
     * @var Unit $yobibit_per_second Static instance for conversions
     */
    public static $yobibit_per_second;

    /**
     * @var Unit $byte_per_second Static instance for conversions
     */
    public static $byte_per_second;

    /**
     * @var Unit $kilobyte_per_second Static instance for conversions
     */
    public static $kilobyte_per_second;

    /**
     * @var Unit $megabyte_per_second Static instance for conversions
     */
    public static $megabyte_per_second;

    /**
     * @var Unit $gigabyte_per_second Static instance for conversions
     */
    public static $gigabyte_per_second;

    /**
     * @var Unit $terabyte_per_second Static instance for conversions
     */
    public static $terabyte_per_second;

    /**
     * @var Unit $petabyte_per_second Static instance for conversions
     */
    public static $petabyte_per_second;

    /**
     * @var Unit $exabyte_per_second Static instance for conversions
     */
    public static $exabyte_per_second;

    /**
     * @var Unit $zettabyte_per_second Static instance for conversions
     */
    public static $zettabyte_per_second;

    /**
     * @var Unit $yottabyte_per_second Static instance for conversions
     */
    public static $yottabyte_per_second;

    /**
     * @var Unit $kibibyte_per_second Static instance for conversions
     */
    public static $kibibyte_per_second;

    /**
     * @var Unit $mebibyte_per_second Static instance for conversions
     */
    public static $mebibyte_per_second;

    /**
     * @var Unit $gibibyte_per_second Static instance for conversions
     */
    public static $gibibyte_per_second;

    /**
     * @var Unit $tebibyte_per_second Static instance for conversions
     */
    public static $tebibyte_per_second;

    /**
     * @var Unit $pebibyte_per_second Static instance for conversions
     */
    public static $pebibyte_per_second;

    /**
     * @var Unit $exibyte_per_second Static instance for conversions
     */
    public static $exibyte_per_second;

    /**
     * @var Unit $zebibyte_per_second Static instance for conversions
     */
    public static $zebibyte_per_second;

    /**
     * @var Unit $yobibyte_per_second Static instance for conversions
     */
    public static $yobibyte_per_second;

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$bit_per_second = new Unit('Bit', 'Bit per second', '1000000');
        $this->units[] = self::$kilobit_per_second = new Unit('Kilobit per second', 'Kbit/s', '1000');
        $this->units[] = self::$megabit_per_second = new Unit('Megabit per second', 'Mbit/s', '1');
        $this->units[] = self::$gigabit_per_second = new Unit('Gigabit per second', 'Gbit/s', '0.001');
        $this->units[] = self::$terabit_per_second = new Unit('Terabit per second', 'Tbit/s', '0.000001');
        $this->units[] = self::$petabit_per_second = new Unit('Petabit per second', 'Pbit/s', '0.000000001');
        $this->units[] = self::$exabit_per_second = new Unit('Exabit per second', 'Ebit/s', '0.000000000001');
        $this->units[] = self::$zettabit_per_second = new Unit('Zettabit per second', 'Zbit/s', '0.000000000000001');
        $this->units[] = self::$yottabit_per_second = new Unit('Yottabit per second', 'Ybit/s', '0.000000000000000001');

        $this->units[] = self::$kibibit_per_second = new Unit('Kibibit per second', 'Kibit/s', '976.5625');
        $this->units[] = self::$mebibit_per_second = new Unit('Mebibit per second', 'Mibit/s', bcdiv(self::$kibibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$gibibit_per_second = new Unit('Gibibit per second', 'Gibit/s', bcdiv(self::$mebibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$tebibit_per_second = new Unit('Tebibit per second', 'Tibit/s', bcdiv(self::$gibibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$pebibit_per_second = new Unit('Pebibit per second', 'Pibit/s', bcdiv(self::$tebibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$exibit_per_second = new Unit('Exibit per second', 'Eibit/s', bcdiv(self::$pebibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$zebibit_per_second = new Unit('Zebibit per second', 'Zibit/s', bcdiv(self::$exibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$yobibit_per_second = new Unit('Yobibit per second', 'Yibit/s', bcdiv(self::$zebibit_per_second->getFactor(), '1024', self::MAX_DECIMALS));

        $this->units[] = self::$byte_per_second = new Unit('Byte per second', 'B/s', '125000');
        $this->units[] = self::$kilobyte_per_second = new Unit('Kilobyte per second', 'KB/s', '125');
        $this->units[] = self::$megabyte_per_second = new Unit('Megabyte per second', 'MB/s', '0.125');
        $this->units[] = self::$gigabyte_per_second = new Unit('Gigabyte per second', 'GB/s', '0.000125');
        $this->units[] = self::$terabyte_per_second = new Unit('Terabyte per second', 'TB/s', '0.000000125');
        $this->units[] = self::$petabyte_per_second = new Unit('Petabyte per second', 'PB/s', '0.000000000125');
        $this->units[] = self::$exabyte_per_second = new Unit('Exabyte per second', 'EB/s', '0.000000000000125');
        $this->units[] = self::$zettabyte_per_second = new Unit('Zettabyte per second', 'ZB/s', '0.000000000000000125');
        $this->units[] = self::$yottabyte_per_second = new Unit('Yottabyte per second', 'YB/s', '0.000000000000000000125');

        $this->units[] = self::$kibibyte_per_second = new Unit('Kibibyte per second', 'KiB/s', bcmul('0.11920929', '1024', self::MAX_DECIMALS));
        $this->units[] = self::$mebibyte_per_second = new Unit('Mebibyte per second', 'MiB/s', '0.11920929');
        $this->units[] = self::$gibibyte_per_second = new Unit('Gibibyte per second', 'GiB/s', bcdiv(self::$mebibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$tebibyte_per_second = new Unit('Tebibyte per second', 'TiB/s', bcdiv(self::$gibibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$pebibyte_per_second = new Unit('Pebibyte per second', 'PiB/s', bcdiv(self::$tebibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$exibyte_per_second = new Unit('Exibyte per second', 'EiB/s', bcdiv(self::$pebibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$zebibyte_per_second = new Unit('Zebibyte per second', 'ZiB/s', bcdiv(self::$exibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$yobibyte_per_second = new Unit('Yobibyte per second', 'YiB/s', bcdiv(self::$zebibyte_per_second->getFactor(), '1024', self::MAX_DECIMALS));
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.datatransfer';
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        parent::normalize($cv);
        $cv->setUnit(self::$megabit_per_second);
    }

}
