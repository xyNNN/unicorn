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

use SteffenBrand\CurrCurr\CurrCurr;
use SteffenBrand\CurrCurr\Model\Currency;
use Xynnn\Unicorn\Model\Unit;
use Xynnn\Unicorn\Model\ConvertibleValue;

class CurrencyConverter extends AbstractMathematicalConverter
{
    /**
     * @var Unit $eur Static instance for conversions
     */
    public static $eur;

    /**
     * @var Unit $usd Static instance for conversions
     */
    public static $usd;

    /**
     * @var array List of convertible units
     */
    protected $units = [];

    /**
     * CurrencyConverter constructor.
     */
    public function __construct()
    {
        $cc = new CurrCurr();
        $exchangeRates = $cc->getExchangeRates();

        $this->units[] = self::$eur = new Unit('EUR', '€', 1);
        $this->units[] = self::$usd = new Unit(Currency::USD, '$', $exchangeRates[Currency::USD]->getRate());
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.currency';
    }

    /**
     * @param ConvertibleValue $from ConvertibleValue to be converted
     * @param Unit $to               Unit to which is to be converted
     * @return ConvertibleValue      Converted result
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue
    {
        if (!$from instanceof ConvertibleValue || !is_numeric($from->getValue()) || !$from->getUnit() instanceof Unit) {
            throw new \InvalidArgumentException('The given ConvertibleValue is not valid for conversion.');
        }

        $this->validate([$from->getUnit(), $to]);
        $this->normalize($from);
        $this->convertTo($from, $to);

        return $from;
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        switch ($cv->getUnit()) {
            case self::$usd:
                $cv->setValue($cv->getValue() / self::$usd->getFactor());
                break;
        }

        $cv->setUnit(self::$eur);
    }

    /**
     * @param ConvertibleValue $from The convertible to be converted
     * @param Unit $to               Unit to which is to be converted
     */
    protected function convertTo(ConvertibleValue $from, Unit $to)
    {
        switch ($to) {
            case self::$usd:
                $from->setValue($from->getValue() * self::$usd->getFactor());
                $from->setUnit(self::$usd);
                break;
        }
    }

}
