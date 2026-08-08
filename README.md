# KetPHP Translator

![Packagist Version](https://img.shields.io/packagist/v/ket-php/translator)
![Packagist Downloads](https://img.shields.io/packagist/dt/ket-php/translator?logo=packagist&logoColor=white)
![Static Badge](https://img.shields.io/badge/PHP-8.1-777BB4?logo=php&logoColor=white)

A flexible and powerful translation library for PHP applications that supports multiple translation formats, locale fallbacks, and various placeholder replacement methods.  

## Features
- **Multiple Loader Support** - Use different loaders for various translation file formats
- **Locale Fallback** - Automatic fallback to default locale when translations are missing
- **Dot Notation** - Access nested translation keys using dot notation
- **Error Resilient** - Graceful handling of missing translations and formatting errors
- **Support** - Array, PHP File, INI File, JSON File, XML File 

## Installation
```composer
composer require ket-php/translator
```

## Usage

### Initialize the Translator

```php
use KetPHP\Translator\Loader\JsonTranslationLoader;
use KetPHP\Translator\Loader\PhpTranslationLoader;
use KetPHP\Translator\Loader\ArrayTranslationLoader;
use KetPHP\Translator\Translator;
use KetPHP\Translator\Locale;

$translator = new Translator(
    localeDefault: 'en', // another use \KetPHP\Translator\Locale::ENGLISH - en
    locale: 'be', // current locale (optional, uses localeDefault if null)
    translationFallback: TranslationFallback::class // current fallback handler (optional)
);

// Add translations with loader
$translator->addLoader(Locale::ENGLISH, new PhpTranslationLoader('/absolute/path/to/en.php'));
// Combine loaders (locale pages)
$translator->addLoader(Locale::BELARUSIAN, new JsonTranslationLoader('/absolute/path/to/be.json'));
$translator->addLoader(Locale::BELARUSIAN, new PhpTranslationLoader('/absolute/path/to/be.php'));

$translation = [
    'language_tag' => 'fr-FR',
];

// Add translations with loader
$translator->addLoader(Locale::FRENCH, new ArrayTranslationLoader($translation));
// Add translations with resource
$translator->addResource(Locale::FRENCH, $translation); // contained ArrayTranslationLoader

$allTranslations = $translator->translations();
// Returns merged array of current locale + default locale translations
```

### Add Fallback

Use `TranslationFallbackInteface`:

```php
use KetPHP\Translator\Common\TranslationFallbackInterface;

final class YourTranslationFallback implements TranslationFallbackInterface
{

    public function __invoke(string $key, string $locale): string
    {
        return $key;
    }
}
```

### Add Translation Loaders

Use `TranslationLoaderInterface`:
```php
use KetPHP\Translator\Common\TranslationLoaderInterface;

final class YourTranslationLoader implements TranslationLoaderInterface
{

    public function __invoke(): array
    {
        $data = [];
        // Your realization...
        return $data;
    }
}
```

### Create Translation Files
Example: en.php
```php
<?php return [
    'language_tag' => 'en-US',
    'user' => [
        'profile' => [
            'greeting' => 'Welcome, {name}!',
            'welcome_back' => 'Welcome back, {name}!',
            'messages' => 'You have {count} new messages'
        ]
    ],
    'errors' => [
        'not_found' => 'The requested resource was not found'
    ]
];
```
Example: be.json
```json
{
  "language_tag": "be-BY",
  "user": {
    "profile": {
      "greeting": "Прывітанне, {name}!",
      "messages": "У вас {count} новых паведамленняў"
    }
  }
}
```

### Using the Translator
```php
// Basic Translation
echo $translator->translate('welcome');
// Output: "Welcome to the application!" (if locale is 'en')

// With Dot Notation
echo $translator->translate('user.profile.greeting', default: 'Welcome!');
// Output: "Welcome, {name}!" (fallback to key if no default provided)

// Named Placeholders
echo $translator->translate('user.profile.greeting', ['name' => 'John'], 'Welcome!');
// Output: "Welcome, John!"

echo $translator->translate('user.profile.messages', ['count' => 5]);
// Output: "You have 5 new messages"

// Non-existent key with default value
echo $translator->translate('nonexistent.key', default: 'Default value');
// Output: "Default value"

// Non-existent key without default
echo $translator->translate('another.missing.key');
// Output: "another.missing.key" (returns the key itself)
```
