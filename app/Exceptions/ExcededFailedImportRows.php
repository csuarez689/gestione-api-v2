<?php

namespace App\Exceptions;

use Exception;

class ExcededFailedImportRows extends Exception
{
    public function __construct()
    {
        parent::__construct("Demasiados registros incorrectos. Revise el documento.", 422);
    }
}
