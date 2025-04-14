<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    exit("ID no proporcionado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_tarea'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    // Convertir la prioridad a minúsculas para mantener la consistencia (los valores serán: "baja", "media", "alta")
    $prioridad = strtolower($conn->real_escape_string($_POST['prioridad']));
    
    // Actualizar la tarea incluyendo la prioridad
    $conn->query("UPDATE tareas SET titulo='$titulo', descripcion='$descripcion', prioridad='$prioridad' WHERE id = $id");
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM tareas WHERE id = $id";
$res = $conn->query($sql);
$tarea = $res->fetch_assoc();
?>

<!-- CONTENIDO HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Si usas un archivo externo de estilos, asegúrate de que tenga el tema oscuro -->
    <link rel="stylesheet" href="css/globalstyle.css">
    
</head>
<body >
<div class="container py-4">
    <h1 class="mb-4">Editar Tarea</h1>
    <form method="POST" action="actualizar_tarea.php?id=<?= $id ?>">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" id="titulo" value="<?= htmlspecialchars($tarea['titulo']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required><?= htmlspecialchars($tarea['descripcion']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select class="form-select" name="prioridad" id="prioridad" required>
                <option value="baja" <?= ($tarea['prioridad'] === "baja") ? "selected" : "" ?>>Baja</option>
                <option value="media" <?= ($tarea['prioridad'] === "media") ? "selected" : "" ?>>Media</option>
                <option value="alta" <?= ($tarea['prioridad'] === "alta") ? "selected" : "" ?>>Alta</option>
            </select>
        </div>
        <button type="submit" name="actualizar_tarea" class="btn btn-success">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
