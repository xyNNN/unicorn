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

class UnsupportedOperationException extends \LogicException
{
    /**
     * @param string $operation
     */
    public function __construct($operation)
    {
        parent::__construct(sprintf(
            'The operation "%s" is not possible or not implemented yet.',
            $operation
        ));
    }
}