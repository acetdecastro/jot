<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return request()->user()->contacts;
    }

    public function store(ContactRequest $request)
    {
        $this->authorize('create', Contact::class);

        request()->user()->contacts()->create($request->validated());
    }
    
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        
        return $contact;
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update($request->validated()); 
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        $contact->delete();
    }
}