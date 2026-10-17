<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\IniTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class IniTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new IniTranslationLoader(dirname(__DIR__, 2) . '/Fixture/locale.ini');
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(IniTranslationLoader::class, $this->loader);
    }
}
