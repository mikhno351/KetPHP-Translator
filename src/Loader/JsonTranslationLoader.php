<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use InvalidArgumentException;
use Throwable;

/**
 * Translation loader that loads translation data from JSON files
 *
 * This loader extends the **FileTranslationLoader** to load translation arrays from JSON files.
 * JSON files should contain a valid JSON object representing the translation data structure.
 *
 * @package KetPHP\Translator\Loader
 */
final class JsonTranslationLoader extends FileTranslationLoader
{

    /**
     * Creates a new JsonTranslationLoader instance
     *
     * Loads and parses a JSON file containing translation data.
     * The JSON file must exist, contain valid JSON, and decode to an array.
     *
     * @param string $filepath Path to the JSON file containing translation data
     * @param int $flags JSON decode flags (optional, defaults to JSON_THROW_ON_ERROR)
     *
     * @throws InvalidArgumentException If the file does not exist or is not readable
     * @throws InvalidArgumentException If the JSON is invalid or cannot be decoded
     * @throws InvalidArgumentException If the decoded JSON is not an array
     *
     * @example
     * // Example JSON translation file (en.json):
     * {
     *     "welcome": "Welcome",
     *     "user": {
     *         "name": "Name",
     *         "email": "Email"
     *     }
     * }
     *
     * $loader = new JsonTranslationLoader('/path/to/translations/en.json');
     */
    public function __construct(
        private readonly string $filepath,
        private readonly int    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    )
    {
    }

    public function __invoke(): array
    {
        $flags = JSON_THROW_ON_ERROR | $this->flags;

        return $this->load($this->filepath, function (string $path) use ($flags) {
            $content = file_get_contents($path);

            if ($content === false) {
                throw new InvalidArgumentException(sprintf('Unable to read file "%s".', $path));
            }

            try {
                return json_decode($content, true, 512, $flags) ?? [];
            } catch (Throwable $exception) {
                throw new InvalidArgumentException(sprintf('Invalid JSON in file "%s": %s.', $path, $exception->getMessage()), 0, $exception);
            }
        })();
    }
}