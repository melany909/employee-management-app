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
    d.nombre AS departamento
    FROM empleados e
    LEFT JOIN departamento d ON e.id_departamento = d.id_departamento
    ORDER BY e.id_empleado
    ";


        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* Agregado funcion findById */
    public function findById(int $id): array|null
    {
        $sql = "
        SELECT
            e.id_empleado,
            e.nombre,
            e.puesto,
            e.salario,
            e.id_departamento
        FROM empleados e
        WHERE e.id_empleado = :id
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
