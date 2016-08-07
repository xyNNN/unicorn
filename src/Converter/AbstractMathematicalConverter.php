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

use Xynnn\Unicorn\ConverterInterface;
use Xynnn\Unicorn\Exception\UnsupportedUnitException;
use Xynnn\Unicorn\Model\ConvertibleValue;
use Xynnn\Unicorn\Model\Unit;

abstract class AbstractMathematicalConverter extends AbstractConverter
{
    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function add(ConvertibleValue $cv1, ConvertibleValue $cv2): ConvertibleValue
    {
        $this->normalize($cv1);
        $this->normalize($cv2);
        $cv1->setValue($cv1->getValue() + $cv2->getValue());

        return $cv1;
    }

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function substract(ConvertibleValue $cv1, ConvertibleValue $cv2): ConvertibleValue
    {
        $this->normalize($cv1);
        $this->normalize($cv2);
        $cv1->setValue($cv1->getValue() - $cv2->getValue());

        return $cv1;
    }

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function multiply(ConvertibleValue $cv1, ConvertibleValue $cv2): ConvertibleValue
    {
        $this->normalize($cv1);
        $this->normalize($cv2);
        $cv1->setValue($cv1->getValue() * $cv2->getValue());

        return $cv1;
    }

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function divide(ConvertibleValue $cv1, ConvertibleValue $cv2): ConvertibleValue
    {
        $this->normalize($cv1);
        $this->normalize($cv2);
        $cv1->setValue($cv1->getValue() / $cv2->getValue());

        return $cv1;
    }

    /**
     * @param ConvertibleValue $cv
     * @param int $power
     * @return ConvertibleValue
     */
    public function exponentiate(ConvertibleValue $cv, int $power): ConvertibleValue
    {
        $cv->setValue(pow($cv->getValue(), $power));

        return $cv;
    }

    /**
     * @param ConvertibleValue $cv
     * @param int $nthRoot
     * @return ConvertibleValue
     */
    public function root(ConvertibleValue $cv, int $nthRoot): ConvertibleValue
    {
        $cv->setValue(pow($cv->getValue(), 1 / $nthRoot));

        return $cv;
    }
}