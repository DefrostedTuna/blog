<?php

class Image extends Eloquent {

	protected $fillable = array("post_id", "filename", "path", "thumb", "type");

	public function post() {
		return $this->belongsTo('Post', 'post_id');
	}

	public function owner() {
		return $this->belongsTo('User', 'owner_id');
	}

	public static function findByFilename($filename) {
		return Image::where('filename', '=', $filename)->first();
	}

}