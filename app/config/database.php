<?php
require_once __DIR__ . '/env.php';
Env::load(__DIR__ . '/../../.env');

class Database
{
    public static function connect()
    {
        try {
            $host = Env::get('DB_HOST');
            $dbname = Env::get('DB_NAME');
            $user = Env::get('DB_USER');
            $pass = Env::get('DB_PASS');

            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            return $pdo;
            
        } catch (PDOException $e) {
            if (Env::isDebug()) {
                die('Error de conexión: ' . $e->getMessage());
            } else {
                die('Error de conexión a la base de datos');
            }
        }
    }
}