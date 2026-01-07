<?php

require_once "Employee.php";

class EmployeeRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function findAll(): array
    {

    $sql = "
    SELECT
    e.id_empleado,
    e.nombre,
    e.puesto,
    e.salario,
    e.id_departamento,
    d.nombre AS departamento
    FROM empleados e
    LEFT JOIN departamento d 
    ON e.id_departamento = d.id_departamento
    ORDER BY e.id_empleado
    ";
    

    $stmt = $this->db->prepare($sql);
    $stmt->execute();
   
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

    $employees = [];

    foreach ($rows as $row) {
        $employees[] = new Employee(
            $row['id_empleado'],
            $row['nombre'],
            $row['puesto'],
            (float)$row['salario'],
            $row['departameno']
        );
    }
    
    return $employees;

    }
}


