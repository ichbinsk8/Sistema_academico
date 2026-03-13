<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="card shadow-lg p-4" style="max-width:420px; width:100%;">
        <h4 class="text-center mb-3">🔐 Iniciar sesión</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/New_SGA/public/auth/login">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" 
                       name="username" 
                       class="form-control" 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       required 
                       autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       required>
            </div>

            <button class="btn btn-primary w-100">
                Entrar
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>