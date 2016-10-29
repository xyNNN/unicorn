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
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$byte = new Unit('Byte', 'B', '0.0000010');
        $this->units[] = self::$kilobyte = new Unit('Kilobyte', 'KB', '0.001');
        $this->units[] = self::$megabyte = new Unit('Megabyte', 'MB', '1');
        $this->units[] = self::$gigabyte = new Unit('Gigabyte', 'GB', '1000');
        $this->units[] = self::$terabyte = new Unit('Terabyte', 'TB', '1000000');
        $this->units[] = self::$petabyte = new Unit('Petabyte', 'PB', '1000000000');
        $this->units[] = self::$exabyte = new Unit('Exabyte', 'EB', '1000000000000');
        $this->units[] = self::$zettabyte = new Unit('Zettabyte', 'ZB', '1000000000000000');
        $this->units[] = self::$yottabyte = new Unit('Yottabyte', 'YB', '1000000000000000000');

        $this->units[] = self::$kibibyte = new Unit('Kibibyte', 'KiB', '0.001024');
        $this->units[] = self::$mebibyte = new Unit('Mebibyte', 'MiB', bcmul(self::$kibibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$gibibyte = new Unit('Gibibyte', 'GiB', bcmul(self::$mebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$tebibyte = new Unit('Tebibyte', 'TiB', bcmul(self::$gibibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$pebibyte = new Unit('Pebibyte', 'PiB', bcmul(self::$tebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$exibyte = new Unit('Exibyte', 'EiB', bcmul(self::$pebibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$zebibyte = new Unit('Zebibyte', 'ZiB', bcmul(self::$exibyte->getFactor(), '1024', self::MAX_DECIMALS));
        $this->units[] = self::$yobibyte = new Unit('Yobibyte', 'YiB', bcmul(self::$zebibyte->getFactor(), '1024', self::MAX_DECIMALS));

        /**
        $this->units[] = self::$bit = new Unit('Bit', 'bit', '0.000000125');
        $this->units[] = self::$kilobit = new Unit('Kilobit', 'kbit', '0.000125');
        $this->units[] = self::$megabit = new Unit('Megabit', 'Mbit', '0.125');
        $this->units[] = self::$gigabit = new Unit('Gigabit', 'Gbit', '125000');
        $this->units[] = self::$terabit = new Unit('Terabit', 'Tbit', '125000000');
        $this->units[] = self::$petabit = new Unit('Petabit', 'Pbit', '125000000000');
        $this->units[] = self::$exabit = new Unit('Exabit', 'Ebit', '125000000000000');
        $this->units[] = self::$zettabit = new Unit('Zettabit', 'Zbit', '125000000000000000');
        $this->units[] = self::$yottabit = new Unit('Yottabit', 'Ybit', '125000000000000000000');
        **/
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.datastorage';
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        parent::normalize($cv);
        $cv->setUnit(self::$megabyte);
    }

}
