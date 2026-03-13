<?php
class Session
{
    /**
     * Iniciar sesión si no está iniciada
     */
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Establecer un mensaje flash
     */
    public static function setFlash($type, $message)
    {
        self::init();
        $_SESSION['flash'] = [
            'type' => $type, // success, danger, warning, info
            'message' => $message
        ];
    }

    /**
     * Obtener y eliminar el mensaje flash
     */
    public static function getFlash()
    {
        self::init();
        if (isset($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
        return null;
    }

    /**
     * Verificar si hay mensaje flash
     */
    public static function hasFlash()
    {
        self::init();
        return isset($_SESSION['flash']);
    }

    /**
     * Generar token CSRF
     */
    public static function generateCsrf()
    {
        self::init();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Verificar token CSRF
     */
    public static function verifyCsrf($token)
    {
        self::init();
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Regenerar token CSRF (después de uso)
     */
    public static function regenerateCsrf()
    {
        self::init();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}