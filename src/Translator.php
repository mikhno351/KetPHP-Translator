<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use KetPHP\Translator\Common\TranslationFallbackInterface;
use KetPHP\Translator\Common\TranslationLoaderInterface;
use KetPHP\Translator\Common\TranslatorInterface;
use KetPHP\Translator\Loader\ArrayTranslationLoader;

/**
 * Static single-locale Translator implementation.
 *
 * Supports loading translation files from different locales, merging fallback translations,
 * and replacing placeholders in translation strings with both positional and named parameters.
 */
final class Translator implements TranslatorInterface
{

    private readonly TranslationFallbackInterface $translationFallback;

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
     * @param class-string<TranslationFallbackInterface> $translationFallback Fallback handler class
     */
    public function __construct(private readonly string $localeDefault, private ?string $locale = null, string $translationFallback = TranslationFallback::class)
    {
        $this->locale ??= $this->localeDefault;
        $this->translationFallback = new $translationFallback();
    }

    /**
     * Add a locale catalogue with translations
     *
     * @param string $locale Locale code (e.g., 'en', 'fr')
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
     * @param string $locale Locale code (e.g., 'en', 'fr')
     * @param array $translations Data for translation
     * @return void
     */
    public function addResource(string $locale, array $translations): void
    {
        $this->addLoader($locale, new ArrayTranslationLoader($translations));
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
            $value = ($this->translationFallback)($key, $this->locale);
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
        $targetLocales = array_unique([$this->localeDefault, $this->locale]);

        foreach ($targetLocales as $locale) {
            if (isset($this->catalogues[$locale]) === true) {
                foreach ($this->catalogues[$locale] as $loader) {
                    $this->translations = array_replace($this->translations, $loader());
                }
            }
        }

        $this->initialized = true;
    }
}