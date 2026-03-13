<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error 500</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-danger">
        <h4>Error 500</h4>
        <p><?= htmlspecialchars($errorMessage) ?></p>
        <p>Si el problema persiste, contacte al administrador.</p>
    </div>
</div>
</body>
</html>
