<?php

declare(strict_types=1);

namespace KetPHP\Translator\Formatter;

use KetPHP\Translator\Common\TranslatorFallbackFormatterInterface;

final class TranslatorFallbackFormatter implements TranslatorFallbackFormatterInterface
{

    public function __invoke(string $key, string $locale): string
    {
        return $key;
    }
}