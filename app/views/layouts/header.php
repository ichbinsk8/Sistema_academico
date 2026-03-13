<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
Session::init();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/New_SGA/public/alumno/buscar">Sistema Académico</a>
        
        <div class="d-flex">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="navbar-text text-white me-3">
                    👤 <?= htmlspecialchars($_SESSION['username'] ?? 'Usuario') ?>
                </span>
                <a href="/New_SGA/public/auth/logout" 
                   class="btn btn-outline-light btn-sm">
                    Cerrar sesión
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if (Session::hasFlash()): 
        $flash = Session::getFlash(); ?>
        <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>