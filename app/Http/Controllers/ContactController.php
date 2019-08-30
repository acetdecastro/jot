<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());
    }
    
    public function show(Contact $contact)
    {
        return $contact;
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->validated());
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
    }
}
