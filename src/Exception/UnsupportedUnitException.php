<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xynnn\Unicorn\Exception;

use Xynnn\Unicorn\Model\Unit;

class UnsupportedUnitException extends \InvalidArgumentException
{
    /**
     * @param Unit $unit
     */
    public function __construct(Unit $unit)
    {
        parent::__construct(sprintf(
            'The conversion of "%s" is not possible. Make sure to use the static units from the converter instance.',
            $unit->getName()
        ));
    }
}