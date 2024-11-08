<?php
require_once 'Employee.php';

class PieceWorker extends Employee {
    private int $itemsProduced;
    private float $wagePerItem;

    public function __construct($name, $address, $age, $companyName, $itemsProduced, $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName);
        $this->itemsProduced = $itemsProduced;
        $this->wagePerItem = $wagePerItem;
    }

    public function earnings(): float {
        return $this->itemsProduced * $this->wagePerItem;
    }

    public function __toString(): string {
        return parent::__toString() . ", Items Produced: {$this->itemsProduced}, Wage per Item: {$this->wagePerItem}";
    }
}
