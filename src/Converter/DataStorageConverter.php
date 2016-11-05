<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>, Steffen Brand <s.brand@steffenbrand.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Converter;

use Xynnn\Unicorn\Model\Unit;

class DataStorageConverter extends AbstractMathematicalConverter
{

    /**
     * @var Unit $byte Static instance for conversions
     */
    public static $byte;

    /**
     * @var Unit $kilobyte Static instance for conversions
     */
    public static $kilobyte;

    /**
     * @var Unit $megabyte Static instance for conversions
     */
    public static $megabyte;

    /**
     * @var Unit $gigabyte Static instance for conversions
     */
    public static $gigabyte;

    /**
     * @var Unit $terabyte Static instance for conversions
     */
    public static $terabyte;

    /**
     * @var Unit $petabyte Static instance for conversions
     */
    public static $petabyte;

    /**
     * @var Unit $exabyte Static instance for conversions
     */
    public static $exabyte;

    /**
     * @var Unit $zettabyte Static instance for conversions
     */
    public static $zettabyte;

    /**
     * @var Unit $yottabyte Static instance for conversions
     */
    public static $yottabyte;

    /**
     * @var Unit $kibibyte Static instance for conversions
     */
    public static $kibibyte;

    /**
     * @var Unit $mebibyte Static instance for conversions
     */
    public static $mebibyte;

    /**
     * @var Unit $gibibyte Static instance for conversions
     */
    public static $gibibyte;

    /**
     * @var Unit $tebibyte Static instance for conversions
     */
    public static $tebibyte;

    /**
     * @var Unit $pebibyte Static instance for conversions
     */
    public static $pebibyte;

    /**
     * @var Unit $exibyte Static instance for conversions
     */
    public static $exibyte;

    /**
     * @var Unit $zebibyte Static instance for conversions
     */
    public static $zebibyte;

    /**
     * @var Unit $yobibyte Static instance for conversions
     */
    public static $yobibyte;

    /**
     * @var Unit $bit Static instance for conversions
     */
    public static $bit;

    /**
     * @var Unit $kilobit Static instance for conversions
     */
    public static $kilobit;

    /**
     * @var Unit $megabit Static instance for conversions
     */
    public static $megabit;

    /**
     * @var Unit $gigabit Static instance for conversions
     */
    public static $gigabit;

    /**
     * @var Unit $terabit Static instance for conversions
     */
    public static $terabit;

    /**
     * @var Unit $petabit Static instance for conversions
     */
    public static $petabit;

    /**
     * @var Unit $exabit Static instance for conversions
     */
    public static $exabit;

    /**
     * @var Unit $zettabit Static instance for conversions
     */
    public static $zettabit;

    /**
     * @var Unit $yottabit Static instance for conversions
     */
    public static $yottabit;

    /**
     * @var Unit $kibibit Static instance for conversions
     */
    public static $kibibit;

    /**
     * @var Unit $mebibit Static instance for conversions
     */
    public static $mebibit;

    /**
     * @var Unit $gibibit Static instance for conversions
     */
    public static $gibibit;

    /**
     * @var Unit $tebibit Static instance for conversions
     */
    public static $tebibit;

    /**
     * @var Unit $pebibit Static instance for conversions
     */
    public static $pebibit;

    /**
     * @var Unit $exibit Static instance for conversions
     */
    public static $exibit;

    /**
     * @var Unit $zebibit Static instance for conversions
     */
    public static $zebibit;

    /**
     * @var Unit $yobibit Static instance for conversions
     */
    public static $yobibit;

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$byte = new Unit('Byte', 'B', '1000000');
        $this->units[] = self::$kilobyte = new Unit('Kilobyte', 'KB', '1000');
        $this->units[] = self::$megabyte = new Unit('Megabyte', 'MB', '1');
        $this->units[] = self::$gigabyte = new Unit('Gigabyte', 'GB', '0.001');
        $this->units[] = self::$terabyte = new Unit('Terabyte', 'TB', '0.000001');
        $this->units[] = self::$petabyte = new Unit('Petabyte', 'PB', '0.000000001');
        $this->units[] = self::$exabyte = new Unit('Exabyte', 'EB', '0.000000000001');
        $this->units[] = self::$zettabyte = new Unit('Zettabyte', 'ZB', '0.000000000000001');
        $this->units[] = self::$yottabyte = new Unit('Yottabyte', 'YB', '0.000000000000000001');

        $this->units[] = self::$kibibyte = new Unit('Kibibyte', 'KiB', '976.5625');
        $this->units[] = self::$mebibyte = new Unit('Mebibyte', 'MiB', bcdiv(self::$kibibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$gibibyte = new Unit('Gibibyte', 'GiB', bcdiv(self::$mebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$tebibyte = new Unit('Tebibyte', 'TiB', bcdiv(self::$gibibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$pebibyte = new Unit('Pebibyte', 'PiB', bcdiv(self::$tebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$exibyte = new Unit('Exibyte', 'EiB', bcdiv(self::$pebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$zebibyte = new Unit('Zebibyte', 'ZiB', bcdiv(self::$exibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$yobibyte = new Unit('Yobibyte', 'YiB', bcdiv(self::$zebibyte->getFactor(), '1024', self::MAX_DECIMALS));

        $this->units[] = self::$bit = new Unit('Bit', 'bit', '8000000');
        $this->units[] = self::$kilobit = new Unit('Kilobit', 'Kbit', '8000');
        $this->units[] = self::$megabit = new Unit('Megabit', 'Mbit', '8');
        $this->units[] = self::$gigabit = new Unit('Gigabit', 'Gbit', '0.008');
        $this->units[] = self::$terabit = new Unit('Terabit', 'Tbit', '0.000008');
        $this->units[] = self::$petabit = new Unit('Petabit', 'Pbit', '0.000000008');
        $this->units[] = self::$exabit = new Unit('Exabit', 'Ebit', '0.000000000008');
        $this->units[] = self::$zettabit = new Unit('Zettabit', 'Zbit', '0.000000000000008');
        $this->units[] = self::$yottabit = new Unit('Yottabit', 'Ybit', '0.000000000000000008');

        $this->units[] = self::$kibibit = new Unit('Kibibit', 'Kibit', '7812.5');
        $this->units[] = self::$mebibit = new Unit('Mebibit', 'Mibit', bcdiv(self::$kibibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$gibibit = new Unit('Gibibit', 'Gibit', bcdiv(self::$mebibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$tebibit = new Unit('Tebibit', 'Tibit', bcdiv(self::$gibibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$pebibit = new Unit('Pebibit', 'Pibit', bcdiv(self::$tebibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$exibit = new Unit('Exibit', 'Eibit', bcdiv(self::$pebibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$zebibit = new Unit('Zebibit', 'Zibit', bcdiv(self::$exibit->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$yobibit = new Unit('Yobibit', 'Yibit', bcdiv(self::$zebibit->getFactor(), '1024', self::MAX_DECIMALS));
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.datastorage';
    }

    public function getBaseUnit(): Unit
    {
        return self::$megabyte;
    }

    /**
     * @param array $units
     */
    public function setUnits(array $units)
    {
        $this->units = $units;
    }

    /**
     * @param Unit $unit
     */
    public function addUnit(Unit $unit)
    {
        $this->units[] = $unit;
    }

}
