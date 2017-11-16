<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $guarded = ['id'];
    protected $fillable = ['text', 'author_id'];

    const STORE_RULES = [
        'text' => 'max:1000',
    ];
    
    public function user() {
    	return $this->belongsTo(User::class);
    }
}
