<?php

namespace Domain\HumanResource\Actions;

use Domain\HumanResource\Models\Employee;
use Domain\HumanResource\ValueObjects\EmployeeData;

class EmployeeUpdate
{
    /**
     * Update an employee
     *
     * @param \Domain\HumanResource\Models\Employee $employee
     * @param \Domain\HumanResource\ValueObjects\EmployeeData $employeeData
     * @return \Domain\HumanResource\Models\Employee
     */
    public function execute(Employee $employee, EmployeeData $employeeData)
    {
        $employee->update($employeeData->toArray());

        return $employee->fresh();
    }
}
