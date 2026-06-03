<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use KetPHP\Translator\Common\TranslationLoaderInterface;

/**
 * Translation loader that converts a multidimensional array into a dot-notated flat array
 *
 * This loader takes a nested array structure and flattens it using dot notation,
 * making it easier to access deeply nested translation keys with a simple string syntax.
 * For example: ['user' => ['name' => 'John']] becomes ['user.name' => 'John']
 *
 * @package KetPHP\Translator\Loader
 */
final class ArrayTranslationLoader implements TranslationLoaderInterface
{

    /**
     * @var array The flattened translation data in dot notation
     */
    private readonly array $data;

    /**
     * Creates a new ArrayTranslationLoader instance
     *
     * @param array $array Multidimensional array containing translation data
     */
    public function __construct(array $array)
    {
        $this->data = $this->dot($array);
    }

    /**
     * Returns the flattened translation data array
     *
     * @return array Array with dot-notated keys and their corresponding values
     */
    public function __invoke(): array
    {
        return $this->data;
    }

    /**
     * Flattens a multidimensional array into a single level array using dot notation
     *
     * Recursively processes an array, converting nested keys to dot notation.
     * Empty arrays are preserved as values rather than being flattened further.
     *
     * @author Laravel Framework
     * @link https://laravel.com/docs/12.x/helpers#method-array-dot
     *
     * @param array $array The array to flatten
     * @return array Flattened array with dot-notated keys
     */
    private function dot(array $array): array
    {
        $results = [];
        $this->flatten($array, $results);
        return $results;
    }

    private function flatten(array $array, array &$results, string $prepend = ''): void
    {
        foreach ($array as $key => $value) {
            if (is_array($value) === true && empty($value) === false) {
                $this->flatten($value, $results, $prepend . $key . '.');
            } else {
                $results[$prepend . $key] = $value;
            }
        }
    }
}