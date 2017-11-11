<?php

namespace App;
use App\Comment;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='users';
    protected $guarded = ['id'];
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'password_confirm', 'acceptedTerms'
    ];
    protected $casts = ['accepted_terms' => 'boolean'];
    
    // mutator
    public function setAcceptedTermsMutator($value){
        $this->attributes['accepted_terms'] = (boolean)$value;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTcustomClaims() {
        return [];
    }

    public function galleries() {

        return $this->hasMany(Gallery::class, 'user_id');
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'author_id');
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
