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
            ->orderByRaw('created_at DESC')
            ->paginate(10);
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

        // opcija za dodavanje novih slika
        $image = new Image();
        $rules = Image::STORE_RULES;
        $request->validate($rules);
        $image->link = $request->input('link');
        
        // pre cuvanja provera ukoliko vec postoji
        $existingGallery = Gallery::where('name', '=', Input::get('name'))->first();
        if (!$existingGallery) {
            $gallery->save();
            $image->gallery_id = $gallery->id;
            $image->save();
            return $gallery;
        }
        echo ('The gallery with same name is already in database.');
    }
    public function update(Request $request, $id) {
    	$gallery = Gallery::with('images')->find($id);
        // var_dump($gallery->images);
        // die();
        // $images = $gallery->images;
        // var_dump($images);
        // die();
        // foreach ($images as $image => $link) {
        //     $links[] = $link->link;
        // }
        // $images = Image::where('gallery_id', '=', $id)->get();
        
       
    	if(! $gallery) {
    		return response()->json(['message' => 'Gallery not found'], 404);
    	}
    	$gallery->name = $request->input('name');
    	$gallery->description = $request->input('description');
    	$gallery->save();
        $image->save();
    	return $gallery;
    }
    public function destroy($id) {
    	$gallery = Gallery::with('images')->find($id);
        $gallery->delete();
        return response()->json(['message' => 'Gallery deleted'], 200);
    }
}
