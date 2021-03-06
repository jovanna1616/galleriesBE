<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Comment;
use App\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class GalleryController extends Controller
{
    public function index() {
    	$galleries = Gallery::with('images')
            ->with('user')
            ->with('comments')
            ->orderByRaw('created_at DESC')
            ->paginate();
    	return $galleries;
    }
    public function show($id) {
    	$gallery = Gallery::with('images')
            ->with('user')
            ->find($id);
        return $gallery;
    }
    public function store(Request $request) {
    	// validacija
        $gallery = new Gallery();
        $rules = Gallery::STORE_RULES;
        $request->validate($rules);
        // novi podaci
        $gallery->name = $request->input('name');
        $gallery->description = $request->input('description');
        // for testing:
        $gallery->user_id = 2;

        
        // pre cuvanja provera ukoliko vec postoji
        $existingGallery = Gallery::where('name', '=', Input::get('name'))->first();
        if (!$existingGallery) {
            $gallery->save();

            // opcija za dodavanje novih slika sa FE
            $images = $request->input('links');

            foreach ($images as $url) {
                $image = new Image();
                $image->link = $url;
                $image->gallery_id = $gallery->id;
                $image->save();
            }
            return $gallery;
        }
        echo ('The gallery with same name is already in database.');
    }

    public function update(Request $request, $id) {
    	$gallery = Gallery::find($id);

        if(! $gallery) {
            return response()->json(['message' => 'Gallery not found'], 404);
        }
        
        $gallery->images()->delete();
        $images = $request->input('images');
        $image = new Image();
        $rules = Image::STORE_RULES;
        $request->validate($rules);
        $image->link = $request->input('link');
       
    	
    	$gallery->name = $request->input('name');
    	$gallery->description = $request->input('description');
    	$gallery->save();

        $image->gallery_id = $gallery->id;
        $image->save();
    	return $gallery;
    }
    public function destroy($id) {
    	$gallery = Gallery::with('images')->find($id);
        $gallery->delete();
        return response()->json(['message' => 'Gallery deleted'], 200);
    }
}
