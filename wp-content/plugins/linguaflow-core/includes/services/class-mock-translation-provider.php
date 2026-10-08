<?php
/**
 * Mock Translation Provider
 * Provides realistic offline translation responses and phrase fallbacks.
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Mock_Translation_Provider implements LinguaFlow_Translation_Provider_Interface {

    private static $dictionary = array(
        'en_to_fr' => array(
            'hello' => 'Bonjour',
            'where is the nearest train station?' => 'Où est la gare la plus proche ?',
            'how are you?' => 'Comment allez-vous ?',
            'can i see the menu?' => 'Puis-je voir le menu ?',
            'do you have vegetarian food?' => 'Avez-vous des plats végétariens ?',
            'how much does this cost?' => 'Combien cela me coûte-t-il ?',
            'thank you very much' => 'Merci beaucoup',
            'i am going to the train station.' => 'Je vais à la gare.',
            'hello, where are you going?' => 'Bonjour, où allez-vous ?',
        ),
        'en_to_es' => array(
            'hello' => 'Hola',
            'where is the nearest train station?' => '¿Dónde está la estación de tren más cercana?',
            'how are you?' => '¿Cómo estás?',
            'can i see the menu?' => '¿Puedo ver el menú?',
            'thank you very much' => 'Muchas gracias',
        ),
        'en_to_de' => array(
            'hello' => 'Hallo',
            'where is the nearest train station?' => 'Wo ist der nächste Bahnhof?',
            'how are you?' => 'Wie geht es Ihnen?',
            'thank you very much' => 'Vielen Dank',
        ),
        'en_to_it' => array(
            'hello' => 'Ciao',
            'where is the nearest train station?' => 'Dov\'è la stazione ferroviaria più vicina?',
            'thank you very much' => 'Grazie mille',
        ),
        'en_to_ar' => array(
            'hello' => 'مرحباً',
            'how are you?' => 'كيف حالك؟',
            'hello, how are you?' => 'مرحباً، كيف حالك؟',
            'good morning' => 'صباح الخير',
            'where is the nearest hotel?' => 'أين أقرب فندق؟',
            'where is the nearest train station?' => 'أين أقرب محطة قطار؟',
            'where is the airport?' => 'أين المطار؟',
            'where is the hospital?' => 'أين المستشفى؟',
            'i need help.' => 'أنا بحاجة إلى المساعدة.',
            'thank you very much' => 'شكراً جزيلاً',
        ),
        'en_to_hi' => array(
            'hello' => 'नमस्ते',
            'how are you?' => 'आप कैसे हैं?',
            'hello, how are you?' => 'नमस्ते, आप कैसे हैं?',
            'good morning' => 'शुभ प्रभात',
            'where is the nearest hotel?' => 'सबसे पास का होटल कहाँ है?',
            'where is the nearest train station?' => 'निकटतम रेलवे स्टेशन कहाँ है?',
            'where is the hospital?' => 'अस्पताल कहाँ है?',
            'i need help.' => 'मुझे मदद चाहिए।',
            'thank you very much' => 'बहुत बहुत धन्यवाद',
        ),
        'en_to_kn' => array(
            'hello' => 'ನಮಸ್ಕಾರ',
            'how are you?' => 'ನೀವು ಹೇಗಿದ್ದೀರಿ?',
            'hello, how are you?' => 'ನಮಸ್ಕಾರ, ನೀವು ಹೇಗಿದ್ದೀರಿ?',
            'good morning' => 'ಶುಭೋದಯ',
            'where is the nearest hotel?' => 'ಹತ್ತಿರದ ಹೋಟೆಲ್ ಎಲ್ಲಿದೆ?',
            'where is the nearest train station?' => 'ಹತ್ತಿರದ ರೈಲು ನಿಲ್ದಾಣ ಎಲ್ಲಿದೆ?',
            'where is the hospital?' => 'ಆಸ್ಪತ್ರೆ ಎಲ್ಲಿದೆ?',
            'i need help.' => 'ನನಗೆ ಸಹಾಯ ಬೇಕು.',
            'thank you very much' => 'ತುಂಬಾ ಧನ್ಯವಾದಗಳು',
        ),
        'en_to_ml' => array(
            'hello' => 'നമസ്കാരം',
            'how are you?' => 'സുഖമാണോ?',
            'hello, how are you?' => 'നമസ്കാരം, സുഖമാണോ?',
            'good morning' => 'സുപ്രഭാതം',
            'where is the nearest hotel?' => 'ഏറ്റവും അടുത്തുള്ള ഹോട്ടൽ എവിടെയാണ്?',
            'where is the nearest train station?' => 'അടുത്തുള്ള റെയിൽവേ സ്റ്റേഷൻ എവിടെയാണ്?',
            'where is the hospital?' => 'ആശുപത്രി എവിടെയാണ്?',
            'i need help.' => 'എനിക്ക് സഹായം വേണം.',
            'thank you very much' => 'വളരെ നന്ദി',
        )
    );

    public function translate($text, $source_lang, $target_lang) {
        $text_trimmed = trim($text);
        if (empty($text_trimmed)) {
            return array(
                'status' => 'success',
                'source_text' => '',
                'translated_text' => '',
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'provider' => 'mock'
            );
        }

        $text_lower = strtolower($text_trimmed);
        $pair_key = strtolower($source_lang) . '_to_' . strtolower($target_lang);

        // 1. Check local offline dictionary first
        if (isset(self::$dictionary[$pair_key][$text_lower])) {
            return array(
                'status' => 'success',
                'source_text' => $text,
                'translated_text' => self::$dictionary[$pair_key][$text_lower],
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'provider' => 'dictionary'
            );
        }

        // If source and target language are the same, return as is
        if (strtolower($source_lang) === strtolower($target_lang)) {
            return array(
                'status' => 'success',
                'source_text' => $text,
                'translated_text' => $text,
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'provider' => 'identity'
            );
        }

        // 2. Query MyMemory Free Translation API for real dynamic translations
        $url = sprintf(
            'https://api.mymemory.translated.net/get?q=%s&langpair=%s|%s',
            urlencode($text_trimmed),
            strtolower($source_lang),
            strtolower($target_lang)
        );

        $context = stream_context_create(array(
            'http' => array(
                'timeout' => 3.0, // 3 second timeout
                'header'  => "User-Agent: LinguaFlow/1.0\r\n"
            )
        ));

        $response_json = @file_get_contents($url, false, $context);
        if ($response_json !== false) {
            $data = json_decode($response_json, true);
            if (!empty($data['responseData']['translatedText'])) {
                $translated_text = $data['responseData']['translatedText'];
                // Clean up any HTML entities if returned
                $translated_text = html_entity_decode($translated_text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                return array(
                    'status' => 'success',
                    'source_text' => $text,
                    'translated_text' => $translated_text,
                    'source_lang' => $source_lang,
                    'target_lang' => $target_lang,
                    'provider' => 'mymemory'
                );
            }
        }

        // 3. Fallback Smart Word-by-Word Replacement for offline mode
        $word_map = array(
            'fr' => array('hello' => 'bonjour', 'where' => 'où', 'is' => 'est', 'the' => 'le', 'station' => 'gare', 'hotel' => 'hôtel', 'food' => 'nourriture', 'good' => 'bon', 'morning' => 'matin', 'night' => 'nuit', 'yes' => 'oui', 'no' => 'non', 'please' => 's\'il vous plaît', 'thank' => 'merci', 'you' => 'vous', 'water' => 'eau', 'help' => 'aide'),
            'es' => array('hello' => 'hola', 'where' => 'dónde', 'is' => 'está', 'the' => 'el', 'station' => 'estación', 'hotel' => 'hotel', 'food' => 'comida', 'good' => 'bueno', 'morning' => 'días', 'night' => 'noche', 'yes' => 'sí', 'no' => 'no', 'please' => 'por favor', 'thank' => 'gracias', 'you' => 'usted', 'water' => 'agua', 'help' => 'ayuda'),
            'de' => array('hello' => 'hallo', 'where' => 'wo', 'is' => 'ist', 'the' => 'der', 'station' => 'bahnhof', 'hotel' => 'hotel', 'food' => 'essen', 'good' => 'gut', 'morning' => 'morgen', 'night' => 'nacht', 'yes' => 'ja', 'no' => 'nein', 'please' => 'bitte', 'thank' => 'danke', 'you' => 'sie', 'water' => 'wasser', 'help' => 'hilfe')
        );

        $target = strtolower($target_lang);
        if (isset($word_map[$target])) {
            $words = explode(' ', $text_lower);
            $translated_words = array();
            foreach ($words as $w) {
                $clean_w = preg_replace('/[^\w]/', '', $w);
                if (isset($word_map[$target][$clean_w])) {
                    $translated_words[] = $word_map[$target][$clean_w];
                } else {
                    $translated_words[] = $w;
                }
            }
            $translated = implode(' ', $translated_words);
            $translated = ucfirst($translated);
        } else {
            $prefixes = array('fr' => '[FR]', 'es' => '[ES]', 'de' => '[DE]', 'it' => '[IT]', 'ja' => '[JA]', 'zh' => '[ZH]', 'pt' => '[PT]', 'ru' => '[RU]', 'ar' => '[AR]');
            $prefix = $prefixes[$target] ?? '[' . strtoupper($target) . ']';
            $translated = $prefix . ' ' . $text_trimmed;
        }

        return array(
            'status' => 'success',
            'source_text' => $text,
            'translated_text' => $translated,
            'source_lang' => $source_lang,
            'target_lang' => $target_lang,
            'provider' => 'fallback'
        );
    }
}
