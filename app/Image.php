<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id'];
    protected $fillable = ['link'];

    const STORE_RULES = [
        'link' => 'required'
    ];

    public function gallery() {
    	return $this->belongsTo(Gallery::class);
    }
}
