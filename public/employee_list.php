<?php
require_once "../database.php";
require_once "../models/EmployeeRepository.php";
require_once "../public/employee_salaries.php";

$employeeRepository = new EmployeeRepository($db);
$employees = $employeeRepository->findAll();
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Employee List</title>
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>
        <h2>Lista de empleados</h2>
        
        <a href="employee_new.php" class="btn-nuevo">
             ➕ New employee
        </a>
        <br><br>

        <table border="1" cellpadding="5">
            <tr>
                <th>name</th>
                <th>Position</th>
                <th>salary</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee['nombre'] ?></td>
                    <td><?= $employee['puesto'] ?></td>
                    <td><?= $employee['salario'] ?></td>
                    <td><?= $employee['departamento'] ?></td>
                <td>
                    <a href="employee_edit.php?id=<?= $employee['id_empleado'] ?>"> ✏️ Editar</a>

                    <a href="employee_delete.php?id=<?= $employee['id_empleado'] ?>"
                    onclick="return confirm('¿Are you sure you want to get rid of this employee?')">
                    🗑️ Delete
                </a>
            </td>
            </tr>
                <?php endforeach; ?>
        </table>
    </body>
</html>