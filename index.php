<?php
declare(strict_types=1);

require_once __DIR__ . '/clases/Entrenador.php';
require_once __DIR__ . '/clases/Socio.php';
require_once __DIR__ . '/clases/ClaseGrupal.php';

// 3 Entrenadores (clase hija 1)
$entrenadores = [
    new Entrenador(1, 'Martín', 'Gómez', 'martin.gomez@gym.com', 'Musculación y Funcional', 'MAT-1042'),
    new Entrenador(2, 'Laura', 'Fernández', 'laura.fernandez@gym.com', 'Spinning y Cardio', 'MAT-2089'),
    new Entrenador(3, 'Diego', 'Peralta', 'diego.peralta@gym.com', 'CrossFit', 'MAT-3150'),
];

// Mapa auxiliar para resolver nombre del entrenador por entrenador_id
$nombresEntrenadores = [];
foreach ($entrenadores as $entrenador) {
    $nombresEntrenadores[$entrenador->getEntrenadorId()] = $entrenador->getNombre() . ' ' . $entrenador->getApellido();
}

// 3 Socios (clase hija 2)
$socios = [
    new Socio(1, 'Camila', 'Ríos', 'camila.rios@mail.com', 1001, 'mensual'),
    new Socio(2, 'Lucas', 'Méndez', 'lucas.mendez@mail.com', 1002, 'trimestral'),
    new Socio(3, 'Sofía', 'Acosta', 'sofia.acosta@mail.com', 1003, 'anual'),
];

// 4 Clases Grupales (clase independiente - incluye ejemplo 20/20 de la ficha)
$clasesGrupales = [
    new ClaseGrupal(1, 'CrossFit Intenso', 'lunes', 20, 20, 3),
    new ClaseGrupal(2, 'Spinning Nocturno', 'miercoles', 15, 12, 2),
    new ClaseGrupal(3, 'Funcional Full Body', 'viernes', 25, 18, 1),
    new ClaseGrupal(4, 'HIIT Sabatino', 'sabado', 12, 12, 1),
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TP1 Backend - Ficha 4: Gimnasio</title>
    <style>
        body { font-family: system-ui, sans-serif; max-width: 960px; margin: 2rem auto; padding: 0 1rem; color: #1f2937; }
        nav { margin-bottom: 1.5rem; }
        nav a { margin-right: 1rem; color: #2563eb; font-weight: 600; text-decoration: none; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { border: 1px solid #d1d5db; padding: 0.6rem 0.8rem; text-align: left; }
        th { background-color: #f3f4f6; }
        .box { background: #f9fafb; border-left: 4px solid #2563eb; padding: 1rem; margin-bottom: 1rem; }
        .error { border-left-color: #dc2626; background: #fef2f2; color: #991b1b; }
        .ok { border-left-color: #16a34a; background: #f0fdf4; color: #166534; }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Listado y Regla de Negocio</a>
        <a href="formulario.php">Alta de ClaseGrupal (POST)</a>
    </nav>

    <h1>Ficha 4: Gimnasio — Backend PHP</h1>

    <h2>Entrenadores (3 instancias)</h2>
    <ul>
        <?php foreach ($entrenadores as $entrenador): ?>
            <li><?= htmlspecialchars($entrenador->describir()) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Socios (3 instancias)</h2>
    <ul>
        <?php foreach ($socios as $socio): ?>
            <li><?= htmlspecialchars($socio->describir()) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Clases Grupales (4 instancias)</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Día</th>
                <th>Entrenador</th>
                <th>Inscriptos / Cupo</th>
                <th>Disponibles</th>
                <th>¿Hay cupo?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clasesGrupales as $clase): ?>
                <tr>
                    <td><?= $clase->getClaseGrupalId() ?></td>
                    <td><?= htmlspecialchars($clase->getNombre()) ?></td>
                    <td><?= htmlspecialchars($clase->getDia()) ?></td>
                    <td><?= htmlspecialchars($nombresEntrenadores[$clase->getEntrenadorId()] ?? 'Desconocido') ?> (ID: <?= $clase->getEntrenadorId() ?>)</td>
                    <td><?= $clase->getInscriptos() ?> / <?= $clase->getCupoMaximo() ?></td>
                    <td><?= $clase->cuposDisponibles() ?></td>
                    <td><?= $clase->hayCupo() ? 'Sí' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Demostración de Regla de Negocio</h2>

    <?php
    // Ejemplo 1: Clase con cupo disponible (Spinning Nocturno: 12/15)
    $claseConLugar = $clasesGrupales[1];
    ?>
    <div class="box ok">
        <strong>Caso 1 — Inscripción válida en "<?= htmlspecialchars($claseConLugar->getNombre()) ?>":</strong><br>
        Estado inicial: <?= $claseConLugar->getInscriptos() ?>/<?= $claseConLugar->getCupoMaximo() ?>
        (hayCupo: <?= $claseConLugar->hayCupo() ? 'true' : 'false' ?>, disponibles: <?= $claseConLugar->cuposDisponibles() ?>).<br>
        <?php
        $claseConLugar->inscribir();
        ?>
        Luego de ejecutar <code>inscribir()</code>: <?= $claseConLugar->getInscriptos() ?>/<?= $claseConLugar->getCupoMaximo() ?>
        (disponibles: <?= $claseConLugar->cuposDisponibles() ?>).
    </div>

    <?php
    // Ejemplo 2: Clase completa (CrossFit Intenso: 20/20 -> ejemplo oficial de la ficha)
    $claseCompleta = $clasesGrupales[0];
    ?>
    <div class="box error">
        <strong>Caso 2 — Intento de inscripción en clase llena "<?= htmlspecialchars($claseCompleta->getNombre()) ?>":</strong><br>
        Estado: <?= $claseCompleta->getInscriptos() ?>/<?= $claseCompleta->getCupoMaximo() ?>
        (hayCupo: <?= $claseCompleta->hayCupo() ? 'true' : 'false' ?>, disponibles: <?= $claseCompleta->cuposDisponibles() ?>).<br>
        <?php
        try {
            $claseCompleta->inscribir();
        } catch (Exception $e) {
            echo "Excepción capturada al llamar a <code>inscribir()</code>: <strong>" . htmlspecialchars($e->getMessage()) . "</strong>";
        }
        ?>
    </div>
</body>
</html>