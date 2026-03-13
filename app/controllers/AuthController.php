<?php
class AuthController
{
    public function login()
    {
        Auth::guest();

        $error = null;
        Session::init();
        $csrf_token = Session::generateCsrf();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::verifyCsrf($_POST['csrf_token'] ?? '')) {
                Logger::warning("CSRF attack detected");
                Session::setFlash('danger', 'Error de seguridad');
                header('Location: /New_SGA/public/auth/login');
                exit;
            }

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Usuarios hardcodeados
            $users = [
                'admin' => '1234',
                'juan'  => 'password',
                'test'  => 'test'
            ];

            if (!isset($users[$username]) || $users[$username] !== $password) {
                Logger::warning("LOGIN FAIL usuario=$username");
                $error = 'Usuario o contraseña incorrectos';
            } else {
                $_SESSION['user_id'] = $username;
                $_SESSION['username'] = $username;

                Logger::info("LOGIN OK usuario=$username");
                Session::regenerateCsrf();
                Session::setFlash('success', "¡Bienvenido $username!");

                header('Location: /New_SGA/public/alumno/buscar');
                exit;
            }
        }

        require '../app/views/auth/login.php';
    }

    public function logout()
    {
        Session::init();
        $username = $_SESSION['username'] ?? 'desconocido';

        Logger::info("LOGOUT usuario=$username");
        Session::setFlash('info', 'Has cerrado sesión correctamente');

        session_destroy();
        header('Location: /New_SGA/public/auth/login');
        exit;
    }
}