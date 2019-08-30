<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Contact extends Model
{
    protected $guarded = [];

    protected $dates  = ['birthday'];

    // mutator 
    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = Carbon::parse($birthday);
    }

    public function path()
    {
        return url('/contacts/' . $this->id);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
