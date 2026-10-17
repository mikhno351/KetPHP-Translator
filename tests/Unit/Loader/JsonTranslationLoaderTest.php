<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\JsonTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class JsonTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new JsonTranslationLoader(dirname(__DIR__, 2) . '/Fixture/locale.json');
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(JsonTranslationLoader::class, $this->loader);
    }
}
