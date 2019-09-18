<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\Contact as ContactResource;

class BirthdayController extends Controller
{
    public function index()
    {       
        $contacts = request()->user()->contacts()->birthdays()->get();
        
        return ContactResource::collection($contacts);
    }
}
