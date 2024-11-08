<?php
require_once 'EmployeeRoster.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class Main {
    private EmployeeRoster $roster;

    public function start() {
        $rosterSize = (int) readline("Enter the size of the roster: ");
        $this->roster = new EmployeeRoster($rosterSize);
        $this->entrance();
    }

    public function entrance() {
        while (true) {
            $this->menu();
            $choice = (int) readline("Choose an option: ");
            switch ($choice) {
                case 1:
                    $this->addEmployee();
                    break;
                case 2:
                    $index = (int) readline("Enter index to remove: ");
                    $this->roster->remove($index);
                    break;
                case 3:
                    $this->roster->display();
                    break;
                case 4:
                    $this->roster->payroll();
                    break;
                case 0:
                    echo "Exiting.\n";
                    return;
                default:
                    echo "Invalid input. Please try again.\n";
            }
        }
    }

    private function menu() {
        echo "*** EMPLOYEE ROSTER MENU ***\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Display Employees\n";
        echo "[4] Payroll\n";
        echo "[0] Exit\n";
    }

    private function addEmployee() {
        $name = readline("Enter name: ");
        
        // Check if the employee already exists
        if ($this->roster->hasEmployeeWithName($name)) {
            echo "An employee with the name '$name' already exists. Please use a unique name.\n";
            return;
        }

        $address = readline("Enter address: ");
        $age = (int) readline("Enter age: ");
        $companyName = readline("Enter company name: ");

        echo "[1] Commission Employee, [2] Hourly Employee, [3] Piece Worker\n";
        $type = (int) readline("Select type of employee: ");
        switch ($type) {
            case 1:
                $salary = (float) readline("Enter regular salary: ");
                $itemsSold = (int) readline("Enter items sold: ");
                $commissionRate = (float) readline("Enter commission rate: ");
                $employee = new CommissionEmployee($name, $address, $age, $companyName, $salary, $itemsSold, $commissionRate);
                break;
            case 2:
                $hoursWorked = (int) readline("Enter hours worked: ");
                $rate = (float) readline("Enter rate per hour: ");
                $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
                break;
            case 3:
                $itemsProduced = (int) readline("Enter items produced: ");
                $wagePerItem = (float) readline("Enter wage per item: ");
                $employee = new PieceWorker($name, $address, $age, $companyName, $itemsProduced, $wagePerItem);
                break;
            default:
                echo "Invalid input.\n";
                return;
        }
        $this->roster->add($employee);
    }
}
