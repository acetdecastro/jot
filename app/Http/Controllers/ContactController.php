<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    private function isContactOwnedByAuthenticatedUser($contact)
    {
        if (request()->user()->isNot($contact->user)) {
            return false;
        } else {
            return true;
        }
    }

    public function index()
    {
        return request()->user()->contacts;
    }

    public function store(ContactRequest $request)
    {
        request()->user()->contacts()->create($request->validated());
    }
    
    public function show(Contact $contact)
    {
        if ($this->isContactOwnedByAuthenticatedUser($contact)) {
            return $contact;
        } else {
            return response([], 403);
        }
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        if ($this->isContactOwnedByAuthenticatedUser($contact)) {
            $contact->update($request->validated());
        } else {
            return response([], 403);
        }       
    }

    public function destroy(Contact $contact)
    {
        if ($this->isContactOwnedByAuthenticatedUser($contact)) {
            $contact->delete();
        } else {
            return response([], 403);
        }
    }
}