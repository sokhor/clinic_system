<?php

namespace Domain\Administration\Actions;

use Domain\Administration\Models\Company;
use Domain\Administration\ValueObjects\CompanyData;

class CompanyCreate
{
    /**
     * Create a new company
     *
     * @param \Domain\HumanResource\ValueObjects\CompanyData $companyData
     * @return \Domain\HumanResource\Models\Company
     */
    public function execute(CompanyData $companyData)
    {
        return Company::create($companyData->toArray());
    }
}
