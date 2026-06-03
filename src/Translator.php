<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use KetPHP\Translator\Common\TranslationLoaderInterface;
use KetPHP\Translator\Common\TranslatorInterface;
use KetPHP\Translator\Loader\ArrayTranslationLoader;

/**
 * Translator implementation for handling multiple language translations.
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
     * @var string[] Cache of loaded translations
     */
    private array $translations = [];

    /**
     * @var string[]
     */
    private array $loadedIds = [];

    /**
     * Constructor
     *
     * @param string $localeDefault Default locale code to use as fallback
     * @param string|null $locale Current locale code (uses `$localeDefault` if null)
     */
    public function __construct(private readonly string $localeDefault, private ?string $locale = null)
    {
        $this->locale ??= $this->localeDefault;
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
        $this->initLocales();
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
    public function translate(string $key, array $params = [], ?string $default = null): string
    {
        $this->initLocales();

        $value = ($this->translations[$key] ?? ($default ?? $key));

        if (empty($params) === true) {
            return $value;
        }

        $placeholders = [];
        foreach ($params as $k => $v) {
            $placeholders['{' . $k . '}'] = (string)$v;
        }

        return strtr($value, $placeholders);
    }

    private function initLocales(): void
    {
        $targetLocales = array_unique([$this->localeDefault, $this->locale]);

        foreach ($targetLocales as $locale) {
            $this->initLocale($locale);
        }
    }

    private function initLocale(string $locale): void
    {
        if (isset($this->catalogues[$locale]) === false) {
            return;
        }

        foreach ($this->catalogues[$locale] as $loader) {
            $loaderId = spl_object_hash($loader);

            if (isset($this->loadedIds[$loaderId]) === false) {
                $this->translations = array_replace($this->translations, $loader());
                $this->loadedIds[$loaderId] = true;
            }
        }
    }
}