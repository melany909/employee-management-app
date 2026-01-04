<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../database.php";


if (!isset($_GET['id'])) {
    die("Invalid ID");
}

$id = $_GET['id'];

$sql = "DELETE FROM empleados WHERE id_empleado = :id";
$stmt = $db->prepare($sql);
$stmt->execute([':id' => $employeeID]);

header("Location: employee_list.php");
exit;
