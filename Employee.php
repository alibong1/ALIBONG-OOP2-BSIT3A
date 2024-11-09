 <?php
    require_once 'Person.php';

    abstract class Employee extends Person {
        private $employeeId;    
        private $companyName;
        

        public function __construct($name, $address, $age, $companyName) {
            parent::__construct($name, $address, $age);
            $this->companyName = $companyName;
        }

        public function getEmployeeId() {
            return $this->employeeId;
        }

        public function setEmployeeId($employeeId) {
            $this->employeeId = $employeeId;
        }
        public function getCompanyName() {
            return $this->companyName;
        }

        abstract public function earnings();

        public function toString() {
            return "Employee ID: $this->employeeId\n" . parent::toString() . "\nCompany: $this->companyName";
        }
    }
    ?>
