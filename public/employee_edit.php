<?php
require_once "../database.php";
require_once "../models/Employee.php";
require_once "../models/EmployeeRepository.php";

$employeeRepository = new EmployeeRepository($db);

/* =========================
   Obtener ID del empleado
   ========================= */
$employeeID = $_GET['id'] ?? null;

if (!$employeeID) {
    die("Invalid ID");
}

/* =========================
   Traer empleado por ID
   ========================= */
$employees = $employeeRepository->findAll();

$employee = null;
foreach ($employees as $e) {
    if ($e['id_empleado'] == $employeeID) {
        $employee = $e;
        break;
    }
}

if (!$employee) {
    die("Employee not found");
}

/* =========================
   Traer departamentos
   ========================= */
$sqlDepartment = "SELECT id_departamento, nombre FROM departamento";
$stmt = $db->prepare($sqlDepartment);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* =========================
   Guardar cambios
   ========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sqlUpdate = "
        UPDATE empleados SET
            nombre = :nombre,
            puesto = :puesto,
            salario = :salario,
            id_departamento = :id_departamento
        WHERE id_empleado = :id
    ";

    $stmt = $db->prepare($sqlUpdate);
    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':puesto' => $_POST['puesto'],
        ':salario' => $_POST['salario'],
        ':id_departamento' => $_POST['id_departamento'],
        ':id' => $employeeID
    ]);

    header("Location: employee_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edit employee</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<h2>Edit employee</h2>

<form method="post">

    <label>Name:</label><br>
    <input type="text" name="nombre" value="<?= htmlspecialchars($employee['nombre']) ?>" required><br><br>

    <label>Position:</label><br>
    <input type="text" name="puesto" value="<?= htmlspecialchars($employee['puesto']) ?>" required><br><br>

    <label>Salary:</label><br>
    <input type="number" step="0.01" name="salario" value="<?= $employee['salario'] ?>" required><br><br>

    <label>Department:</label><br>
    <select name="id_departamento" required>
        <?php foreach ($departments as $d): ?>
            <option value="<?= $d['id_departamento'] ?>"
                <?= isset($employee['id_departamento'])
                && $d['id_departamento'] == $employee['id_departamento']
                ? 'selected'
                : ''?>>
                <?= $d['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <button type="submit">Save changes</button>
</form>

</body>
</html>