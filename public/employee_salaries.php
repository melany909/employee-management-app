<?php
require_once "../database.php";


/* Traer empleados + sueldos */
$sql = "
SELECT
    e.nombre AS employee_name,
    e.puesto AS position,
    s.mes,
    s.año,
    s.monto,
    s.fecha_pago
    FROM sueldos s
    JOIN empleados e ON e.id_empleado = s.empleado_id 
    ORDER BY s.año DESC, s.mes 
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $salaries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de sueldos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h2>Historial de sueldos</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Employee</th>
        <th>Position</th>
        <th>Month</th>
        <th>Year</th>
        <th>Amount</th>
        <th>Payment Date</th>
    </tr>

    <?php foreach ($salaries as $s): ?>
        <tr>
            <td><?= $s['employee_name'] ?></td>
            <td><?= $s['position'] ?></td>
            <td><?= $s['mes'] ?></td>
            <td><?= $s['año'] ?></td>
            <td>$<?= $s['monto'] ?></td>
            <td><?= $s['fecha_pago'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>