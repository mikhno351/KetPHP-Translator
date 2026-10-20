<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit\Abstract;

use KetPHP\Translator\Common\TranslationLoaderInterface;
use KetPHP\Translator\Locale;
use KetPHP\Translator\Translator;
use PHPUnit\Framework\TestCase;

abstract class AbstractTranslationLoaderTest extends TestCase
{

    protected TranslationLoaderInterface $loader;

    abstract public function testLoader(): void;

    public function testLoaderContent(): void
    {
        $this->assertEquals(['key.message' => 'Message'], ($this->loader)());
    }

    public function testTranslatorWithLoader(): void
    {
        $translator = new Translator(Locale::ENGLISH);
        $translator->addLoader(Locale::ENGLISH, $this->loader);

        $this->assertEquals('Message', $translator->translate('key.message'));
    }
}