<?php
require_once 'Employee.php';

class CommissionEmployee extends Employee {
    private float $regularSalary;
    private int $itemsSold;
    private float $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemsSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName);
        $this->regularSalary = $regularSalary;
        $this->itemsSold = $itemsSold;
        $this->commissionRate = $commissionRate;
    }

    public function earnings(): float {
        return $this->regularSalary + ($this->itemsSold * $this->commissionRate);
    }

    public function __toString(): string {
        return parent::__toString() . ", Salary: {$this->regularSalary}, Items Sold: {$this->itemsSold}, Commission Rate: {$this->commissionRate}";
    }
}
