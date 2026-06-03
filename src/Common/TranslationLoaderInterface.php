<?php

declare(strict_types=1);

namespace KetPHP\Translator\Common;

interface TranslationLoaderInterface
{

    public function __invoke(): array;
}