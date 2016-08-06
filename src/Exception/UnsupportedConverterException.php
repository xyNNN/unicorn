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

class UnsupportedConverterException extends \InvalidArgumentException
{
    /**
     * @param Unit $unit
     */
    public function __construct($unit)
    {
        parent::__construct(sprintf(
            'The converter for "%s" is not known.',
            $unit->getName()
        ));
    }
}