<?php

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\YamlTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class YamlTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new YamlTranslationLoader(dirname(__DIR__, 2) . '/Fixture/locale.yaml');
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(YamlTranslationLoader::class, $this->loader);
    }
}
