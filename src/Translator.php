<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use KetPHP\Translator\Common\TranslationLoaderInterface;
use KetPHP\Translator\Common\TranslatorFallbackFormatterInterface;
use KetPHP\Translator\Common\TranslatorInterface;
use KetPHP\Translator\Formatter\TranslatorFallbackFormatter;
use KetPHP\Translator\Loader\ArrayTranslationLoader;

/**
 * Static single-locale Translator implementation.
 *
 * Supports loading translation files from different locales, merging fallback translations,
 * and replacing placeholders in translation strings with both positional and named parameters.
 */
final class Translator implements TranslatorInterface
{

    /**
     * @var array<string, TranslationLoaderInterface[]> Array of locale catalogues keyed by locale code
     */
    private array $catalogues = [];

    /**
     * @var string[] Merged translations cache
     */
    private array $translations = [];

    private bool $initialized = false;

    /**
     * Constructor
     *
     * @param string $localeDefault Default locale code to use as fallback
     * @param string|null $locale Current locale code (uses `$localeDefault` if null)
     * @param ?TranslatorFallbackFormatterInterface $fallbackFormatter Fallback handler class (default uses `TranslatorFallbackFormatter`)
     */
    public function __construct(private readonly string $localeDefault, private ?string $locale = null, private ?TranslatorFallbackFormatterInterface $fallbackFormatter = null)
    {
        $this->setLocale($locale);
        $this->setFallbackFormatter($fallbackFormatter);
    }

    /**
     * Sets the current locale.
     *
     * Re-initializes the translations on the next translation lookup.
     *
     * @param string|null $locale Locale code or null to revert to the default locale
     * @return void
     */
    public function setLocale(?string $locale): void
    {
        $this->locale = $locale ?? $this->localeDefault;
        $this->initialized = false;
    }

    /**
     * Sets the fallback formatter used when a translation key is not found.
     *
     * @param TranslatorFallbackFormatterInterface|null $formatter Formatter instance or null to use the default fallback formatter
     * @return void
     */
    public function setFallbackFormatter(?TranslatorFallbackFormatterInterface $formatter): void
    {
        $this->fallbackFormatter = $formatter ?? new TranslatorFallbackFormatter();
    }

    /**
     * Add a locale catalogue with translations
     *
     * @param string $locale Locale code (e.g., 'en', 'en_US', 'english' and etc..)
     * @param TranslationLoaderInterface $loader Loader for translation
     * @return void
     */
    public function addLoader(string $locale, TranslationLoaderInterface $loader): void
    {
        $this->catalogues[$locale][] = $loader;
        $this->initialized = false;
    }

    /**
     * Add a locale catalogue with translations
     *
     * @param string $locale Locale code (e.g., 'en', 'en_US', 'english' and etc..)
     * @param array $translations Data for translation
     * @return void
     */
    public function addResource(string $locale, array $translations): void
    {
        $this->addLoader($locale, new ArrayTranslationLoader($translations));
    }

    /**
     * Get the default fallback locale code.
     *
     * @return string Default locale code
     */
    public function getLocaleDefault(): string
    {
        return $this->localeDefault;
    }

    /**
     * Get the current active locale code.
     *
     * @return string Current locale code
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Get all loaded translations
     *
     * @return array<string, mixed> Array of translation keys and values
     */
    public function translations(): array
    {
        $this->init();
        return $this->translations;
    }

    /**
     * Translate a key with optional parameters and default value
     *
     * @param string $key Translation key (dot notation supported)
     * @param array<string, string> $params Parameters for placeholder replacement
     * @param string|null $default Default value if key not found (uses key if null)
     * @return string Translated string with replaced placeholders
     */
    public function translate(string $key, array $params = [], ?string $default = null, bool $html = false): string
    {
        $this->init();

        $value = $this->translations[$key] ?? $default;
        if ($value === null) {
            $value = ($this->fallbackFormatter)($key, $this->locale);
        }

        if ($html === false) {
            $value = htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }

        if (empty($params) === true) {
            return $value;
        }

        $placeholders = [];
        foreach ($params as $k => $v) {
            $val = (string)$v;
            if ($html === false) {
                $val = htmlspecialchars($val, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            }
            $placeholders['{' . $k . '}'] = $val;
        }

        return strtr($value, $placeholders);
    }

    private function init(): void
    {
        if ($this->initialized === true) {
            return;
        }

        $this->translations = [];
        $targetLocales = array_unique(array_filter([$this->getLocaleDefault(), $this->getLocale()]));

        foreach ($targetLocales as $locale) {
            if (isset($this->catalogues[$locale]) === true) {
                foreach ($this->catalogues[$locale] as $loader) {
                    $this->translations = array_replace($this->translations, $loader());
                }
            }
        }

        $this->initialized = count($targetLocales) > 0;
    }
}