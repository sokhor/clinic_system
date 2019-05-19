<?php

namespace Domain\Administration\Actions;

use Domain\Administration\Models\Company;
use Domain\Administration\ValueObjects\CompanyData;

class CompanyUpdate
{
    /**
     * Create a new company
     *
     * @param  \Domain\Administration\Models\Company  $company
     * @param  \Domain\HumanResource\ValueObjects\CompanyData $companyData
     * @return \Domain\HumanResource\Models\Company
     */
    public function execute($company, CompanyData $companyData)
    {
        $company->fill($companyData->toArray());

        return !$company->save() ?: $company->fresh();
    }
}
