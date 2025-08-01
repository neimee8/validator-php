<?php

declare(strict_types = 1);

namespace Neimee8\ValidatorPhp\Validators;

use Neimee8\ValidatorPhp\Enums\NumType;

use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorHelper;
use Neimee8\ValidatorPhp\Validators\Helpers\ValidatorStringHelper;

final class ValidatorString {
    use ValidatorHelper, ValidatorStringHelper;

    private static function str_len(string $value, array $params): bool {
        return mb_strlen($value) === $params['size'];
    }

    private static function str_min_len(string $value, array $params): bool {
        return mb_strlen($value) >= $params['size'];
    }

    private static function str_max_len(string $value, array $params): bool {
        return mb_strlen($value) <= $params['size'];
    }

    private static function str_alphabetic(string $value, array $params): bool {
        return self::strRegex($value, '/^\p{L}+$/u');
    }

    private static function str_alphanumeric(string $value, array $params): bool {
        return self::strRegex($value, '/^[\p{L}\p{N}]+$/u');
    }

    private static function str_contains_special(string $value, array $params): bool {
        return self::strRegex($value, '/[^\p{L}\p{N}]/u');
    }

    private static function str_json(string $value, array $params): bool {
        $decoded = json_decode($value, associative: true);

        return json_last_error() === JSON_ERROR_NONE;
    }

    private static function str_email(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_EMAIL);
    }

    private static function str_url(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_URL);
    }

    private static function str_ip(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_IP);
    }

    private static function str_ipv4(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    private static function str_ipv6(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }

    private static function str_base64(string $value, array $params): bool {
        $decoded = base64_decode($value, strict: true);

        return strlen($value) % 4 === 0 && $decoded !== false;
    }

    private static function str_lowercase(string $value, array $params): bool {
        return $value === mb_strtolower($value);
    }

    private static function str_uppercase(string $value, array $params): bool {
        return $value === mb_strtoupper($value);
    }

    private static function str_ascii(string $value, array $params): bool {
        return mb_check_encoding($value, 'ASCII');
    }

    private static function str_utf8(string $value, array $params): bool {
        return mb_check_encoding($value, 'UTF-8');
    }

    private static function str_contains_html(string $value, array $params): bool {
        return $value !== strip_tags($value);
    }

    private static function str_regex(string $value, array $params): bool {
        set_error_handler(function() {}, E_WARNING);
        $regex_check = @preg_match($value, '');
        restore_error_handler();

        return $regex_check !== false;
    }

    private static function str_class_string(string $value, array $params): bool {
        return class_exists($value)
            || interface_exists($value)
            || trait_exists($value);
    }

    private static function str_int(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_INT);
    }

    private static function str_float(string $value, array $params): bool {
        return self::strFilter($value, FILTER_VALIDATE_FLOAT) && str_contains($value, '.');
    }

    private static function str_numeric(string $value, array $params): bool {
        return is_numeric(trim($value));
    }

    private static function str_int_positive(string $value, array $params): bool {
        return self::strNum($value, NumType::INT, rule: 'positive');
    }

    private static function str_int_negative(string $value, array $params): bool {
        return self::strNum($value, NumType::INT, rule: 'negative');
    }

    private static function str_int_positive_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::INT, rule: 'positive_zero');
    }

    private static function str_int_negative_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::INT, rule: 'negative_zero');
    }

    private static function str_float_positive(string $value, array $params): bool {
        return self::strNum($value, NumType::FLOAT, rule: 'positive');
    }

    private static function str_float_negative(string $value, array $params): bool {
        return self::strNum($value, NumType::FLOAT, rule: 'negative');
    }

    private static function str_float_positive_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::FLOAT, rule: 'positive_zero');
    }

    private static function str_float_negative_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::FLOAT, rule: 'negative_zero');
    }

    private static function str_numeric_positive(string $value, array $params): bool {
        return self::strNum($value, NumType::NUMERIC, rule: 'positive');
    }

    private static function str_numeric_negative(string $value, array $params): bool {
        return self::strNum($value, NumType::NUMERIC, rule: 'negative');
    }

    private static function str_numeric_positive_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::NUMERIC, rule: 'positive_zero');
    }

    private static function str_numeric_negative_zero(string $value, array $params): bool {
        return self::strNum($value, NumType::NUMERIC, rule: 'negative_zero');
    }

    private static function str_contains(string $value, array $params): bool {
        return mb_strpos($value, $params['needle'], 0, 'UTF-8') !== false;
    }

    private static function str_regex_match(string $value, array $params): bool {
        return self::strRegex($value, $params['pattern']);
    }
}
