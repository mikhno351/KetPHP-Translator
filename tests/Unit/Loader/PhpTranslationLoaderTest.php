<?php

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\PhpTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class PhpTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new PhpTranslationLoader(dirname(__DIR__, 2) . '/Fixture/locale.php');
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(PhpTranslationLoader::class, $this->loader);
    }
}
