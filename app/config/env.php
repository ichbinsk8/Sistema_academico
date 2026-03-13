<?php
class Env
{
    private static $vars = [];

    public static function load($file)
    {
        if (!file_exists($file)) {
            die("Archivo .env no encontrado: $file");
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            self::$vars[$name] = $value;
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }

    public static function get($key, $default = null)
    {
        return self::$vars[$key] ?? getenv($key) ?? $_ENV[$key] ?? $default;
    }

    public static function isDevelopment()
    {
        return self::get('APP_ENV') === 'development';
    }

    public static function isDebug()
    {
        return self::get('APP_DEBUG') === 'true';
    }
}