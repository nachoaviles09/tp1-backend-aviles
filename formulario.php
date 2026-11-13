<?php
declare(strict_types=1);

require_once __DIR__ . '/clases/Entrenador.php';
require_once __DIR__ . '/clases/ClaseGrupal.php';

$entrenadores = [
    new Entrenador(1, 'Martín', 'Gómez', 'martin.gomez@gym.com', 'Musculación y Funcional', 'MAT-1042'),
    new Entrenador(2, 'Laura', 'Fernández', 'laura.fernandez@gym.com', 'Spinning y Cardio', 'MAT-2089'),
    new Entrenador(3, 'Diego', 'Peralta', 'diego.peralta@gym.com', 'CrossFit', 'MAT-3150'),
];

$mensajeExito = null;
$mensajeError = null;
$claseCreada = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = filter_var($_POST['clase_grupal_id'] ?? null, FILTER_VALIDATE_INT);
        $cupoMaximo = filter_var($_POST['cupoMaximo'] ?? null, FILTER_VALIDATE_INT);
        $inscriptos = filter_var($_POST['inscriptos'] ?? null, FILTER_VALIDATE_INT);
        $entrenadorId = filter_var($_POST['entrenador_id'] ?? null, FILTER_VALIDATE_INT);

        if ($id === false || $cupoMaximo === false || $inscriptos === false || $entrenadorId === false) {
            throw new Exception("Los campos numéricos (ID, cupo máximo, inscriptos y entrenador) deben ser enteros válidos.");
        }

        $nombre = (string) ($_POST['nombre'] ?? '');
        $dia = (string) ($_POST['dia'] ?? '');

        $claseCreada = new ClaseGrupal(
            $id,
            $nombre,
            $dia,
            $cupoMaximo,
            $inscriptos,
            $entrenadorId
        );

        $mensajeExito = "Clase grupal registrada correctamente.";
    } catch (Exception $e) {
        $mensajeError = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de ClaseGrupal - Ficha 4</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 640px; margin: 2rem auto; padding: 0 1rem; color: #1f2937; }
        nav { margin-bottom: 1.5rem; }
        nav a { margin-right: 1rem; color: #2563eb; font-weight: 600; text-decoration: none; }
        form { display: flex; flex-direction: column; gap: 0.9rem; background: #f9fafb; padding: 1.5rem; border: 1px solid #e5e7eb; border-radius: 6px; }
        label { display: flex; flex-direction: column; font-weight: 600; gap: 0.3rem; }
        input, select { padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; font-size: 1rem; }
        button { padding: 0.7rem; background: #2563eb; color: #fff; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; }
        .alert { padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
        .ok { background: #f0fdf4; border: 1px solid #86efac; color: #166534; }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Listado y Regla de Negocio</a>
        <a href="formulario.php">Alta de ClaseGrupal (POST)</a>
    </nav>

    <h1>Alta de Clase Grupal</h1>

    <?php if ($mensajeError !== null): ?>
        <div class="alert error">
            <strong>Error de validación:</strong> <?= htmlspecialchars($mensajeError) ?>
        </div>
    <?php endif; ?>

    <?php if ($mensajeExito !== null && $claseCreada !== null): ?>
        <div class="alert ok">
            <strong><?= htmlspecialchars($mensajeExito) ?></strong>
            <ul>
                <li><strong>clase_grupal_id:</strong> <?= $claseCreada->getClaseGrupalId() ?></li>
                <li><strong>nombre:</strong> <?= htmlspecialchars($claseCreada->getNombre()) ?></li>
                <li><strong>dia:</strong> <?= htmlspecialchars($claseCreada->getDia()) ?></li>
                <li><strong>cupoMaximo:</strong> <?= $claseCreada->getCupoMaximo() ?></li>
                <li><strong>inscriptos:</strong> <?= $claseCreada->getInscriptos() ?></li>
                <li><strong>cuposDisponibles():</strong> <?= $claseCreada->cuposDisponibles() ?></li>
                <li><strong>entrenador_id:</strong> <?= $claseCreada->getEntrenadorId() ?></li>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="formulario.php" novalidate>
        <label>
            ID de Clase Grupal (clase_grupal_id)
            <input type="number" name="clase_grupal_id" min="1" value="<?= htmlspecialchars((string) ($_POST['clase_grupal_id'] ?? '5')) ?>" required>
        </label>

        <label>
            Nombre de la clase (nombre)
            <input type="text" name="nombre" value="<?= htmlspecialchars((string) ($_POST['nombre'] ?? '')) ?>" placeholder="Ej: Yoga Integral" required>
        </label>

        <label>
            Día (lunes a sabado, sin tilde)
            <select name="dia" required>
                <?php
                $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
                $diaSeleccionado = $_POST['dia'] ?? 'lunes';
                foreach ($dias as $d):
                ?>
                    <option value="<?= $d ?>" <?= $diaSeleccionado === $d ? 'selected' : '' ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>
        </label>

        <label>
            Cupo Máximo (1 a 50)
            <input type="number" name="cupoMaximo" min="1" max="50" value="<?= htmlspecialchars((string) ($_POST['cupoMaximo'] ?? '20')) ?>" required>
        </label>

        <label>
            Inscriptos (0 a cupoMaximo)
            <input type="number" name="inscriptos" min="0" max="50" value="<?= htmlspecialchars((string) ($_POST['inscriptos'] ?? '0')) ?>" required>
        </label>

        <label>
            Entrenador (entrenador_id)
            <select name="entrenador_id" required>
                <?php
                $entrenadorSeleccionado = (int) ($_POST['entrenador_id'] ?? 1);
                foreach ($entrenadores as $ent):
                ?>
                    <option value="<?= $ent->getEntrenadorId() ?>" <?= $entrenadorSeleccionado === $ent->getEntrenadorId() ? 'selected' : '' ?>>
                        <?= $ent->getEntrenadorId() ?> - <?= htmlspecialchars($ent->getNombre() . ' ' . $ent->getApellido()) ?> (<?= htmlspecialchars($ent->getEspecialidad()) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>

        <button type="submit">Registrar Clase Grupal</button>
    </form>
</body>
</html>