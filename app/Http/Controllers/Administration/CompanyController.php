<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Domain\Administration\Actions\CompanyCreate;
use Domain\Administration\Models\Company;
use Domain\Administration\ValueObjects\CompanyData;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
        $this->authorize('create', Company::class);

        $request->validate([
            'company_name_en' => 'required',
            'telephone' => 'required',
            'building' => 'required',
            'street' => 'required',
            'village' => 'required',
            'commune' => 'required',
            'district' => 'required',
            'province' => 'required',
        ], [
            '*.required' => 'Required'
        ]);

        $company = (new CompanyCreate)->execute(CompanyData::fromRequest($request));

        return (new CompanyResource($company))->additional(['message' => 'Company created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
