<?php

namespace App\Listeners;

use Domain\Administration\ValueObjects\CompanyData;
use Domain\Administration\Actions\CompanyCreate;
use Illuminate\Auth\Events\Registered;

class CreateCompany
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        (new CompanyCreate)->execute(CompanyData::fromArray([
            'user_id' => $event->user->id
        ]));
    }
}
