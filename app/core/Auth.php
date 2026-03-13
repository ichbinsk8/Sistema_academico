<?php
class Auth
{
    public static function check()
    {
        Session::init();

        if (!isset($_SESSION['user_id'])) {
            Session::setFlash('warning', 'Debes iniciar sesión para acceder');
            header('Location: /New_SGA/public/auth/login');
            exit;
        }
    }

    public static function guest()
    {
        Session::init();

        if (isset($_SESSION['user_id'])) {
            header('Location: /New_SGA/public/alumno/buscar');
            exit;
        }
    }
}