<?php

declare(strict_types=1);

namespace KetPHP\Translator\Common;

interface TranslationFallbackInterface
{

    public function __construct(string $key, string $locale);

    public function __invoke(): string;
}