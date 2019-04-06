<?php

namespace App\Http\Controllers\HumanResource;

use Domain\HumanResource\Models\Employee;
use Domain\HumanResource\Actions\EmployeeCreate;
use Domain\HumanResource\ValueObjects\EmployeeData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = (new EmployeeCreate)->execute(
            EmployeeData::fromArray($request->all())
        );

        return new EmployeeResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Domain\HumanResource\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Domain\HumanResource\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Domain\HumanResource\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
