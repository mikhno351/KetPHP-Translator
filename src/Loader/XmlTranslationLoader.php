<?php

declare(strict_types=1);

namespace KetPHP\Translator\Loader;

use InvalidArgumentException;
use SimpleXMLElement;
use Throwable;

/**
 * Translation loader that loads translation data from XML files.
 *
 * XML files must contain a "translations" root element with "translation"
 * elements. Each translation must have a unique "key" attribute.
 *
 * @package KetPHP\Translator\Loader
 */
final class XmlTranslationLoader extends FileTranslationLoader
{

    /**
     * Creates a new XmlTranslationLoader instance.
     *
     * @param string $filepath Path to the XML file containing translation data
     *
     * @throws InvalidArgumentException If the XML file does not exist,
     *                                  is not readable, or contains invalid
     *                                  translation data.
     *
     * @example
     * // Example XML translation file (en.xml):
     * <?xml version="1.0" encoding="UTF-8"?>
     * <translations>
     *     <translation key="welcome">Welcome</translation>
     *     <translation key="user.name">Name</translation>
     *     <translation key="user.email">Email</translation>
     * </translations>
     *
     * $loader = new XmlTranslationLoader('/path/to/translations/en.xml');
     */
    public function __construct(private readonly string $filepath)
    {
    }

    public function __invoke(): array
    {
        return $this->load($this->filepath, function (string $path): array {
            if (class_exists(SimpleXMLElement::class) === false) {
                throw new InvalidArgumentException('The "SimpleXML" extension is disabled or not available in this PHP environment.');
            }

            $filename = basename($path);
            $content = file_get_contents($path);

            if ($content === false) {
                throw new InvalidArgumentException(sprintf('Unable to read file "%s".', $filename));
            }

            try {
                $xml = new SimpleXMLElement($content);
            } catch (Throwable $exception) {
                throw new InvalidArgumentException(sprintf('Invalid XML in file "%s": %s.', $filename, $exception->getMessage()), 0, $exception);
            }

            if ($xml->getName() !== 'translations') {
                throw new InvalidArgumentException(sprintf('Invalid root element in file "%s". Expected "translations", got "%s".', $filename, $xml->getName()));
            }

            $translations = [];

            foreach ($xml->children() as $translation) {
                if ($translation->getName() !== 'translation') {
                    throw new InvalidArgumentException(sprintf('Invalid element "%s" in file "%s". Expected "translation".', $translation->getName(), $filename));
                }

                $key = (string)$translation['key'];

                if (empty($key) === true) {
                    throw new InvalidArgumentException(sprintf('Translation key cannot be empty in file "%s".', $filename));
                }
                if (array_key_exists($key, $translations) === true) {
                    throw new InvalidArgumentException(sprintf('Duplicate translation key "%s" in file "%s".', $key, $filename));
                }
                if ($translation->count() > 0) {
                    throw new InvalidArgumentException(sprintf('Translation "%s" in file "%s" cannot contain child elements.', $key, $filename));
                }

                $translations[$key] = (string)$translation;
            }
            return $translations;
        })();
    }
}