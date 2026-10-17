<?php

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\XmlTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class XmlTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new XmlTranslationLoader(dirname(__DIR__, 2) . '/Fixture/locale.xml');
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(XmlTranslationLoader::class, $this->loader);
    }
}
