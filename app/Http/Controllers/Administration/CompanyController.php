<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Domain\Administration\Actions\CompanyCreate;
use Domain\Administration\Actions\CompanyUpdate;
use Domain\Administration\Models\Company;
use Domain\Administration\ValueObjects\CompanyData;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Company::class);

        $companies = Company::when($request->search, function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('company_name_en', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('company_name_kh', 'LIKE', '%' . $request->search . '%');
            });
        })
            ->paginate($request->perPage);

        return CompanyResource::collection($companies);
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
            'address' => 'required',
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
     * @param  \Domain\Administration\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Domain\Administration\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $request->validate([
            'company_name_en' => 'required',
            'telephone' => 'required',
            'address' => 'required',
            'province' => 'required',
        ], [
            '*.required' => 'Required'
        ]);

        $company = (new CompanyUpdate)->execute($company, CompanyData::fromRequest($request));

        return (new CompanyResource($company))->additional(['message' => 'Company updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Domain\Administration\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response()->json(['message' => 'Company deleted']);
    }
}
