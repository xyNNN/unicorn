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
     *
     * @return mixed
     */
    public function convert($convertible, $to);
}