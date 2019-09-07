<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Contact;
use Carbon\Carbon;

class BirthdaysTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function contacts_with_birthdays_in_the_current_month_can_be_fetched()
    {
        $user = factory(User::class)->create();

        $contactWithBirthdayInTheCurrentMonth = factory(Contact::class)->create([
            'user_id' => $user->id,
            'birthday' => now(),
        ]);

        $contactWithoutBirthdayInTheCurrentMonth = factory(Contact::class)->create([
            'user_id' => $user->id,
            'birthday' => now()->subMonth(), // now minus 1 month
        ]);

        $this->get('api/birthdays?api_token=' . $user->api_token)
            ->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        'data' => [
                            'id' => $contactWithBirthdayInTheCurrentMonth->id
                        ]
                    ]
                ]
            ]);
    }
}
