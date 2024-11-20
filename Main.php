<?php

require_once 'EmployeeRoster.php';

class InvalidOptionException extends Exception {}

class Main {
    private EmployeeRoster $roster;
    private int $size;
    private bool $repeat;

    protected function validateLettersOnly(string $input): bool {
         return ctype_alpha($input);
    }

    protected function validateNotBlank(string $input): bool {
        return trim($input) !== '';
    }
    

    public function start() {
        $this->clear();
        $this->repeat = true;

        echo "*** Welcome to Employee Roster System ***\n";
        $this->size = (int)readline("Please enter the size of the roster: ");
        
        if ($this->size < 1) {
            echo "Invalid input. Please try again.\n";
            readline("Press \"Enter\" key to continue...");
            $this->start();
        } else {
            $this->roster = new EmployeeRoster($this->size);
            $this->entrance();
        }
    }

    private function entrance() {
        while ($this->repeat) {
            $this->clear();
            $this->menu();
            $choice = readline("Select option: ");
    
            // Check if the input is numeric and valid
            if (is_numeric($choice)) {
                try {
                    switch ((int)$choice) {
                        case 1:
                            $this->addMenu();
                            break;
                        case 2:
                            $this->deleteMenu();
                            break;
                        case 3:
                            $this->otherMenu();
                            break;
                        case 0:
                            $this->repeat = false;
                            echo "System Exit...\n";
                            exit;
                            break;
                        default:
                            throw new InvalidOptionException("Invalid input. Please try again.");
                    }
                } catch (InvalidOptionException $e) {
                    echo $e->getMessage() . "\n";
                    readline("Press \"Enter\" key to continue...");
                }
            } else {
                echo "Invalid input. Please enter a number from the menu options.\n";
                readline("Press \"Enter\" key to continue...");
            }
        }
    }
    
    

    private function menu() {
        $this->clear(); 
    
        echo "Please enter the size of the roster: " . $this->size . "\n"; 
        echo "Available Space: " . $this->roster->availableSpace() . "\n"; 
        echo "*****************************************\n";
        echo "***        EMPLOYEE ROSTER MENU       ***\n";
        echo "*****************************************\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Menu\n";
        echo "[0] Exit\n";
        echo "*****************************************\n";
    

    }
    
    
    private function addMenu() {
        $this->clear();
    
        if ($this->roster->availableSpace() <= 0) {
            echo "The roster is full. You cannot add more employees.\n";
    
            $choice = strtolower(readline("Press \"Enter\" key to continue...: "));
            if ($choice === 'y') {
                $this->entrance(); 
            } else {
                echo "Returning to the main menu...\n";
                $this->entrance(); 
            }
            return; 
        }
        echo "-----------------------\n";
        echo "--- Employee Detail ---\n";
        echo "-----------------------\n";
        $name = readline("Enter name: ");
        $address = readline("Enter address: ");
        $age = (int)readline("Enter age: ");
        $companyName = readline("Enter company name: ");
    
        // Validate name 
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            echo "\nName can only contain letters.\n";
            readline("Press \"Enter\" key to continue...");
            $this->addMenu(); 
            return; 
        }
    
        // Validate age 
        if (!is_numeric($age) || $age < 18) {
            echo "\nAge must be 18  above.\n";
            echo "Age must be a number.\n";
            readline("Press \"Enter\" key to continue...");
            $this->addMenu(); 
            return; 
        }
    
        $this->empType($name, $address, $age, $companyName); 
    }
    
    
    
    
    private function empType($name, $address, $age, $companyName) {
        echo "---------------------\n";
        echo "--- Employee Type ---\n";
        echo "---------------------\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";
        $type = (int)readline("Select type of Employee: ");

        try {
            switch ($type) {
                case 1:
                    $this->addOnsCE($name, $address, $age, $companyName);
                    break;
                case 2:
                    $this->addOnsHE($name, $address, $age, $companyName);
                    break;
                case 3:
                    $this->addOnsPE($name, $address, $age, $companyName);
                    break;
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->empType($name, $address, $age, $companyName);
        }
    }

    private function addOnsCE($name, $address, $age, $companyName) {    
        $regularSalary = (float)readline("Enter regular salary: ");
        $itemSold = (int)readline("Enter items sold: ");
        $commissionRate = (float)readline("Enter commission rate (decimal): ");
    
        
        if (!$this->validateNotBlank($name) || !$this->validateNotBlank($address) || 
            !$this->validateNotBlank($companyName) || $regularSalary <= 0 || $itemSold < 0 || $commissionRate <= 0) {
            echo "\nInvalid input detected!";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    
        $employee = new CommissionEmployee($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate);
        $this->roster->add($employee);
        $this->repeat();
    }
    
    private function addOnsHE($name, $address, $age, $companyName) {
        if ($age < 18) {
            echo "\nAge must be 18 and above.\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    
        $hoursWorked = (float)readline("Enter hours worked: ");
        $rate = (float)readline("Enter rate per hour: ");
    
        
        if (!$this->validateNotBlank($name) || !$this->validateNotBlank($address) || 
            !$this->validateNotBlank($companyName) || $hoursWorked <= 0 || $rate <= 0) {
            echo "\nInvalid input detected!";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    
        $employee = new HourlyEmployee($name, $address, $age, $companyName, $hoursWorked, $rate);
        $this->roster->add($employee);
        $this->repeat();
    }
    
    private function addOnsPE($name, $address, $age, $companyName) {
        if ($age < 18) {
            echo "\nAge must be 18 and above.\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    
        $numberItems = (int)readline("Enter number of items: ");
        $wagePerItem = (float)readline("Enter wage per item: ");
    
        
        if (!$this->validateNotBlank($name) || !$this->validateNotBlank($address) || 
            !$this->validateNotBlank($companyName) || $numberItems < 0 || $wagePerItem <= 0) {
            echo "\nInvalid input detected!";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    
        $employee = new PieceWorker($name, $address, $age, $companyName, $numberItems, $wagePerItem);
        $this->roster->add($employee);
        $this->repeat();
    }
    

    private function deleteMenu() {
        $this->clear();
        echo "***************************************************\n";
        echo "***   List of Employees on the Current Roster   ***\n";
        echo "***************************************************\n";
    
        $this->roster->display(); 

        if ($this->roster->count() === 0) {
            echo "No employees in the roster.\n";
            readline("Press \"Enter\" key to return to the main menu...");
            $this->entrance();
            return;
        }
    
        $rosterSize = $this->size; 
        $employeeNumber = (int)readline("\nEnter the employee number to delete (or any key to return): ");
    
        if ($employeeNumber === 0) {
            $this->entrance();
            return;
        }
    
        // Validate input
        if ($employeeNumber < 1 || $employeeNumber > $rosterSize) {
            echo "Error: Invalid input. Employee number must be between 1 and $rosterSize.\n";
            readline("Press \"Enter\" key to continue...");
            $this->deleteMenu();
            return;
        }
    
        // Check if the slot is already empty
        if (!$this->roster->exists($employeeNumber - 1)) {
            echo "Error: Slot #$employeeNumber is already empty.\n";
            readline("Press \"Enter\" key to continue...");
            $this->deleteMenu();
            return;
        }
    
        // Confirm and delete the employee
        $confirmDelete = strtolower(readline("Are you sure you want to delete Employee #$employeeNumber? (y/n): "));
        if ($confirmDelete === 'y') {
            $this->roster->remove($employeeNumber - 1); 
            echo "Employee #$employeeNumber has been removed.\n";
        } else {
            echo "Operation canceled. No employee was deleted.\n";
        }
    
        // Update and show the available slots
        echo "Available space on the roster: " . $this->roster->availableSpace() . "\n";
    
        // Ask if the user wants to continue deleting
        $continue = strtolower(readline("Press \"y\" to continue removing or any other key to return to the main menu: "));
        if ($continue === 'y') {
            $this->deleteMenu(); 
        } else {
            $this->entrance(); 
        }
    }
    
    

    private function otherMenu() {
        $this->clear();
        echo "[1] Display Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
            switch ($choice) {
                case 1:
                    $this->displayMenu();
                    break;
                case 2:
                    $this->countMenu();
                    break;
                case 3:
                    $this->roster->payroll();
                    break;
                case 0:
                    $this->entrance();
                    break;
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->otherMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->otherMenu();
    }

    private function displayMenu() {
        $this->clear();
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
            switch ($choice) {
                case 1:
                    $this->roster->display();
                    break;
                case 2:
                    $this->roster->displayCE();
                    break;
                case 3:
                    $this->roster->displayHE();
                    break;
                case 4:
                    $this->roster->displayPE();
                    break;
                case 0:
                    return $this->otherMenu();
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->displayMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->displayMenu();
    }

    private function countMenu() {
        $this->clear();
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return\n";
        $choice = (int)readline("Select Menu: ");

        try {
            switch ($choice) {
                case 1:
                    echo $this->roster->count() . "\n";
                    break;
                case 2:
                    echo  $this->roster->countCE() . "\n";
                    break;
                case 3:
                    echo  $this->roster->countHE() . "\n";
                    break;
                case 4:
                    echo  $this->roster->countPE() . "\n";
                    break;
                case 0:
                    return $this->otherMenu();
                default:
                    throw new InvalidOptionException("Invalid input. Please try again.");
            }
        } catch (InvalidOptionException $e) {
            echo $e->getMessage() . "\n";
            readline("Press \"Enter\" key to continue...");
            $this->countMenu();
        }
        readline("Press \"Enter\" key to continue...");
        $this->countMenu();
    }

    private function clear() {
        echo "\033[2J\033[;H";
    }

    private function repeat() {
        if ($this->roster->count() < $this->size) {
            $c = readline("Add more? (y to continue or n to return): ");
            if (strtolower($c) == 'y') {
                $this->addMenu();
            }
            if (strtolower($c) == 'n' && 'no') {
                $this->entrance();
            }
            else {
                exit();
                
            }
        } else {
            echo "Roster is Full\n";
            readline("Press \"Enter\" key to continue...");
            $this->entrance();
        }
    }
}


?>
