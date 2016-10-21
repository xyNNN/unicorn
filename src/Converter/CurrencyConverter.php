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

use Exception;
use SteffenBrand\CurrCurr\Client\EcbClientInterface;
use SteffenBrand\CurrCurr\CurrCurr;
use SteffenBrand\CurrCurr\Exception\ConversionFailedException;
use SteffenBrand\CurrCurr\Exception\CurrencyNotSupportedException;
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
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue
    {
        if (null === $from->getUnit()->getFactor() || null === $to->getFactor()) {
            $this->loadExchangeRates();
        }

        return parent::convert($from, $to);
    }

    /**
     * @param ConvertibleValue $cv The Convertible to be normalized
     */
    protected function normalize(ConvertibleValue $cv)
    {
        if (null === $cv->getUnit()->getFactor()) {
            $this->loadExchangeRates();
            if (null === $cv->getUnit()->getFactor()) {
                throw new ConversionFailedException(new CurrencyNotSupportedException());
            }
        }
        parent::normalize($cv);
        $cv->setUnit(self::$eur);
    }

    public function loadExchangeRates()
    {
        try {
            $exchangeRates = $this->exchangeRatesClient->getExchangeRates();

            if (null === self::$usd->getFactor()) {
                self::$usd->setFactor($exchangeRates[self::$usd->getName()]->getRate());
            }
            if (null === self::$jpy->getFactor()) {
                self::$jpy->setFactor($exchangeRates[self::$jpy->getName()]->getRate());
            }
            if (null === self::$bgn->getFactor()) {
                self::$bgn->setFactor($exchangeRates[self::$bgn->getName()]->getRate());
            }
            if (null === self::$czk->getFactor()) {
                self::$czk->setFactor($exchangeRates[self::$czk->getName()]->getRate());
            }
            if (null === self::$dkk->getFactor()) {
                self::$dkk->setFactor($exchangeRates[self::$dkk->getName()]->getRate());
            }
            if (null === self::$gbp->getFactor()) {
                self::$gbp->setFactor($exchangeRates[self::$gbp->getName()]->getRate());
            }
            if (null === self::$huf->getFactor()) {
                self::$huf->setFactor($exchangeRates[self::$huf->getName()]->getRate());
            }
            if (null === self::$pln->getFactor()) {
                self::$pln->setFactor($exchangeRates[self::$pln->getName()]->getRate());
            }
            if (null === self::$ron->getFactor()) {
                self::$ron->setFactor($exchangeRates[self::$ron->getName()]->getRate());
            }
            if (null === self::$sek->getFactor()) {
                self::$sek->setFactor($exchangeRates[self::$sek->getName()]->getRate());
            }
            if (null === self::$chf->getFactor()) {
                self::$chf->setFactor($exchangeRates[self::$chf->getName()]->getRate());
            }
            if (null === self::$nok->getFactor()) {
                self::$nok->setFactor($exchangeRates[self::$nok->getName()]->getRate());
            }
            if (null === self::$hrk->getFactor()) {
                self::$hrk->setFactor($exchangeRates[self::$hrk->getName()]->getRate());
            }
            if (null === self::$rub->getFactor()) {
                self::$rub->setFactor($exchangeRates[self::$rub->getName()]->getRate());
            }
            if (null === self::$try->getFactor()) {
                self::$try->setFactor($exchangeRates[self::$try->getName()]->getRate());
            }
            if (null === self::$aud->getFactor()) {
                self::$aud->setFactor($exchangeRates[self::$aud->getName()]->getRate());
            }
            if (null === self::$brl->getFactor()) {
                self::$brl->setFactor($exchangeRates[self::$brl->getName()]->getRate());
            }
            if (null === self::$cad->getFactor()) {
                self::$cad->setFactor($exchangeRates[self::$cad->getName()]->getRate());
            }
            if (null === self::$cny->getFactor()) {
                self::$cny->setFactor($exchangeRates[self::$cny->getName()]->getRate());
            }
            if (null === self::$hkd->getFactor()) {
                self::$hkd->setFactor($exchangeRates[self::$hkd->getName()]->getRate());
            }
            if (null === self::$idr->getFactor()) {
                self::$idr->setFactor($exchangeRates[self::$idr->getName()]->getRate());
            }
            if (null === self::$ils->getFactor()) {
                self::$ils->setFactor($exchangeRates[self::$ils->getName()]->getRate());
            }
            if (null === self::$inr->getFactor()) {
                self::$inr->setFactor($exchangeRates[self::$inr->getName()]->getRate());
            }
            if (null === self::$krw->getFactor()) {
                self::$krw->setFactor($exchangeRates[self::$krw->getName()]->getRate());
            }
            if (null === self::$mxn->getFactor()) {
                self::$mxn->setFactor($exchangeRates[self::$mxn->getName()]->getRate());
            }
            if (null === self::$myr->getFactor()) {
                self::$myr->setFactor($exchangeRates[self::$myr->getName()]->getRate());
            }
            if (null === self::$nzd->getFactor()) {
                self::$nzd->setFactor($exchangeRates[self::$nzd->getName()]->getRate());
            }
            if (null === self::$php->getFactor()) {
                self::$php->setFactor($exchangeRates[self::$php->getName()]->getRate());
            }
            if (null === self::$sgd->getFactor()) {
                self::$sgd->setFactor($exchangeRates[self::$sgd->getName()]->getRate());
            }
            if (null === self::$thb->getFactor()) {
                self::$thb->setFactor($exchangeRates[self::$thb->getName()]->getRate());
            }
            if (null === self::$zar->getFactor()) {
                self::$zar->setFactor($exchangeRates[self::$zar->getName()]->getRate());
            }
        } catch (Exception $e) {
            throw new ConversionFailedException($e);
        }
    }

}
