<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyLogoRequest;
use Domain\Administration\Models\Company;

class CompanyLogoUploadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CompanyLogoRequest $request)
    {
        $filePath = $request->logo->store('companies');

        return response()->json(['data' => $filePath], 201);
    }
}
