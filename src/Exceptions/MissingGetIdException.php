<?php

namespace Bdt\DictTransformer\Exceptions;

use Exception;

class MissingGetIdException extends Exception
{

    protected $message = "Transformer does not have a getId method.";
}