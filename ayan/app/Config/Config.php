<?php

namespace App\Config;

class Config {
    private static $settings = [];

    public static function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new \Exception("Environment file not found: {$filePath}");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            [$key, $value] = explode('=', $line, 2);
            self::$settings[trim($key)] = trim($value);
            putenv(trim($key) . '=' . trim($value));
        }
    }

    public static function get($key, $default = null) {
        $envValue = getenv($key);
        if ($envValue !== false) {
            return $envValue;
        }

        return self::$settings[$key] ?? $default;
    }
}
