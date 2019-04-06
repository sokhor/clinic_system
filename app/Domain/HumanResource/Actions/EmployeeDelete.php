<?php

namespace Domain\HumanResource\Actions;

use Domain\HumanResource\Models\Employee;

class EmployeeDelete
{
    /**
     * Create a new employee
     *
     * @param \Domain\HumanResource\Models\Employee $employee
     * @return \Domain\HumanResource\Models\Employee
     */
    public function execute(Employee $employee)
    {
        $employee->delete();

        return $employee;
    }
}
