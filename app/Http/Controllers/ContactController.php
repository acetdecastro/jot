<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Contact::class);

        return ContactResource::collection(request()->user()->contacts);
    }

    public function store(ContactRequest $request)
    {
        $this->authorize('create', Contact::class);

        request()->user()->contacts()->create($request->validated());
    }
    
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);
        
        return new ContactResource($contact);
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