<?php

class Security
{
    public static function generateCSRFToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCSRFToken(string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function sanitize(string $value): string
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeArray(array $data): array
    {
        return array_map(function($item) {
            return is_array($item) ? self::sanitizeArray($item) : self::sanitize($item);
        }, $data);
    }

    public static function validateRequired(array $fields, array $data): array
    {
        $errors = [];
        foreach ($fields as $field) {
            if (!isset($data[$field]) || empty(trim($data[$field]))) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }
        return $errors;
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validatePhone(string $phone): bool
    {
        return preg_match('/^[0-9+\s\-()]{8,20}$/', $phone);
    }

    public static function validateInt(string $value, int $min = 0, int $max = null): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            return false;
        }
        $value = (int)$value;
        if ($value < $min) return false;
        if ($max !== null && $value > $max) return false;
        return true;
    }

    public static function getErrors(): array
    {
        return $_SESSION['form_errors'] ?? [];
    }

    public static function setErrors(array $errors): void
    {
        $_SESSION['form_errors'] = $errors;
    }

    public static function clearErrors(): void
    {
        unset($_SESSION['form_errors']);
    }

    public static function getOldInput(): array
    {
        return $_SESSION['old_input'] ?? [];
    }

    public static function setOldInput(array $data): void
    {
        $_SESSION['old_input'] = $data;
    }

    public static function clearOldInput(): void
    {
        unset($_SESSION['old_input']);
    }
}
