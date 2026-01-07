<?php

class Employee
{
    public int $id;
    public string $name;
    public string $position;
    public float $salary;
    public ?string $department;

    public function __construct(
        int $id,
        string $name,
        string $position,
        float $salary,
        ?string $department
    ){
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
        $this->salary = $salary;
        $this->department = $department;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function getDepartment(): ?string
    {
        return $this->department;
    }
    
}