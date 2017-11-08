<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\User;
use App\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class GalleryController extends Controller
{
    public function index() {
    	$galleries = Gallery::with('images')->get();
    	return $galleries;
    }
    public function show($id) {
    	return self::with('images')->find($id);
    }
    public function store(Request $request) {
    	
        $gallery = new Gallery();
        $rules = Gallery::STORE_RULES;
        $request->validate($rules);

        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');
        
        $existingGallery = Gallery::where('name', '=', Input::get('name'))->first();
        if (!$existingGallery) {
            $gallery->save();
            return $gallery;
        }
        echo ('The gallery with same name is already in database.');


    }
    public function update(Request $request, $id) {
    	$gallery = Gallery::find($id);

    	if(! $gallery) {
    		return response()->json(['message' => 'Gallery not found'], 404);
    	}
    	$gallery->name = $request->input('name');
    	$gallery->description = $request->input('description');
    	$gallery->save();
    	return $gallery;
    }
    public function destroy($id) {

    	$gallery = Gallery::find($id);
        $gallery->delete();
        return response()->json(['message' => 'Gallery deleted'], 200);
    }

}
