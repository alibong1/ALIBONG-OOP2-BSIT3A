<?php
require_once 'Employee.php';

class HourlyEmployee extends Employee {
    private int $hoursWorked;
    private float $rate;

    public function __construct($name, $address, $age, $companyName, $hoursWorked, $rate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function earnings(): float {
        $overtimeRate = ($this->hoursWorked > 40) ? 1.5 * $this->rate : $this->rate;
        return $this->hoursWorked * $overtimeRate;
    }

    public function __toString(): string {
        return parent::__toString() . ", Hours Worked: {$this->hoursWorked}, Rate: {$this->rate}";
    }
}
