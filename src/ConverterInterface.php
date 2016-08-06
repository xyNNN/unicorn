<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn;

use Xynnn\Unicorn\Model\Convertible;
use Xynnn\Unicorn\Model\Unit;

interface ConverterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param Convertible $convertible
     * @param Unit $to
     * @return void
     */
    public function convert(Convertible $convertible, Unit $to);

    /**
     * @param Convertible $c2
     * @param Convertible $c1
     * @return Convertible
     */
    public function add(Convertible $c1, Convertible $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    public function substract(Convertible $c1, Convertible $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    public function multiply(Convertible $c1, Convertible $c2);

    /**
     * @param Convertible $c1
     * @param Convertible $c2
     * @return Convertible
     */
    public function divide(Convertible $c1, Convertible $c2);
}