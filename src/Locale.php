<?php

declare(strict_types=1);

namespace KetPHP\Translator;

use ReflectionClass;

/**
 * Contains ISO 639-1 two-letter language codes.
 */
class Locale
{

    /** @var string Afrikaans */
    public const AFRIKAANS = 'af';

    /** @var string Albanian */
    public const ALBANIAN = 'sq';

    /** @var string Amharic */
    public const AMHARIC = 'am';

    /** @var string Arabic */
    public const ARABIC = 'ar';

    /** @var string Armenian */
    public const ARMENIAN = 'hy';

    /** @var string Azerbaijani */
    public const AZERBAIJANI = 'az';

    /** @var string Basque */
    public const BASQUE = 'eu';

    /** @var string Belarusian */
    public const BELARUSIAN = 'be';

    /** @var string Bengali */
    public const BENGALI = 'bn';

    /** @var string Bosnian */
    public const BOSNIAN = 'bs';

    /** @var string Bulgarian */
    public const BULGARIAN = 'bg';

    /** @var string Catalan */
    public const CATALAN = 'ca';

    /** @var string Chechen */
    public const CHECHEN = 'ce';

    /** @var string Chinese */
    public const CHINESE = 'zh';

    /** @var string Croatian */
    public const CROATIAN = 'hr';

    /** @var string Czech */
    public const CZECH = 'cs';

    /** @var string Danish */
    public const DANISH = 'da';

    /** @var string Dutch */
    public const DUTCH = 'nl';

    /** @var string English */
    public const ENGLISH = 'en';

    /** @var string Esperanto */
    public const ESPERANTO = 'eo';

    /** @var string Estonian */
    public const ESTONIAN = 'et';

    /** @var string Finnish */
    public const FINNISH = 'fi';

    /** @var string French */
    public const FRENCH = 'fr';

    /** @var string Galician */
    public const GALICIAN = 'gl';

    /** @var string Georgian */
    public const GEORGIAN = 'ka';

    /** @var string German */
    public const GERMAN = 'de';

    /** @var string Greek */
    public const GREEK = 'el';

    /** @var string Gujarati */
    public const GUJARATI = 'gu';

    /** @var string Hebrew */
    public const HEBREW = 'he';

    /** @var string Hindi */
    public const HINDI = 'hi';

    /** @var string Hungarian */
    public const HUNGARIAN = 'hu';

    /** @var string Icelandic */
    public const ICELANDIC = 'is';

    /** @var string Indonesian */
    public const INDONESIAN = 'id';

    /** @var string Irish */
    public const IRISH = 'ga';

    /** @var string Italian */
    public const ITALIAN = 'it';

    /** @var string Japanese */
    public const JAPANESE = 'ja';

    /** @var string Javanese */
    public const JAVANESE = 'jv';

    /** @var string Kannada */
    public const KANNADA = 'kn';

    /** @var string Kazakh */
    public const KAZAKH = 'kk';

    /** @var string Khmer */
    public const KHMER = 'km';

    /** @var string Korean */
    public const KOREAN = 'ko';

    /** @var string Kurdish */
    public const KURDISH = 'ku';

    /** @var string Kyrgyz */
    public const KYRGYZ = 'ky';

    /** @var string Lao */
    public const LAO = 'lo';

    /** @var string Latvian */
    public const LATVIAN = 'lv';

    /** @var string Lithuanian */
    public const LITHUANIAN = 'lt';

    /** @var string Luxembourgish */
    public const LUXEMBOURGISH = 'lb';

    /** @var string Macedonian */
    public const MACEDONIAN = 'mk';

    /** @var string Malagasy */
    public const MALAGASY = 'mg';

    /** @var string Malay */
    public const MALAY = 'ms';

    /** @var string Malayalam */
    public const MALAYALAM = 'ml';

    /** @var string Maltese */
    public const MALTESE = 'mt';

    /** @var string Maori */
    public const MAORI = 'mi';

    /** @var string Marathi */
    public const MARATHI = 'mr';

    /** @var string Mongolian */
    public const MONGOLIAN = 'mn';

    /** @var string Nepali */
    public const NEPALI = 'ne';

    /** @var string Norwegian */
    public const NORWEGIAN = 'no';

    /** @var string Oriya */
    public const ORIYA = 'or';

    /** @var string Pashto */
    public const PASHTO = 'ps';

    /** @var string Persian */
    public const PERSIAN = 'fa';

    /** @var string Polish */
    public const POLISH = 'pl';

    /** @var string Portuguese */
    public const PORTUGUESE = 'pt';

    /** @var string Punjabi */
    public const PUNJABI = 'pa';

    /** @var string Romanian */
    public const ROMANIAN = 'ro';

    /** @var string Russian */
    public const RUSSIAN = 'ru';

    /** @var string Samoan */
    public const SAMOAN = 'sm';

    /** @var string Serbian */
    public const SERBIAN = 'sr';

    /** @var string Scottish Gaelic */
    public const SCOTTISH_GAELIC = 'gd';

    /** @var string Shona */
    public const SHONA = 'sn';

    /** @var string Sindhi */
    public const SINDHI = 'sd';

    /** @var string Sinhala */
    public const SINHALA = 'si';

    /** @var string Slovak */
    public const SLOVAK = 'sk';

    /** @var string Slovenian */
    public const SLOVENIAN = 'sl';

    /** @var string Somali */
    public const SOMALI = 'so';

    /** @var string Southern Sotho */
    public const SOUTHERN_SOTHO = 'st';

    /** @var string Spanish */
    public const SPANISH = 'es';

    /** @var string Sundanese */
    public const SUNDANESE = 'su';

    /** @var string Swahili */
    public const SWAHILI = 'sw';

    /** @var string Swedish */
    public const SWEDISH = 'sv';

    /** @var string Tagalog */
    public const TAGALOG = 'tl';

    /** @var string Tajik */
    public const TAJIK = 'tg';

    /** @var string Tamil */
    public const TAMIL = 'ta';

    /** @var string Tatar */
    public const TATAR = 'tt';

    /** @var string Telugu */
    public const TELUGU = 'te';

    /** @var string Thai */
    public const THAI = 'th';

    /** @var string Turkish */
    public const TURKISH = 'tr';

    /** @var string Turkmen */
    public const TURKMEN = 'tk';

    /** @var string Ukrainian */
    public const UKRAINIAN = 'uk';

    /** @var string Urdu */
    public const URDU = 'ur';

    /** @var string Uzbek */
    public const UZBEK = 'uz';

    /** @var string Vietnamese */
    public const VIETNAMESE = 'vi';

    /** @var string Welsh */
    public const WELSH = 'cy';

    /** @var string Xhosa */
    public const XHOSA = 'xh';

    /** @var string Yiddish */
    public const YIDDISH = 'yi';

    /** @var string Yoruba */
    public const YORUBA = 'yo';

    /** @var string Zulu */
    public const ZULU = 'zu';

    /** @var string Bashkir */
    public const BASHKIR = 'ba';

    /** @var string Hausa */
    public const HAUSA = 'ha';

    /** @var string Latin */
    public const LATIN = 'la';

    /** @var string Quechua */
    public const QUECHUA = 'qu';

    /** @var string Sanskrit */
    public const SANSKRIT = 'sa';

    /** @var string Tibetan */
    public const TIBETAN = 'bo';

    /**
     * Get all language constants as array.
     *
     * @return array<string, string> [LANGUAGE_NAME => code]
     */
    public static function all(): array
    {
        static $constants = null;

        if ($constants === null) {
            $constants = (new ReflectionClass(static::class))->getConstants();
        }

        return $constants;
    }
}
