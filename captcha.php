<?php
session_start();
// Puedes guardar en sesión algún indicador si lo necesitas
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Verificación Humana</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="dark-theme">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6 col-lg-4">
        <div class="card bg-dark text-light">
          <div class="card-body p-5">
            <h2 class="text-center mb-4">Verificación Humana</h2>
            <form id="captchaForm" onsubmit="return validateCaptcha(event)">
              <div class="mb-4 text-center">
                <canvas id="captchaCanvas" width="200" height="70" class="mb-3"></canvas>
                <button type="button" class="btn btn-secondary btn-sm" onclick="generateCaptcha()">
                  <i class="fas fa-redo"></i> Recargar CAPTCHA
                </button>
              </div>
              <div class="mb-3">
                <label for="captchaInput" class="form-label">Ingrese el texto del CAPTCHA</label>
                <input type="text" class="form-control bg-dark text-light" id="captchaInput" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Verificar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    let captchaText = '';

    function generateCaptcha() {
      const canvas = document.getElementById('captchaCanvas');
      const ctx = canvas.getContext('2d');
      
      // Limpiar canvas
      ctx.fillStyle = '#2c3e50';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Generar texto aleatorio
      const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789';
      captchaText = '';
      for (let i = 0; i < 6; i++) {
        captchaText += chars.charAt(Math.floor(Math.random() * chars.length));
      }

      // Dibujar líneas de ruido
      for (let i = 0; i < 6; i++) {
        ctx.beginPath();
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height);
        ctx.strokeStyle = '#3498db';
        ctx.stroke();
      }

      // Dibujar cada carácter con rotación aleatoria
      for (let i = 0; i < captchaText.length; i++) {
        ctx.save();
        ctx.translate(30 + i * 25, 45);
        ctx.rotate((Math.random() - 0.5) * 0.4);
        ctx.font = 'bold 30px Arial';
        ctx.fillStyle = '#ecf0f1';
        ctx.fillText(captchaText[i], 0, 0);
        ctx.restore();
      }

      // Dibujar puntos de ruido
      for (let i = 0; i < 50; i++) {
        ctx.fillStyle = '#3498db';
        ctx.fillRect(Math.random() * canvas.width, Math.random() * canvas.height, 2, 2);
      }
    }

    function validateCaptcha(event) {
      event.preventDefault();
      const userInput = document.getElementById('captchaInput').value;
      
      if (userInput === captchaText) {
        // Redirigir a login.php si el CAPTCHA es correcto
        window.location.href = 'login.php';
      } else {
        alert('CAPTCHA incorrecto. Por favor, intente nuevamente.');
        generateCaptcha();
        document.getElementById('captchaInput').value = '';
      }
    }

    // Generar CAPTCHA inicial al cargar la página
    window.onload = generateCaptcha;
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>
