<?php

namespace Domain\Administration\ValueObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class CompanyData extends DataTransferObject
{
    /** @var string|null */
    public $company_name_kh;

    /** @var string|null */
    public $company_name_en;

    /** @var string|null */
    public $logo;

    /** @var string|null */
    public $type_of_business;

    /** @var string|null */
    public $telephone;

    /** @var string|null */
    public $mobilephone;

    /** @var string|null */
    public $email;

    /** @var string|null */
    public $website;

    /** @var string|null */
    public $street;

    /** @var int|null */
    public $village;

    /** @var int|null */
    public $commune;

    /** @var int|null */
    public $district;

    /** @var string|null */
    public $province;

    /** @var string|null */
    public $postcode;

    /** @var int */
    public $user_id;

    /**
     * Get data from request.
     *
     * @param \Illuminate\Http\Request $request
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        return new self($request->only([
            'user_id',
            'company_name_kh',
            'company_name_en',
            'logo',
            'type_of_business',
            'telephone',
            'mobilephone',
            'email',
            'website',
            'street',
            'village',
            'commune',
            'district',
            'province',
            'postcode',
        ]));
    }

    /**
     * Get data from array.
     *
     * @param array $attribute
     * @return self
     */
    public static function fromArray(array $attribute): self
    {
        return new self($attribute);
    }
}
