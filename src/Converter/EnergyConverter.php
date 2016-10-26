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

class EnergyConverter extends AbstractMathematicalConverter
{

    /**
     * @var Unit $kWh Static instance for conversions
     */
    public static $kWh;

    /**
     * LengthConverter constructor.
     */
    public function __construct()
    {
        $this->units[] = self::$kWh = new Unit('kilowatt hour', 'kWh', '1');
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.storage';
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        parent::normalize($cv);
        $cv->setUnit(self::$kWh);
    }

}
