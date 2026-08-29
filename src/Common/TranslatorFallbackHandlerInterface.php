<?php

declare(strict_types=1);

namespace KetPHP\Translator\Common;

interface TranslatorFallbackHandlerInterface
{

    public function __invoke(string $key, string $locale): string;
}