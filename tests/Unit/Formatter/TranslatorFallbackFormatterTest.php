<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit\Formatter;

use KetPHP\Translator\Common\TranslatorFallbackFormatterInterface;
use KetPHP\Translator\Formatter\TranslatorFallbackFormatter;
use KetPHP\Translator\Locale;
use KetPHP\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorFallbackFormatterTest extends TestCase
{

    private Translator $translator;

    protected function setUp(): void
    {
        $this->translator = new Translator(Locale::ENGLISH, Locale::BELARUSIAN, new TranslatorFallbackFormatter());
    }

    public function testFormatterByBase(): void
    {
        $this->assertEquals('message.unknown', $this->translator->translate('message.unknown'));
    }

    public function testFormatterByCustom(): void
    {
        $this->translator->setFallbackFormatter(new class implements TranslatorFallbackFormatterInterface {
            public function __invoke(string $key, string $locale): string
            {
                return '{' . $locale . ':' . $key . '}';
            }
        });

        $this->assertEquals('{be:message.unknown}', $this->translator->translate('message.unknown'));
    }
}
