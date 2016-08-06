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

use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

interface ConverterInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
     */
    public function convert(ConvertibleValue $from, Unit $to) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv2
     * @param ConvertibleValue $cv1
     * @return ConvertibleValue
     */
    public function add(ConvertibleValue $cv1, ConvertibleValue $cv2) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function substract(ConvertibleValue $cv1, ConvertibleValue $cv2) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function multiply(ConvertibleValue $cv1, ConvertibleValue $cv2) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function divide(ConvertibleValue $cv1, ConvertibleValue $cv2) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv
     * @param int $power
     * @return ConvertibleValue
     */
    public function exponentiate(ConvertibleValue $cv, int $power) : ConvertibleValue;

    /**
     * @param ConvertibleValue $cv
     * @param int $nthRoot
     * @return ConvertibleValue
     */
    public function root(ConvertibleValue $cv, int $nthRoot) : ConvertibleValue;

}