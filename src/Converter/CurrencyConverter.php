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

use Exception;
use InvalidArgumentException;
use SteffenBrand\CurrCurr\Client\EcbClientInterface;
use SteffenBrand\CurrCurr\CurrCurr;
use SteffenBrand\CurrCurr\Exception\ConversionFailedException;
use SteffenBrand\CurrCurr\Exception\CurrencyNotSupportedException;
use SteffenBrand\CurrCurr\Model\Currency;
use Xynnn\Unicorn\Exception\UnsupportedUnitException;
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

    private $exchangeRatesClient;

    /**
     * CurrencyConverter constructor.
     * @param EcbClientInterface $ecbClient leave blank for default ECB client
     */
    public function __construct(EcbClientInterface $ecbClient = null)
    {
        $this->exchangeRatesClient = new CurrCurr($ecbClient);

        $this->units[] = self::$eur = new Unit('EUR', '€', 1);
        $this->units[] = self::$usd = new Unit(Currency::USD, '$');
        $this->units[] = self::$jpy = new Unit(Currency::JPY, '¥');
        $this->units[] = self::$bgn = new Unit(Currency::BGN, 'лв');
        $this->units[] = self::$czk = new Unit(Currency::CZK, 'Kč');
        $this->units[] = self::$dkk = new Unit(Currency::DKK, 'kr');
        $this->units[] = self::$gbp = new Unit(Currency::GBP, '£');
        $this->units[] = self::$huf = new Unit(Currency::HUF, 'Ft');
        $this->units[] = self::$pln = new Unit(Currency::PLN, 'zł');
        $this->units[] = self::$ron = new Unit(Currency::RON, 'lei');
        $this->units[] = self::$sek = new Unit(Currency::SEK, 'kr');
        $this->units[] = self::$chf = new Unit(Currency::CHF, 'CHF');
        $this->units[] = self::$nok = new Unit(Currency::NOK, 'kr');
        $this->units[] = self::$hrk = new Unit(Currency::HRK, 'kn');
        $this->units[] = self::$rub = new Unit(Currency::RUB, 'руб');
        $this->units[] = self::$try = new Unit(Currency::TRY, '₺');
        $this->units[] = self::$aud = new Unit(Currency::AUD, '$');
        $this->units[] = self::$brl = new Unit(Currency::BRL, 'R$');
        $this->units[] = self::$cad = new Unit(Currency::CAD, '$');
        $this->units[] = self::$cny = new Unit(Currency::CNY, '¥');
        $this->units[] = self::$hkd = new Unit(Currency::HKD, '$');
        $this->units[] = self::$idr = new Unit(Currency::IDR, 'Rp');
        $this->units[] = self::$ils = new Unit(Currency::ILS, '₪');
        $this->units[] = self::$inr = new Unit(Currency::INR, '₹');
        $this->units[] = self::$krw = new Unit(Currency::KRW, '₩');
        $this->units[] = self::$mxn = new Unit(Currency::MXN, '$');
        $this->units[] = self::$myr = new Unit(Currency::MYR, 'RM');
        $this->units[] = self::$nzd = new Unit(Currency::NZD, '$');
        $this->units[] = self::$php = new Unit(Currency::PHP, '₱');
        $this->units[] = self::$sgd = new Unit(Currency::SGD, '$');
        $this->units[] = self::$thb = new Unit(Currency::THB, '฿');
        $this->units[] = self::$zar = new Unit(Currency::ZAR, 'R');
    }

    /**
     * @return string Name of the converter
     */
    public function getName(): string
    {
        return 'unicorn.converter.currency';
    }

    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
     * @throws UnsupportedUnitException|InvalidArgumentException|ConversionFailedException
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue
    {
        if (false === $from->getUnit()->isFactorSet() || false === $to->isFactorSet()) {
            $this->loadExchangeRates();
        }

        return parent::convert($from, $to);
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        if (false === $cv->getUnit()->isFactorSet()) {
            $this->loadExchangeRates();
            if (false === $cv->getUnit()->isFactorSet()) {
                throw new ConversionFailedException(new CurrencyNotSupportedException());
            }
        }
        parent::normalize($cv);
    }

    /**
     * @throws ConversionFailedException
     */
    public function loadExchangeRates()
    {
        try {
            $exchangeRates = $this->exchangeRatesClient->getExchangeRates();

            foreach ($this->units as $unit) {
                if (false === $unit->isFactorSet()) {
                    $unit->setFactor(strval($exchangeRates[$unit->getName()]->getRate()));
                }
            }
        } catch (Exception $e) {
            throw new ConversionFailedException($e);
        }
    }

    /**
     * @return Unit
     */
    public function getBaseUnit(): Unit
    {
        return self::$eur;
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
