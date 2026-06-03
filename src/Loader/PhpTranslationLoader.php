<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use InvalidArgumentException;

/**
 * Translation loader that loads translation data from PHP files
 *
 * This loader extends the **FileTranslationLoader** to load translation arrays from PHP files.
 * PHP files should return an array containing the translation data structure.
 *
 * @package KetPHP\Translator\Loader
 */
final class PhpTranslationLoader extends FileTranslationLoader
{

    /**
     * Creates a new PhpTranslationLoader instance
     *
     * Loads and parses a PHP file that returns an array of translation data.
     * The PHP file must exist and return a valid array.
     *
     * @param string $filepath Path to the PHP file containing translation data
     *
     * @throws InvalidArgumentException If the specified file does not exist or is not readable
     * @throws InvalidArgumentException If the PHP file does not return an array
     *
     * @example
     * // Example PHP translation file (en.php):
     * return [
     *     'welcome' => 'Welcome',
     *     'user' => [
     *         'name' => 'Name',
     *         'email' => 'Email'
     *     ]
     * ];
     *
     * $loader = new PhpTranslationLoader('/path/to/translations/en.php');
     */
    public function __construct(private readonly string $filepath)
    {
    }

    public function __invoke(): array
    {
        return $this->load($this->filepath, function ($path) {
            return (static function ($_path) {
                return require $_path;
            })($path);
        })();
    }
}