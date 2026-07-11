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
    locale: 'ru' // current locale (optional, uses localeDefault if null)
);

// Add translations with loader
$translator->addLoader(Locale::ENGLISH, new PhpTranslationLoader('/absolute/path/to/en.php'));
// Combine loaders (locale pages)
$translator->addLoader(Locale::RUSSIAN, new JsonTranslationLoader('/absolute/path/to/ru.json'));
$translator->addLoader(Locale::RUSSIAN, new PhpTranslationLoader('/absolute/path/to/ru.php'));

$translation = [
    'language_tag' => 'be-BY',
];

// Add translations with loader
$translator->addLoader(Locale::BELARUSIAN, new ArrayTranslationLoader($translation));
// Add translations with resource
$translator->addResource(Locale::BELARUSIAN, $translation);

$allTranslations = $translator->translations();
// Returns merged array of current locale + default locale translations
```

### Add Translation Loaders
Use `ArrayTranslationLoader`:
```php
use KetPHP\Translator\Loader\ArrayTranslationLoader;

final class YourTranslationLoader extends ArrayTranslationLoader
{

    public function __construct()
    {
        $data = [];
        // Your realization...
        parent::__construct($data);
    }
}
```

Use `FileTranslationLoader`:
```php
use KetPHP\Translator\Loader\FileTranslationLoader;

final class YourTranslationLoader extends FileTranslationLoader
{

    public function __construct(private readonly string $filepath)
    {
    }

    public function __invoke(): array
    {
        return $this->load($this->filepath, function (string $path): array {
            $data = [];
            // Your realization...
            return $data;
        })();
    }
}
```

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
Example: ru.json
```json
{
  "language_tag": "ru-RU",
  "user": {
    "profile": {
      "greeting": "Добро пожаловать, {name}!",
      "welcome_back": "С возвращением, {name}!",
      "messages": "У вас {count} новых сообщений"
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
echo $translator->translate('user.profile.greeting', ['name' => 'John'] ,'Welcome!');
// Output: "Welcome, John!"

echo $translator->translate('user.profile.messages', ['count' => 5]);
// Output: "You have 5 new messages"

// Key exists only in default locale (en)
echo $translator->translate('errors.not_found');
// Output: "The requested resource was not found" (falls back to English)

// Non-existent key with default value
echo $translator->translate('nonexistent.key', default: 'Default value');
// Output: "Default value"

// Non-existent key without default
echo $translator->translate('another.missing.key');
// Output: "another.missing.key" (returns the key itself)
```
