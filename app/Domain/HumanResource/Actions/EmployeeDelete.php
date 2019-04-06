<?php

namespace Domain\HumanResource\Actions;

use Domain\HumanResource\Models\Employee;

class EmployeeDelete
{
    /**
     * Delete an employee
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
