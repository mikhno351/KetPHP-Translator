<?php

declare(strict_types=1);

namespace KetPHP\Translator\Exception;

use LogicException;

class LoaderUnavailableException extends LogicException
{

    protected $message = 'The loader you are calling is unavailable due to a configuration limitation.';
}