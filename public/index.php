<?php
require_once '../app/core/Autoload.php';
Autoload::register();

// Cargar variables de entorno (si no se cargaron antes)
if (!class_exists('Env')) {
    require_once '../app/config/env.php';
    Env::load('../.env');
}

// Obtener la URL limpia
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParts = explode('/', $url);

// Definir controlador y acción
$controllerName = !empty($urlParts[0]) ? ucfirst($urlParts[0]) : 'Auth';
$action = $urlParts[1] ?? 'login';
$param = $urlParts[2] ?? null;

// Construir nombre del controlador
$controllerClass = $controllerName . 'Controller';
$controllerFile = "../app/controllers/$controllerClass.php";

if (!file_exists($controllerFile)) {
    Logger::notFound("Controlador no encontrado: $controllerClass");
}

require_once $controllerFile;
$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    Logger::notFound("Acción no encontrada: $action");
}

// Verificar autenticación (excepto auth/login)
if (!($controllerName === 'Auth' && $action === 'login')) {
    Auth::check();
}

// Ejecutar la acción
if ($param) {
    $controller->$action($param);
} else {
    $controller->$action();
}