<?php

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