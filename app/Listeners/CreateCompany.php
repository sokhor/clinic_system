<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Domain\Administration\ValueObjects\CompanyData;
use Domain\Administration\Actions\CompanyCreate;

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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        (new CompanyCreate)->execute(CompanyData::fromArray([
            'user_id' => $event->user->id
        ]));
    }
}
