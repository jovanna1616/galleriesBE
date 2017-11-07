<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'password_confirm', 'acceptedTerms'
    ];
    const STORE_RULES = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required | email',
        // size:
        // required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/
        // https://stackoverflow.com/questions/3180354/regex-check-if-string-contains-at-least-one-digit
        'password' => 'required | confirmed | min:8',
        'password_confirm' => 'required | same:password',
        'accepted_terms' => 'required'
    ];

    // mutator
    public function setAcceptedTermsMutator($value){
        $this->attributes['accepted_terms'] = (boolean)$value;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
