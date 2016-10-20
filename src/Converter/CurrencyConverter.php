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

use SteffenBrand\CurrCurr\Client\EcbClientInterface;
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
     * @var Unit $jpy Static instance for conversions
     */
    public static $jpy;

    /**
     * @var Unit $bgn Static instance for conversions
     */
    public static $bgn;

    /**
     * @var Unit $czk Static instance for conversions
     */
    public static $czk;

    /**
     * @var Unit $dkk Static instance for conversions
     */
    public static $dkk;

    /**
     * @var Unit $gbp Static instance for conversions
     */
    public static $gbp;

    /**
     * @var Unit $huf Static instance for conversions
     */
    public static $huf;

    /**
     * @var Unit $pln Static instance for conversions
     */
    public static $pln;

    /**
     * @var Unit $ron Static instance for conversions
     */
    public static $ron;

    /**
     * @var Unit $sek Static instance for conversions
     */
    public static $sek;

    /**
     * @var Unit $chf Static instance for conversions
     */
    public static $chf;

    /**
     * @var Unit $nok Static instance for conversions
     */
    public static $nok;

    /**
     * @var Unit $hrk Static instance for conversions
     */
    public static $hrk;

    /**
     * @var Unit $rub Static instance for conversions
     */
    public static $rub;

    /**
     * @var Unit $try Static instance for conversions
     */
    public static $try;

    /**
     * @var Unit $aud Static instance for conversions
     */
    public static $aud;

    /**
     * @var Unit $brl Static instance for conversions
     */
    public static $brl;

    /**
     * @var Unit $cad Static instance for conversions
     */
    public static $cad;

    /**
     * @var Unit $cny Static instance for conversions
     */
    public static $cny;

    /**
     * @var Unit $hkd Static instance for conversions
     */
    public static $hkd;

    /**
     * @var Unit $idr Static instance for conversions
     */
    public static $idr;

    /**
     * @var Unit $ils Static instance for conversions
     */
    public static $ils;

    /**
     * @var Unit $inr Static instance for conversions
     */
    public static $inr;

    /**
     * @var Unit $krw Static instance for conversions
     */
    public static $krw;

    /**
     * @var Unit $mxn Static instance for conversions
     */
    public static $mxn;

    /**
     * @var Unit $myr Static instance for conversions
     */
    public static $myr;

    /**
     * @var Unit $nzd Static instance for conversions
     */
    public static $nzd;

    /**
     * @var Unit $php Static instance for conversions
     */
    public static $php;

    /**
     * @var Unit $sgd Static instance for conversions
     */
    public static $sgd;

    /**
     * @var Unit $thb Static instance for conversions
     */
    public static $thb;

    /**
     * @var Unit $zar Static instance for conversions
     */
    public static $zar;

    /**
     * @var array List of convertible units
     */
    protected $units = [];

    /**
     * CurrencyConverter constructor.
     * @param EcbClientInterface $ecbClient leave blank for default ECB client
     */
    public function __construct(EcbClientInterface $ecbClient = null)
    {

        $cc = new CurrCurr($ecbClient);
        $exchangeRates = $cc->getExchangeRates();

        $this->units[] = self::$eur = new Unit('EUR', '€', 1);
        $this->units[] = self::$usd = new Unit(Currency::USD, '$', $exchangeRates[Currency::USD]->getRate());
        $this->units[] = self::$jpy = new Unit(Currency::JPY, '¥', $exchangeRates[Currency::JPY]->getRate());
        $this->units[] = self::$bgn = new Unit(Currency::BGN, 'лв', $exchangeRates[Currency::BGN]->getRate());
        $this->units[] = self::$czk = new Unit(Currency::CZK, 'Kč', $exchangeRates[Currency::CZK]->getRate());
        $this->units[] = self::$dkk = new Unit(Currency::DKK, 'kr', $exchangeRates[Currency::DKK]->getRate());
        $this->units[] = self::$gbp = new Unit(Currency::GBP, '£', $exchangeRates[Currency::GBP]->getRate());
        $this->units[] = self::$huf = new Unit(Currency::HUF, 'Ft', $exchangeRates[Currency::HUF]->getRate());
        $this->units[] = self::$pln = new Unit(Currency::PLN, 'zł', $exchangeRates[Currency::PLN]->getRate());
        $this->units[] = self::$ron = new Unit(Currency::RON, 'lei', $exchangeRates[Currency::RON]->getRate());
        $this->units[] = self::$sek = new Unit(Currency::SEK, 'kr', $exchangeRates[Currency::SEK]->getRate());
        $this->units[] = self::$chf = new Unit(Currency::CHF, 'CHF', $exchangeRates[Currency::CHF]->getRate());
        $this->units[] = self::$nok = new Unit(Currency::NOK, 'kr', $exchangeRates[Currency::NOK]->getRate());
        $this->units[] = self::$hrk = new Unit(Currency::HRK, 'kn', $exchangeRates[Currency::HRK]->getRate());
        $this->units[] = self::$rub = new Unit(Currency::RUB, 'руб', $exchangeRates[Currency::RUB]->getRate());
        $this->units[] = self::$try = new Unit(Currency::TRY, '₺', $exchangeRates[Currency::TRY]->getRate());
        $this->units[] = self::$aud = new Unit(Currency::AUD, '$', $exchangeRates[Currency::AUD]->getRate());
        $this->units[] = self::$brl = new Unit(Currency::BRL, 'R$', $exchangeRates[Currency::BRL]->getRate());
        $this->units[] = self::$cad = new Unit(Currency::CAD, '$', $exchangeRates[Currency::CAD]->getRate());
        $this->units[] = self::$cny = new Unit(Currency::CNY, '¥', $exchangeRates[Currency::CNY]->getRate());
        $this->units[] = self::$hkd = new Unit(Currency::HKD, '$', $exchangeRates[Currency::HKD]->getRate());
        $this->units[] = self::$idr = new Unit(Currency::IDR, 'Rp', $exchangeRates[Currency::IDR]->getRate());
        $this->units[] = self::$ils = new Unit(Currency::ILS, '₪', $exchangeRates[Currency::ILS]->getRate());
        $this->units[] = self::$inr = new Unit(Currency::INR, '₹', $exchangeRates[Currency::INR]->getRate());
        $this->units[] = self::$krw = new Unit(Currency::KRW, '₩', $exchangeRates[Currency::KRW]->getRate());
        $this->units[] = self::$mxn = new Unit(Currency::MXN, '$', $exchangeRates[Currency::MXN]->getRate());
        $this->units[] = self::$myr = new Unit(Currency::MYR, 'RM', $exchangeRates[Currency::MYR]->getRate());
        $this->units[] = self::$nzd = new Unit(Currency::NZD, '$', $exchangeRates[Currency::NZD]->getRate());
        $this->units[] = self::$php = new Unit(Currency::PHP, '₱', $exchangeRates[Currency::PHP]->getRate());
        $this->units[] = self::$sgd = new Unit(Currency::SGD, '$', $exchangeRates[Currency::SGD]->getRate());
        $this->units[] = self::$thb = new Unit(Currency::THB, '฿', $exchangeRates[Currency::THB]->getRate());
        $this->units[] = self::$zar = new Unit(Currency::ZAR, 'R', $exchangeRates[Currency::ZAR]->getRate());

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
        parent::normalize($cv);
        $cv->setUnit(self::$eur);
    }

}
