<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>, Steffen Brand <s.brand@steffenbrand.com> and contributors
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
    public function getName(): string;

    /**
     * @param ConvertibleValue $from
     * @param Unit $to
     * @return ConvertibleValue
     */
    public function convert(ConvertibleValue $from, Unit $to): ConvertibleValue;
}