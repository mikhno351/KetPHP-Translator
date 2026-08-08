<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use KetPHP\Translator\Common\TranslationFallbackInterface;

final class TranslationFallback implements TranslationFallbackInterface
{

    public function __construct(private readonly string $key, string $locale)
    {
    }

    public function __invoke(): string
    {
        return $this->key;
    }
}