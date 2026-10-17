<?php

declare(strict_types=1);

namespace KetPHP\Translator\Tests\Unit;

use KetPHP\Translator\Locale;
use KetPHP\Translator\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{

    private Translator $translator;

    protected function setUp(): void
    {
        $this->translator = new Translator(Locale::ENGLISH, Locale::BELARUSIAN);
        $this->translator->addResource(Locale::ENGLISH, [
            'message' => [
                'known' => 'Known',
                'not' => [
                    'localized' => 'Not localized',
                ]
            ]
        ]);
        $this->translator->addResource(Locale::BELARUSIAN, [
            'message' => [
                'known' => 'Вядомы',
            ]
        ]);
    }

    public function testLocalesSets(): void
    {
        $this->assertEquals('en', $this->translator->getLocaleDefault());
        $this->assertEquals('be', $this->translator->getLocale());
    }

    public function testTranslateMessageUnknownWithoutDefault(): void
    {
        $this->assertEquals('message.unknown', $this->translator->translate('message.unknown'));
    }

    public function testTranslateMessageUnknownWithDefault(): void
    {
        $this->assertEquals('Unknown', $this->translator->translate('message.unknown', default: 'Unknown'));
    }

    public function testTranslateMessageLocaleDefault(): void
    {
        $this->translator->setLocale(null);
        $this->assertEquals('Known', $this->translator->translate('message.known'));
        $this->assertEquals('Not localized', $this->translator->translate('message.not.localized'));
    }

    public function testTranslateMessageLocaleClient(): void
    {
        $this->translator->setLocale(Locale::BELARUSIAN);
        $this->assertEquals('Вядомы', $this->translator->translate('message.known'));
        $this->assertEquals('Not localized', $this->translator->translate('message.not.localized'));
    }
}
