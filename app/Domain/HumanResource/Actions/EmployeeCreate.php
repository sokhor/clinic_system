<?php

namespace Domain\HumanResource\Actions;

use Domain\HumanResource\Models\Employee;
use Domain\HumanResource\ValueObjects\EmployeeData;

class EmployeeCreate
{
    /**
     * Create a new employee
     *
     * @param \Domain\HumanResource\ValueObjects\EmployeeData $employeeData
     * @return \Domain\HumanResource\Models\Employee
     */
    public function execute(EmployeeData $employeeData)
    {
        return Employee::create($employeeData->toArray());
    }
}
