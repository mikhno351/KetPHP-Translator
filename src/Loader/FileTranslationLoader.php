<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use InvalidArgumentException;
use KetPHP\Translator\Common\TranslationLoaderInterface;

/**
 * Translation loader that loads translation data files
 *
 * This loader extends the ArrayTranslationLoader to load translation arrays from files.
 *
 * @package KetPHP\Translator\Loader
 */
abstract class FileTranslationLoader implements TranslationLoaderInterface
{

    /**
     * Validates the file, parses its content, and ensures the result is an array
     *
     * This helper method encapsulates the full lifecycle of file-based translation loading:
     * 1. Validates that the file exists and is readable.
     * 2. Executes the provided parser callback to extract data.
     * 3. Validates that the resulting data structure is a valid array.
     *
     * @param string $filepath Path to the translation file
     * @param callable $callable Callback function that handles the actual file parsing
     * @return ArrayTranslationLoader The parsed translation data
     *
     * @throws InvalidArgumentException If the file is missing, not readable, or does not return an array
     *
     * @example
     * $data = $this->load($filepath, function($path) {
     *      return json_decode(file_get_contents($path), true);
     * });
     */
    protected function load(string $filepath, callable $callable): ArrayTranslationLoader
    {
        if (is_file($filepath) === false || is_readable($filepath) === false) {
            throw new InvalidArgumentException(sprintf('File "%s" does not exist or is not readable.', $filepath));
        }

        $data = $callable($filepath);

        if (is_array($data) === false) {
            throw new InvalidArgumentException(sprintf('File "%s" must return an array, got "%s".', $filepath, gettype($data)));
        }

        return new ArrayTranslationLoader((array)$data);
    }
}