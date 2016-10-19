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
        $cv->setValue($cv->getValue() / $cv->getUnit()->getFactor());
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

            case self::$jpy:
                $from->setValue($from->getValue() * self::$jpy->getFactor());
                $from->setUnit(self::$jpy);
                break;

            case self::$bgn:
                $from->setValue($from->getValue() * self::$bgn->getFactor());
                $from->setUnit(self::$bgn);
                break;

            case self::$czk:
                $from->setValue($from->getValue() * self::$czk->getFactor());
                $from->setUnit(self::$czk);
                break;

            case self::$dkk:
                $from->setValue($from->getValue() * self::$dkk->getFactor());
                $from->setUnit(self::$dkk);
                break;

            case self::$gbp:
                $from->setValue($from->getValue() * self::$gbp->getFactor());
                $from->setUnit(self::$gbp);
                break;

            case self::$huf:
                $from->setValue($from->getValue() * self::$huf->getFactor());
                $from->setUnit(self::$huf);
                break;

            case self::$pln:
                $from->setValue($from->getValue() * self::$pln->getFactor());
                $from->setUnit(self::$pln);
                break;

            case self::$ron:
                $from->setValue($from->getValue() * self::$ron->getFactor());
                $from->setUnit(self::$ron);
                break;

            case self::$sek:
                $from->setValue($from->getValue() * self::$sek->getFactor());
                $from->setUnit(self::$sek);
                break;

            case self::$chf:
                $from->setValue($from->getValue() * self::$chf->getFactor());
                $from->setUnit(self::$chf);
                break;

            case self::$nok:
                $from->setValue($from->getValue() * self::$nok->getFactor());
                $from->setUnit(self::$nok);
                break;

            case self::$hrk:
                $from->setValue($from->getValue() * self::$hrk->getFactor());
                $from->setUnit(self::$hrk);
                break;

            case self::$rub:
                $from->setValue($from->getValue() * self::$rub->getFactor());
                $from->setUnit(self::$rub);
                break;

            case self::$try:
                $from->setValue($from->getValue() * self::$try->getFactor());
                $from->setUnit(self::$try);
                break;

            case self::$aud:
                $from->setValue($from->getValue() * self::$aud->getFactor());
                $from->setUnit(self::$aud);
                break;

            case self::$brl:
                $from->setValue($from->getValue() * self::$brl->getFactor());
                $from->setUnit(self::$brl);
                break;

            case self::$cad:
                $from->setValue($from->getValue() * self::$cad->getFactor());
                $from->setUnit(self::$cad);
                break;

            case self::$cny:
                $from->setValue($from->getValue() * self::$cny->getFactor());
                $from->setUnit(self::$cny);
                break;

            case self::$hkd:
                $from->setValue($from->getValue() * self::$hkd->getFactor());
                $from->setUnit(self::$hkd);
                break;

            case self::$idr:
                $from->setValue($from->getValue() * self::$idr->getFactor());
                $from->setUnit(self::$idr);
                break;

            case self::$ils:
                $from->setValue($from->getValue() * self::$ils->getFactor());
                $from->setUnit(self::$ils);
                break;

            case self::$inr:
                $from->setValue($from->getValue() * self::$inr->getFactor());
                $from->setUnit(self::$inr);
                break;

            case self::$krw:
                $from->setValue($from->getValue() * self::$krw->getFactor());
                $from->setUnit(self::$krw);
                break;

            case self::$mxn:
                $from->setValue($from->getValue() * self::$mxn->getFactor());
                $from->setUnit(self::$mxn);
                break;

            case self::$myr:
                $from->setValue($from->getValue() * self::$myr->getFactor());
                $from->setUnit(self::$myr);
                break;

            case self::$nzd:
                $from->setValue($from->getValue() * self::$nzd->getFactor());
                $from->setUnit(self::$nzd);
                break;

            case self::$php:
                $from->setValue($from->getValue() * self::$php->getFactor());
                $from->setUnit(self::$php);
                break;

            case self::$sgd:
                $from->setValue($from->getValue() * self::$sgd->getFactor());
                $from->setUnit(self::$sgd);
                break;

            case self::$thb:
                $from->setValue($from->getValue() * self::$thb->getFactor());
                $from->setUnit(self::$thb);
                break;

            case self::$zar:
                $from->setValue($from->getValue() * self::$zar->getFactor());
                $from->setUnit(self::$zar);
                break;
        }
    }

}
