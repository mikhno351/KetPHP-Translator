<?php

declare(strict_types=1);

namespace KetPHP\Translator\Exception;

use LogicException;

class LoaderParseException extends LogicException
{

    protected $message = 'The file could not be processed, or the final result is not equal to the array.';
}