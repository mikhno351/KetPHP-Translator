<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit\Loader;

use KetPHP\Translator\Loader\ArrayTranslationLoader;
use KetPHP\Translator\Tests\Unit\Abstract\AbstractTranslationLoaderTest;

class ArrayTranslationLoaderTest extends AbstractTranslationLoaderTest
{

    protected function setUp(): void
    {
        $this->loader = new ArrayTranslationLoader([
            'message' => 'Message',
        ]);
    }

    public function testLoader(): void
    {
        $this->assertInstanceOf(ArrayTranslationLoader::class, $this->loader);
    }
}
