<?php
class Logger
{
    // Niveles de log
    const LEVELS = [
        'INFO'     => 'INFO',
        'WARNING'  => 'WARNING',
        'ERROR'    => 'ERROR',
        'DEBUG'    => 'DEBUG',
        '404'      => '404',
        '500'      => '500'
    ];

    // Archivo de log por defecto
    private static $logFile = __DIR__ . '/../../storage/logs/app.log';

    /**
     * Método principal para escribir logs
     */
    private static function write($level, $message, $file = null)
    {
        $logFile = $file ?? self::$logFile;
        
        // Crear directorio si no existe
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $line = "[$date][$ip][$level] $message" . PHP_EOL;

        file_put_contents($logFile, $line, FILE_APPEND);
    }

    /**
     * Log de información (eventos normales)
     */
    public static function info($message)
    {
        self::write(self::LEVELS['INFO'], $message);
    }

    /**
     * Log de advertencia
     */
    public static function warning($message)
    {
        self::write(self::LEVELS['WARNING'], $message);
    }

    /**
     * Log de error
     */
    public static function error($message)
    {
        self::write(self::LEVELS['ERROR'], $message);
    }

    /**
     * Log de debug (solo en desarrollo)
     */
    public static function debug($message)
    {
        if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
            self::write(self::LEVELS['DEBUG'], $message);
        }
    }

    /**
     * Error 404 - Recurso no encontrado
     */
    public static function notFound($message = 'Recurso no encontrado')
    {
        self::write(self::LEVELS['404'], $message);
        
        http_response_code(404);
        $errorMessage = $message;
        require __DIR__ . '/../views/errors/404.php';
        exit;
    }

    /**
     * Error 500 - Error interno del servidor
     */
    public static function serverError($message = 'Error interno del servidor')
    {
        self::write(self::LEVELS['500'], $message);
        
        http_response_code(500);
        $errorMessage = 'Ha ocurrido un error inesperado';
        require __DIR__ . '/../views/errors/500.php';
        exit;
    }

    /**
     * Manejar excepciones no capturadas
     */
    public static function handleException(Throwable $e)
    {
        self::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
        self::serverError($e->getMessage());
    }

    /**
     * Registrar errores de PHP
     */
    public static function handleError($errno, $errstr, $errfile, $errline)
    {
        self::error("PHP Error [$errno]: $errstr in $errfile:$errline");
        return false; // Permite que el manejador interno de PHP también procese el error
    }
}
