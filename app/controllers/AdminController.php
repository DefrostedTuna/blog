<?php

class AdminController extends BaseController {

	public function getIndex() {

		$pending_comments = Comment::pending();

		return 	View::make('admin.dashboard')
				->with('pending_comments', $pending_comments);
	}
}