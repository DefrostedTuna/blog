<?php

class ImageController extends BaseController {

	public function getManage($slug) {

		$post = Post::findBySlug($slug);

		return 	View::make('image.manage')
				->with('post', $post);
	}

	public function getView($filename) {
		/*
		** Return raw image
		*/
		$image = Image::findByFilename($filename);

		$response = Response::make(
            File::get(public_path() . $image->path),
            200
        );

        $response->header(
            'Content-type',
            $image->type
        );

		return $response ;
}
 
	public function postAdd($slug) {

		$images 	= Input::file('images');
		$post_id 	= Input::get('post_id');
		$post 		= Post::findBySlug($slug);

		$success 	= array();
		$failed 	= array();

		if($post_id != $post->id) {
			return 	Redirect::route('post-update', $slug)
					->withInput()
					->with('global', 'There was a problem finding the post requested.')
					->with('alert', 'alert');
		}

		if(!Input::hasFile('images')) {
			return 	Redirect::route('image-add', $post->slug)
					->with('global', 'You must supply an image to upload.')
					->with('alert', 'alert')
					->with('post', $post);
		}

		foreach($images as $image) {
			$validator = Validator::make(
				array(
					'image' => $image
				), 
				array(
					'image' => 'required|image'
				));

			if($validator->fails()) {

				$failed[] = $image->getClientOriginalName();

			} else {

				$ext 			= '.' . $image->getClientOriginalExtension();
				$type 			= $image->getMimeType();
				$filename 		= time() . '_' . str_random(5) . $ext;
				$relative_path 	= '/uploads/' . Str::slug(Auth::user()->username) . '/images/';
				$stored_path 	= $relative_path . $filename;
				$thumb_path		= $relative_path . 'thumb/' . $filename;

				$saved_image 	= $image->move(public_path() . $relative_path, $filename);
				$thumb = ImageProc::make($saved_image->getRealPath())->widen(320)->crop(320, 240)->save(public_path() . $thumb_path);

				$create = Image::create(array(
						'post_id' 	=> $post->id,
						'filename' 	=> $filename,
						'path' 		=> $stored_path,
						'thumb' 	=> $thumb_path,
						'type' 		=> $type
					));

				if($create) {

					$success[] = $image->getClientOriginalName();

				} else {

					File::delete($saved_image);
					$failed[] = $image->getClientOriginalName();
				}
			}

		}
		//fallback error
		return 	Redirect::route('image-manage', $post->slug)
				->with('success', $success)
				->with('failed', $failed);

	}

	public function postDelete($slug) {

		$image_id    = Input::get('image_id');
		
		$image       = Image::findOrFail($image_id);
		$post        = Post::findBySlug($slug);
		
		$local_file  = File::delete(public_path() . $image->path);
		$local_thumb = File::delete(public_path() . $image->thumb);

		if($image->delete()) {
			return 	Redirect::route('image-manage', $post->slug);
		} else {
			return 	Redirect::route('image-manage', $post->slug)
					->with('global', 'There was a problem deleting the requested image.')
					->with('alert', 'alert');
		}
		//fallback error
		return 	Redirect::route('image-manage', $post->slug)
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert');
	}

}