<?php

namespace Domain\HumanResource\ValueObjects;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Support\Carbon;

class EmployeeData extends DataTransferObject
{
    /** @var string */
    public $name_native;

    /** @var string */
    public $name_latin;

    /** @var \Illuminate\Support\Carbon|string */
    public $born;

    /** @var string */
    public $gender;

    /** @var string */
    public $marital;

    /** @var string */
    public $emp_no;

    /** @var array|null */
    public $address;

    /** @var int */
    public $position_id;

    /** @var string */
    public $id_card_type;

    /** @var string */
    public $id_card_no;

    /** @var \Illuminate\Support\Carbon|string */
    public $hiring_date;

    /** @var string */
    public $hiring_status;

    /**
     * Create a new value object instance
     *
     * @param array   $params
     */
    public function __construct(array $params)
    {
        $this->name_native = $params['name_native'];
        $this->name_latin = $params['name_latin'];
        $this->born = Carbon::createFromFormat(config('app.date_format'), $params['born'])->startOfDay();
        $this->gender = $params['gender'];
        $this->marital = $params['marital'];
        $this->emp_no = $params['emp_no'];
        $this->address = $params['address'];
        $this->position_id = $params['position_id'];
        $this->id_card_type = $params['id_card_type'];
        $this->id_card_no = $params['id_card_no'];
        $this->hiring_date = Carbon::createFromFormat(config('app.date_format'), $params['hiring_date'])->startOfDay();
        $this->hiring_status = $params['hiring_status'];
    }

    /**
     * Get data from array.
     *
     * @param array $input
     * @return self
     */
    public static function fromArray(array $input): self
    {
        return new self($input);
    }
}
