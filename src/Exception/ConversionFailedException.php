<?php
/*
 * This file is part of the unicorn project
 *
 * (c) Philipp Braeutigam <philipp.braeutigam@googlemail.com>, Steffen Brand <s.brand@steffenbrand.com> and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SteffenBrand\CurrCurr\Exception;

use Exception;
use RuntimeException;

class ConversionFailedException extends RuntimeException
{

    public function __construct(Exception $e)
    {
        parent::__construct('Conversion failed due to unexpected errors.', $e->getCode(), $e);
    }

}