<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use InvalidArgumentException;

/**
 * Translation loader that loads translation data from INI files
 *
 * This loader extends the **FileTranslationLoader** to load translation arrays from INI files.
 * INI files can use sections to create nested structures.
 *
 * @package KetPHP\Translator\Loader
 */
final class IniTranslationLoader extends FileTranslationLoader
{

    /**
     * Creates a new IniTranslationLoader instance
     *
     * Loads and parses an INI file containing translation data.
     * The INI file must exist and be a valid INI structure.
     *
     * @param string $filepath Path to the INI file containing translation data
     *
     * @throws InvalidArgumentException If the parse_ini_file function is disabled
     * @throws InvalidArgumentException If the file does not exist or is not readable
     * @throws InvalidArgumentException If the INI file is invalid or cannot be parsed
     *
     * @example
     * // Example INI translation file (en.ini):
     * welcome = "Welcome"
     * [user]
     * name = "Name"
     * email = "Email"
     *
     * $loader = new IniTranslationLoader('/path/to/translations/en.ini');
     */
    public function __construct(private readonly string $filepath)
    {
    }

    public function __invoke(): array
    {
        return $this->load($this->filepath, function (string $path): array {
            if (function_exists('parse_ini_file') === false) {
                throw new InvalidArgumentException('The "parse_ini_file" function is disabled or not available in this PHP environment.');
            }

            $data = @parse_ini_file($path, true);

            if ($data === false) {
                throw new InvalidArgumentException(sprintf('Invalid INI format in file "%s".', $path));
            }

            return $data;
        })();
    }
}