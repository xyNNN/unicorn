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

interface ConverterInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param mixed $value
     * @param mixed$from
     * @param mixed $to
     *
     * @return mixed
     */
    public function convert($value, $from, $to);
}