<?php

declare(strict_types=1);

namespace KetPHP\Translator\Handler;

use KetPHP\Translator\Common\TranslatorFallbackHandlerInterface;

final class TranslatorFallbackHandler implements TranslatorFallbackHandlerInterface
{

    public function __invoke(string $key, string $locale): string
    {
        return $key;
    }
}