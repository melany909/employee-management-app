<?php
require_once "../database.php";
require_once "../models/EmployeeRepository.php";

$employeeRepository = new EmployeeRepository($db);
$employees = $employeeRepository->findAll();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de empleados</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <h2>Lista de empleados</h2>

    <a href="employee_new.php" class="btn-nuevo">
        ➕ Nuevo empleado
    </a>
    <br><br>

    <table border="1" cellpadding="5">
        <tr>
            <th>nombre</th>
            <th>Puesto</th>
            <th>salario</th>
            <th>Departamento</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= $employee['nombre'] ?></td>
                <td><?= $employee['puesto'] ?></td>
                <td><?= $employee['salario'] ?></td>
                <td><?= $employee['departamento'] ?></td>
                <td>
                    <a href="./employee_edit.php?id=<?= $employee['id_empleado'] ?>"> ✏️ Editar</a>

                    <a href="./employee_delete.php?id=<?= $e['id_empleado'] ?>"
                        onclick="return confirm('¿Seguro que quiere eliminar este empleado?')">
                        🗑️ Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>