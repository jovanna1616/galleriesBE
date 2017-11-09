<?php

namespace App;
use App\Gallery;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = ['id', 'gallery_id'];
    protected $fillable = ['link'];

    public function gallery() {
    	return $this->belongsTo(Gallery::class);
    }
}
