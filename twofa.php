<?php
session_start();
if (!isset($_SESSION['user_verified']) || $_SESSION['user_verified'] !== true) {
    header("Location: login.php");
    exit();
}
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = trim($_POST['twoFactorCode'] ?? '');
    // Código 2FA de ejemplo
    if ($code === '123456') {
        $_SESSION['logged_in'] = true;
        unset($_SESSION['user_verified']);
        header("Location: index.php");  // Redirige a la página principal
        exit();
    } else {
        $error = 'Código 2FA incorrecto';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Verificación 2FA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="dark-theme">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6 col-lg-4">
        <div class="card bg-dark text-light">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">Verificación 2FA</h2>
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label for="twoFactorCode" class="form-label">Código 2FA</label>
                <input type="text" class="form-control bg-dark text-light" id="twoFactorCode" name="twoFactorCode" required>
                <small class="form-text text-muted">Código: 123456</small>
              </div>
              <button type="submit" class="btn btn-primary w-100">Verificar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
