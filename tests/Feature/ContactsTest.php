<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Contact;
use Carbon\Carbon;

class ContactsTest extends TestCase
{
    // use RefreshDatabase;

    protected $user;

    /*
    * This method runs before any test runs
    * Creates a user on every test
    * returns void
    */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    private $requiredFields = [
        'name',
        'email',
        'birthday',
        'company',
    ];

    private function validData()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '03/17/1993',
            'company' => 'ABC Company',
            'api_token' => $this->user->api_token,
        ];
    }

    /** @test */
    public function unauthenticatedUserRedirectedToLoginWhenAddingContact()
    {
        $response = $this->post(
            '/api/contacts',
            array_merge($this->validData(), ['api_token' => ''])
        );

        $response->assertRedirect('/login');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    /*
    * 2 users and one contact for eacch
    * First user is the one made on setUp()
    */
    public function fetchAllContactsOfAuthenticatedUser()
    {   
        $anotherUser = factory(User::class)->create();

        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);
        $anotherContact = factory(Contact::class)->create(['user_id' => $anotherUser->id]);

        $response = $this->get('/api/contacts?api_token=' . $this->user->api_token);

        /* 
        * Asserts that there is a JSON returned
        * Asserts that the contact id is equal to the first user's related contact
        */
        $response->assertJsonCount(1);
        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'id' => $contact->id
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function anAuthenticatedUserCanAddAContact()
    {
        $response = $this->post('/api/contacts', $this->validData());

        $contact = Contact::first();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('03/17/1993', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC Company', $contact->company);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);
    }

    /** @test */
    public function fieldsAreRequired()
    {
        collect($this->requiredFields)
            ->each(function ($field) {
                $response = $this->post(
                    '/api/contacts',
                    array_merge($this->validData(), [$field => ''])
                );

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Contact::all());
            });
    }

    /** @test */
    public function emailMustBeValid()
    {
        $response = $this->post(
            '/api/contacts',
            array_merge($this->validData(), ['email' => 'not an email'])
        );

        $response->assertSessionHasErrors('email');
        $this->assertCount(0, Contact::all());
    }

    /** @test */
    public function birthdayMustBeValid()
    {
        $response = $this->post(
            '/api/contacts',
            array_merge($this->validData(), ['birthday' => 'March 17, 1993'])
        );

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('03-17-1993', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test */
    public function aContactCanBeRetrieved()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->get(
            '/api/contacts/' . $contact->id . 
            '?api_token=' . $this->user->api_token
        );

        $response->assertJson([
            'data' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'birthday' => $contact->birthday->format('m/d/Y'),
                'company' => $contact->company,
                'last_updated' => $contact->updated_at->diffForHumans(),
            ] 
        ]);
    }

    /** @test */
    public function aContactCanBeRetrievedOnlyByItsUser()
    {
        // First user is the one made on setUp()
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $anotherUser = factory(User::class)->create();

        $response = $this->get(
            '/api/contacts/' . $contact->id . 
            '?api_token=' . $anotherUser->api_token
        );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function aContactCanBePatched()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->patch('/api/contacts/' . $contact->id, $this->validData());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('03-17-1993', $contact->birthday->format('m-d-Y'));
        $this->assertEquals('ABC Company', $contact->company);
        
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path()
            ]
        ]);
    }

    /** @test */
    public function aContactCanBePatchedOnlyByItsUser()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->patch(
            '/api/contacts/' . $contact->id,
            array_merge($this->validData(), ['api_token' => $anotherUser->api_token])
        );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function aContactCanBeDeleted()
    {
        $contact = factory(Contact::class)->create(['user_id' => $this->user->id]);

        $response = $this->delete(
            '/api/contacts/' . $contact->id,
            ['api_token' => $this->user->api_token]
        );

        $this->assertCount(0, Contact::all());

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function aContactCanBeDeletedOnlyByItsUser()
    {
        $contact = factory(Contact::class)->create();

        $anotherUser = factory(User::class)->create();

        $response = $this->delete(
            '/api/contacts/' . $contact->id,
            ['api_token' => $this->user->api_token]
        );

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
