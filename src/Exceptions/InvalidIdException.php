<?php

namespace Bdt\DictTransformer\Exceptions;

use Exception;

class InvalidIdException extends Exception
{
    public function __construct($idField)
    {
        $this->message = "Data does not contain the configured ID key <{$idField}>";
    }
}
