<?php

declare(strict_types=1);

namespace KetPHP\Translator\Common;

interface TranslatorInterface
{

    public function getLocaleDefault(): string;

    public function getLocale(): string;

    public function translate(string $key, array $params = [], ?string $default = null, bool $html = false): string;

    public function translations(): array;
}