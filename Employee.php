<?php
require_once 'Person.php';

abstract class Employee extends Person {
    private string $companyName;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    abstract public function earnings();

    public function __toString(): string {
        return parent::__toString() . ", Company: {$this->companyName}";
    }
}
