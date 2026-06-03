<?php

declare(strict_types=1);

namespace KetPHP\Translator\Common;

interface TranslatorInterface
{

    public function translate(string $key, array $params = [], ?string $default = null): string;

    public function translations(): array;
}