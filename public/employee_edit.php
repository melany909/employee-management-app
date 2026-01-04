<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../database.php";
require_once "../models/Employee.php";
require_once "../models/EmployeeRepository.php";

$employeeRepository = new EmployeeRepository($db);

/* obtener ID */
$employeeID = $_GET['id'] ?? null;
if (!$employeeID) {
    die("Invalid ID");
}

/* Traer empleado */
$sqlEmployee = "
SELECT
e.id_empleado,
e.nombre,
e.puesto,
e.salario,
e.id_departamento
FROM empleados e
WHERE e.id_empleado = :id
";


$employee = $employeeRepository->findById($employeeID);

if (!$employee) {
    die("Employee not found");
}

/* Traer deptos */
$sqlDepartment = "SELECT id_departamento, nombre FROM departamento";
$stmt = $db->prepare($sqlDepartment);
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Guardar cambios */
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
    <title>Editar empleado</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <h2>Editar empleado</h2>
    <form method="post">
        <label>Nombre: </label><br>
        <input type="text" name="nombre" value="<?= $employee['nombre'] ?>" required><br>

        <label>Puesto:</label><br>
        <input type="text" name="puesto"
            value="<?php echo $employee['puesto']; ?>"
            required><br><br>

        <label>salario: </label><br>
        <input type="number" name="salario" value="<?= $employee['salario'] ?>" required><br>

        <label>Departamento: </label><br>
        <select name="id_departamento" required>
            <?php foreach ($departments as $d): ?>
                <option value="<?= $d['id_departamento'] ?>"
                    <?= $d['id_departamento'] == $employee['id_departamento'] ? 'selected' : '' ?>>
                    <?= $d['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Guardar cambios</button>
    </form>

</body>

</html>