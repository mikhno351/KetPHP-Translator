<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use KetPHP\Translator\Common\TranslationFallbackInterface;

final class TranslationFallback implements TranslationFallbackInterface
{

    public function __invoke(string $key, string $locale): string
    {
        return $key;
    }
}