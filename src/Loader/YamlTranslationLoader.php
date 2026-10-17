<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use KetPHP\Translator\Exception\IOException;
use KetPHP\Translator\Exception\LoaderParseException;
use KetPHP\Translator\Exception\LoaderUnavailableException;

/**
 * Translation loader that loads translation data from YAML files
 *
 * This loader extends the **FileTranslationLoader** to load translation arrays from YAML files.
 * YAML files support nested structures natively.
 *
 * @package KetPHP\Translator\Loader
 */
final class YamlTranslationLoader extends FileTranslationLoader
{

    /**
     * Creates a new YamlTranslationLoader instance
     *
     * Loads and parses a YAML file containing translation data.
     * The YAML file must exist and be a valid YAML structure.
     *
     * Require PHP extension - `php_yaml`
     *
     * @param string $filepath Path to the YAML file containing translation data
     *
     * @throws LoaderUnavailableException If the yaml_parse_file function is disabled or not installed
     * @throws LoaderParseException If the YAML file is invalid or cannot be parsed
     * @throws IOException If the file does not exist or is not readable
     *
     * @example
     *      // Example YAML translation file (en.yaml):
     *      welcome: "Welcome"
     *      user:
     *          name: "Name"
     *          email: "Email"
     *
     *      $loader = new YamlTranslationLoader('/path/to/translations/en.yaml');
     */
    public function __construct(private readonly string $filepath)
    {
    }

    public function __invoke(): array
    {
        return $this->load($this->filepath, function (string $path): array {
            if (function_exists('yaml_parse_file') === false) {
                throw new LoaderUnavailableException('The "yaml_parse_file" function is disabled or the YAML extension is not available in this PHP environment.');
            }

            $data = @yaml_parse_file($path);

            if ($data === false) {
                throw new LoaderParseException(sprintf('Failed to parse YAML file: "%s"', $path));
            }

            if (is_array($data) === false) {
                return [];
            }
            return $data;
        })();
    }
}