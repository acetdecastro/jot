<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Contact;
use Carbon\Carbon;

class ContactTest extends TestCase
{
    use RefreshDatabase;

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
        ];
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
        $this->withoutExceptionHandling();

        $response = $this->post(
            '/api/contacts',
            array_merge($this->validData(), ['birthday' => 'March 17, 1993'])
        );

        $this->assertCount(1, Contact::all());
        $this->assertInstanceOf(Carbon::class, Contact::first()->birthday);
        $this->assertEquals('03-17-1993', Contact::first()->birthday->format('m-d-Y'));
    }

    /** @test */
    public function aContactCanBeAdded()
    {
        $this->withoutExceptionHandling();

        $this->post('/api/contacts', [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '03/17/1993',
            'company' => 'ABC Company',
        ]);

        $contact = Contact::first();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('03/17/1993', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC Company', $contact->company);
    }

    /** @test */
    public function aContactCanBeRetrieved()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->get('/api/contacts/' . $contact->id);

        $response->assertJson([
            'name' => $contact->name,
            'email' => $contact->email,
            'birthday' => $contact->birthday,
            'company' => $contact->company,
        ]);
    } 

    /** @test */
    public function aContactCanBePatched()
    {
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create();

        $response = $this->patch('/api/contacts/' . $contact->id, $this->validData());

        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('03-17-1993', $contact->birthday->format('m-d-Y'));
        $this->assertEquals('ABC Company', $contact->company);
    } 

    /** @test */
    public function aContactCanBeDeleted()
    {
        $this->withoutExceptionHandling();

        $contact = factory(Contact::class)->create();

        $this->delete('/api/contacts/' . $contact->id);

        $this->assertCount(0, Contact::all());
    }    
}
