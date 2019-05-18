<?php

namespace Domain\Administration\ValueObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CompanyData extends DataTransferObject
{
    /** @var string|null */
    public $company_name_kh;

    /** @var string */
    public $company_name_en;

    /** @var string|null */
    public $logo;

    /** @var string|null */
    public $type_of_business;

    /** @var string */
    public $telephone;

    /** @var string|null */
    public $mobilephone;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $website;

    /** @var string|null */
    public $postcode;

    /** @var string */
    public $building;

    /** @var string */
    public $street;

    /** @var string */
    public $village;

    /** @var string */
    public $commune;

    /** @var string */
    public $district;

    /** @var string */
    public $province;

    /**
     * Get data from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self($request->all());
    }
}
