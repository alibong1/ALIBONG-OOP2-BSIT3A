<?php

require_once 'Employee.php';
require_once 'CommissionEmployee.php';
require_once 'HourlyEmployee.php';
require_once 'PieceWorker.php';

class EmployeeRoster {
    private array $roster = [];
    private int $size;

    public function __construct(int $size) {
        $this->size = $size;
        $this->roster = [];
    }

    public function add(Employee $employee): void {
        $emptyIndex = array_search(null, $this->roster, true);
    
        if ($emptyIndex !== false) {
            $this->roster[$emptyIndex] = $employee;
            echo "-------------------------------------------------\n";
            echo "Employee added successfully in the first available spot (Index #$emptyIndex)!\n";
        } elseif (count($this->roster) < $this->size) {
            $this->roster[] = $employee;
            echo "-------------------------------------------------\n";
            echo "Employee added successfully!\n";
        } else {
            echo "Roster is full. Unable to add more employees.\n";
        }
    }
    

    public function remove(int $index): void {
        if (isset($this->roster[$index])) {
            $this->roster[$index] = null; 
            echo "Employee removed successfully! Spot is now available.\n";
        } else {
            echo "Invalid employee index. Cannot remove.\n";
        }
    }
    

    public function exists(int $index): bool {
        return isset($this->roster[$index]);
    }

    public function availableSpace(): int {
        $occupied = count(array_filter($this->roster, fn($e) => $e !== null)); 
        return $this->size - $occupied; 
    }
    

    // Display the all employees in the roster 
    public function display(): void {
        if (empty($this->roster)) {
            echo "No employees in the roster.\n";
        } else {
            foreach ($this->roster as $index => $employee) {
                if ($employee !== null) {  // Only display employees that are not null
                    echo "[" . "Employee #" . ($index + 1) . "] " . $employee->getDetails() . "\n";
                }
            }
        }
    }

    // Count the total number of employees in the delete menu & ce summary
    public function count(): void {
        $count = count(array_filter($this->roster, fn($e) => $e !== null)); 
        echo "-------------------------------------------------\n";
        echo "Total employees: " . $count . "\n";
        echo "-------------------------------------------------\n";
    }

    // Display employees by type
    public function displayByType(string $type, string $emptyMessage): void {
        $employees = array_filter($this->roster, fn($e) => $e instanceof $type);

        if (empty($employees)) {
            echo $emptyMessage . "\n";
        } else {
            foreach ($employees as $index => $employee) {
                echo "[" ."Employee #". ($index + 1) . "] " . $employee->getDetails() . "\n";
            }
        }
    }

    // Display all Commission Employees
    public function displayCE(): void {
        $this->displayByType(CommissionEmployee::class, "No Commission Employees in the roster.");
    }

    // Display all Hourly Employees
    public function displayHE(): void {
        $this->displayByType(HourlyEmployee::class, "No Hourly Employees in the roster.");
    }

    // Display all Piece Workers
    public function displayPE(): void {
        $this->displayByType(PieceWorker::class, "No Piece Workers in the roster.");
    }

    // Count employees by type
    public function countByType(string $type, string $emptyMessage): void {
        $count = count(array_filter($this->roster, fn($e) => $e instanceof $type));
        echo $count === 0 ? $emptyMessage . "\n" : "Total " . basename(str_replace('\\', '/', $type)) . ": " . $count . "\n";

    }

    // Count Commission Employees
    public function countCE(): void {
         $this->countByType(CommissionEmployee::class, "No Commission Employees in the roster.");
    }

    // Count Hourly Employees
    public function countHE(): void {
        $this->countByType(HourlyEmployee::class, "No Hourly Employees in the roster.");
    }

    // Count Piece Workers
    public function countPE(): void {
         $this->countByType(PieceWorker::class, "No Piece Workers in the roster.");
    }

    // Calculate payroll for all employees
    public function payroll(): void {
        if (empty($this->roster)) {
            echo "No employees to calculate payroll.\n";
        } else {
            echo "Payroll Summary:\n";
            echo "-------------------------------------------------\n";
    
            foreach ($this->roster as $index => $employee) {
                if ($employee !== null) { 
                    echo "Employee #" . ($index + 1) . ": " . $employee->getDetails() . " - Pay: " . $employee->calculatePay() . "\n";
                }
            }
    
            echo "-------------------------------------------------\n";
        }
    }
    
}
