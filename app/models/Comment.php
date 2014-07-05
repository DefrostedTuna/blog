<?php

class Comment extends Eloquent {

	protected $fillable = array("post_id", "name", "body", "approved");

	public function post() {
		return $this->belongsTo('Post', 'post_id');
	}

	public static function pending() { 
		return Comment::where('approved', '=', '0')->get();
	}

	public static function getRecent() {
		return Comment::orderBy('created_at', 'desc')->take(5)->get();
	}

    public function published() {
        return $this->created_at->format('D F jS, Y'); //format('D M d, Y')
    }

    public function publishedShort() {
        return $this->created_at->format('F jS, Y'); //format('M d, Y')
    }

}