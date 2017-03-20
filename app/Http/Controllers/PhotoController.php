<?php namespace LaraCall\Http\Controllers;

use LaraCall\Photo;
use LaraCall\PhotoAlbum;

class PhotoController extends Controller {

    public function show($id)
	{
        $photo_album = PhotoAlbum::find($id);
        $photos = Photo::where('photo_album_id', $id)->get();

        return view('photo.view_album',compact('photos','photo_album'));
	}

}
