<?php

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Enums\NumType;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidationInvoker;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorInterface;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorStringHelper;

class ValidatorString implements ValidatorInterface {
    use ValidationInvoker, ValidatorStringHelper;

    private static function str_len(string $value, array $params): bool {
        $reference = $params[0]; // non negative int

        return mb_strlen($value) === $reference;
    }

    private static function str_min_len(string $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return mb_strlen($value) >= $threshold;
    }

    private static function str_max_len(string $value, array $params): bool {
        $threshold = $params[0]; // non negative int

        return mb_strlen($value) <= $threshold;
    }

    private static function str_numeric(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === is_numeric(trim($value));
    }

    private static function str_alphabetic(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strRegex($value, '/^[\p{L}]+$/u');
    }

    private static function str_contains_special(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strRegex($value, '/[^\p{L}\p{N}]/u');
    }

    private static function str_json(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        $decoded = json_decode($value, associative: true);
        $decoded_successfully = json_last_error() === JSON_ERROR_NONE;

        return $must_be === $decoded_successfully;
    }

    private static function str_email(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_EMAIL);
    }

    private static function str_url(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_URL);
    }

    private static function str_ip(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_IP);
    }

    private static function str_ipv4(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    private static function str_ipv6(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    private static function str_base64(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        $decoded = base64_decode($value, strict: true);

        return $must_be === ($decoded !== false && strlen($value) % 4 === 0);
    }

    private static function str_lowercase(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value === mb_strtolower($value));
    }

    private static function str_uppercase(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value === mb_strtoupper($value));
    }

    private static function str_ascii(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === mb_check_encoding($value, 'ASCII');
    }

    private static function str_utf8(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === mb_check_encoding($value, 'UTF-8');
    }

    private static function str_contains_html(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === ($value === strip_tags($value));
    }

    private static function str_is_regex(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        set_error_handler(function() {}, E_WARNING);
        $regex_check = @preg_match($value, '');
        restore_error_handler();

        return $must_be === ($regex_check !== false);
    }

    private static function str_is_class_string(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strRegex($value, '/^\\\\?([A-Za-z_][A-Za-z0-9_]*\\\\)*[A-Za-z_][A-Za-z0-9_]*$/');
    }

    private static function str_int(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_INT);
    }

    private static function str_float(string $value, array $params): bool {
        $must_be = $params[0]; // true or false

        return $must_be === self::strFilter($value, FILTER_VALIDATE_FLOAT);
    }

    private static function str_int_positive(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::INT, rule: 'positive');
    }

    private static function str_int_negative(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::INT, rule: 'negative');
    }

    private static function str_int_positive_zero(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::INT, rule: 'positive_zero');
    }

    private static function str_int_negative_zero(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::INT, rule: 'negative_zero');
    }

    private static function str_float_positive(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::FLOAT, rule: 'positive');
    }

    private static function str_float_negative(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::FLOAT, rule: 'negative');
    }

    private static function str_float_positive_zero(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::FLOAT, rule: 'positive_zero');
    }

    private static function str_float_negative_zero(string $value, array $params): bool {
        $must_be = $params[0]; // true or false
        
        return $must_be === self::strNum($value, NumType::FLOAT, rule: 'negative_zero');
    }

    private static function str_contains(string $value, array $params): bool {
        $needle = $params[0]; // substring

        return mb_strpos($value, $needle, 0, 'UTF-8') !== false;
    }

    private static function str_not_contains(string $value, array $params): bool {
        return !self::str_contains($value, $params);
    }

    private static function str_regex_match(string $value, array $params): bool {
        $pattern = $params[0]; // regex

        return self::strRegex($value, $pattern);
    }

    private static function str_not_regex_match(string $value, array $params): bool {
        return !self::str_regex_match($value, $params);
    }
}
