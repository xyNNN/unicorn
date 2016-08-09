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
        $givenUnit = $this->getCurrentUnitAndNormalize($cv1, $cv2);
        $cv1->setValue($cv1->getValue() + $cv2->getValue());

        return $this->convert($cv1, $givenUnit);
    }

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return ConvertibleValue
     */
    public function substract(ConvertibleValue $cv1, ConvertibleValue $cv2): ConvertibleValue
    {
        $givenUnit = $this->getCurrentUnitAndNormalize($cv1, $cv2);
        $cv1->setValue($cv1->getValue() - $cv2->getValue());

        return $this->convert($cv1, $givenUnit);
    }

    /**
     * @param ConvertibleValue $cv1
     * @param ConvertibleValue $cv2
     * @return Unit
     */
    private function getCurrentUnitAndNormalize(ConvertibleValue $cv1, ConvertibleValue $cv2)
    {
        $givenUnit = $cv1->getUnit();
        $this->normalize($cv1);
        $this->normalize($cv2);

        return $givenUnit;
    }

}