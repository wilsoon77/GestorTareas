<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: captcha.php");
    exit();
}
include 'config.php';

// Procesar acciones antes de enviar salida

// Alternar estado de completado
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $conn->query("UPDATE tareas SET completado = NOT completado WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Eliminar tarea
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM tareas WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Insertar nueva tarea (incluyendo prioridad)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_tarea'])) {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    // Convertir prioridad a minúsculas para mantener consistencia
    $prioridad = strtolower($conn->real_escape_string($_POST['prioridad']));
    $fecha_creacion = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tareas (titulo, descripcion, prioridad, fecha_creacion) 
            VALUES ('$titulo', '$descripcion', '$prioridad', '$fecha_creacion')";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}

// Configurar paginación
$limite = 5; // tareas por página
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) { $page = 1; }
$offset = ($page - 1) * $limite;

// Procesar parámetros de búsqueda y filtro
$busqueda = $conn->real_escape_string($_GET['busqueda'] ?? "");
$filtro = $_GET['filtro'] ?? "";

$query = "SELECT * FROM tareas";
$condiciones = [];
if ($busqueda !== "") {
    $condiciones[] = "(titulo LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%')";
}
if ($filtro === "completadas") {
    $condiciones[] = "completado = 1";
} elseif ($filtro === "pendientes") {
    $condiciones[] = "completado = 0";
} elseif (in_array($filtro, ['baja', 'media', 'alta'])) {
    // Para prioridad, almacenamos todo en minúsculas
    $condiciones[] = "LOWER(prioridad) = '$filtro'";
}
if (count($condiciones) > 0) {
    $query .= " WHERE " . implode(" AND ", $condiciones);
}
$query .= " ORDER BY fecha_creacion DESC";

// Obtener total de tareas para la paginación
$countQuery = "SELECT COUNT(*) as total FROM tareas";
if (count($condiciones) > 0) {
    $countQuery .= " WHERE " . implode(" AND ", $condiciones);
}
$countResult = $conn->query($countQuery);
$totalRow = $countResult->fetch_assoc();
$totalTareas = $totalRow['total'];
$totalPaginas = ceil($totalTareas / $limite);

// Agregar límite para la paginación
$query .= " LIMIT $offset, $limite";
$result = $conn->query($query);
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>


<!-- CONTENIDO HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/2821/2821739.png" />
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/globalstyle.css">
      <!-- Font Awesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold">Administración Y Gestión de Tareas</h1>
        <a href="logout.php" class="btn btn-outline-light"> Cerrar Sesión <i class="fa-solid fa-right-to-bracket"></i> </a>
    </div>

    <!-- Formulario para agregar tarea -->
    <div class="mb-4">
    <!-- Botón para colapsar/expandir el formulario -->
    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formTareaCollapse" 
            aria-expanded="true" aria-controls="formTareaCollapse">
        <i class="fa-solid fa-plus me-2"></i> Mostrar / Ocultar Formulario
    </button>
</div>

<!-- Contenedor colapsable para el formulario -->
<div class="collapse" id="formTareaCollapse">
    <div class="card card-custom mb-5">
        <div class="card-header bg-dark text-white"> Añadir Nueva Tarea</div>
        <div class="card-body">
            <form method="POST" action="index.php">
                <div class="mb-3">
                    <label for="titulo" class="form-label text-white">Título</label>
                    <input type="text" class="form-control" name="titulo" id="titulo" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label  text-white">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="prioridad" class="form-label  text-white">Prioridad</label>
                    <select class="form-select" name="prioridad" id="prioridad" required>
                        <option value="baja">Baja</option>
                        <option value="media">Media</option>
                        <option value="alta">Alta</option>
                    </select>
                </div>
                <button type="submit" name="agregar_tarea" class="btn btn-primary">Guardar Tarea</button>
                
            </form>
        </div>
    </div>
</div>

    
  <!-- Buscador y Filtros -->
<form method="GET" class="row g-3 mb-4 align-items-center">
    <!-- Buscador -->
    <div class="col-md-6">
        <input type="text" name="busqueda" class="form-control" placeholder="🔍 Buscar tareas..." value="<?= htmlspecialchars($busqueda) ?>">
    </div>

    <!-- Botón de búsqueda -->
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-info w-100">
            <i class="fa-solid fa-magnifying-glass me-1"></i> Buscar
        </button>
    </div>
    <!-- Filtros con dropdown -->
    <div class="col-md-4">
        <div class="dropdown w-100">
            <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" type="button" data-bs-toggle="dropdown">
                <i class="fa-solid fa-filter me-2"></i> Filtrar por categoría
            </button>
            <ul class="dropdown-menu w-100">
                <li><button class="dropdown-item" name="filtro" value=""><i class="fa-solid fa-bars me-2"></i>Todos</button></li>
                <li><button class="dropdown-item" name="filtro" value="pendientes"><i class="fa-regular fa-circle-dot me-2"></i>Pendientes</button></li>
                <li><button class="dropdown-item" name="filtro" value="completadas"><i class="fa-regular fa-circle-check me-2"></i>Completadas</button></li>
                <li><button class="dropdown-item" name="filtro" value="baja"><i class="fa-solid fa-bolt me-2 text-success"></i>Baja prioridad</button></li>
                <li><button class="dropdown-item" name="filtro" value="media"><i class="fa-solid fa-bolt me-2 text-warning"></i>Media prioridad</button></li>
                <li><button class="dropdown-item" name="filtro" value="alta"><i class="fa-solid fa-bolt me-2 text-danger"></i>Alta prioridad</button></li>
            </ul>
        </div>
    </div>
</form>


    <!-- Lista de Tareas -->
    <?php while ($tarea = $result->fetch_assoc()): 
        // Determinar clase de prioridad y si está completada
        $clasePrioridad = "";
        if ($tarea['prioridad'] === "alta") {
            $clasePrioridad = "priority-high";
        } elseif ($tarea['prioridad'] === "media") {
            $clasePrioridad = "priority-medium";
        } else {
            $clasePrioridad = "priority-low";
        }
        $claseCompletado = $tarea['completado'] ? "strikethrough" : "";
    ?>
        <div class="card card-custom mb-4 <?= $clasePrioridad ?> fade-in">
    <div class="card-body">
        <h5 class="card-title <?= $claseCompletado ?>">
            <?= htmlspecialchars($tarea['titulo']) ?>
        </h5>
        <p class="card-text <?= $claseCompletado ?>">
            <?= htmlspecialchars($tarea['descripcion']) ?>
        </p>
        <p class="card-text">
            <small class="text-secondary">
                <i class="fa-regular fa-clock me-1"></i> <?= date('d/m/Y H:i', strtotime($tarea['fecha_creacion'])) ?>
            </small>
        </p>
        <div class="d-flex gap-2 flex-wrap">
            <a href="?toggle=<?= $tarea['id'] ?>" class="btn btn-sm <?= $tarea['completado'] ? 'btn-outline-warning' : 'btn-outline-success' ?>">
                <i class="fa-solid <?= $tarea['completado'] ? 'fa-rotate-left' : 'fa-check' ?> me-1"></i>
                <?= $tarea['completado'] ? 'Desmarcar' : 'Completar' ?>
            </a>
            <a href="actualizar_tarea.php?id=<?= $tarea['id'] ?>" class="btn btn-sm btn-outline-primary">
                <i class="fa-solid fa-pen-to-square me-1"></i> Editar
            </a>
            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?= $tarea['id'] ?>">
                <i class="fa-solid fa-trash me-1"></i> Eliminar
            </button>
        </div>
    </div>
</div>


        <!-- Modal Eliminar -->
        <div class="modal fade" id="modalEliminar<?= $tarea['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $tarea['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?= $tarea['id'] ?>"> Confirmar Eliminación </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        ¿Eliminar tarea "<strong><?= htmlspecialchars($tarea['titulo']) ?></strong>"?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="?eliminar=<?= $tarea['id'] ?>" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    <!-- Paginación -->
    <nav aria-label="Paginación de tareas">
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?busqueda=<?= urlencode($busqueda) ?>&filtro=<?= urlencode($filtro) ?>&page=<?= $page-1 ?>">Anterior</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a class="page-link" href="?busqueda=<?= urlencode($busqueda) ?>&filtro=<?= urlencode($filtro) ?>&page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPaginas): ?>
          <li class="page-item">
            <a class="page-link" href="?busqueda=<?= urlencode($busqueda) ?>&filtro=<?= urlencode($filtro) ?>&page=<?= $page+1 ?>">Siguiente</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
