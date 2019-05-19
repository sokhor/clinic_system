<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Responses\ImageResponse;
use Domain\Administration\Models\Company;
use Illuminate\Http\Request;

class CompanyLogoController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $companyId
     * @return \Illuminate\Http\Response
     */
    public function show($companyId)
    {
        $company = Company::findOrFail($companyId);

        return new ImageResponse($company->logo);
    }
}
