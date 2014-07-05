<?php

class PostController extends BaseController {

	public function getManage() {

		$posts = Post::orderBy('created_at', 'desc')->paginate(10);

		return 	View::make('post.manage')
				->with('posts', $posts);
	}

	public function getList() {

		$posts = Post::getVisible(10);

		return 	View::make('post.list')
				->with('posts', $posts);
	}

	public function getTag() {
		return View::make('post.tag');
	}

	public function getSlug($slug) {

		$post = Post::findBySlug($slug);

		//check if post is available to public and redirect if returns false
		if(!$post->visible) {
			return 	Redirect::route('home')
					->with('global', 'That post not available at this time.')
					->with('alert', 'alert');
		}

		return 	View::make('post.slug' )
				->with('post', $post);
	}

	public function getArchive() {

		$years_obj     = Post::archiveByYear();
		
		$archive_array = array();

		//Assign array to YEAR->MONTH->POST(obj)
		foreach($years_obj as $years) {
			foreach(Post::archiveByMonth($years->year) as $months) {
				foreach(Post::getMonth($months->month) as $archived_post) {
					$archive_array[$years->year][$months->month_name][] = $archived_post;
				}
			}
		}

		return 	View::make('post.archive')
				->with('archives', $archive_array);

	}

	public function getCreate() {
		return View::make('post.create');
	}

	public function postCreate() {
		$validator = Validator::make(Input::all(), array(
				'title' 	=> 'required|min:3|max:100',
				'body' 		=> 'required|min:3',
				'image' 	=> 'image',
			));

		if($validator->fails()) {
			return 	Redirect::route('post-create')
					->withErrors($validator)
					->withInput();
		} else {

			$author_id 	= Auth::user()->id;

			$title 		= Input::get('title');
			$visible	= Input::has('visible') ? true : false;
			$featured 	= Input::has('featured') ? true : false;
			$body 		= Input::get('body');

			$cover_photo = '';

			if(Input::hasFile('image')) {

				$file 			= Input::file('image');

				$ext 			= '.' . $file->getClientOriginalExtension();
				$filename 		= 'cover_' . time() . $ext;
				$relative_path 	= '/uploads/' . Str::slug(Auth::user()->username) . '/cover-images/';
				$cover_photo 	= $relative_path . $filename;
				
				$save_image 	= ImageProc::make($file->getRealPath())->widen(1280)->crop(1280, 400)->save(public_path() . $relative_path . $filename);
			}

			$post = Post::create(array(
					'author_id' 	=> $author_id,
					'title' 		=> $title,
					'visible'		=> $visible,
					'featured' 		=> $featured,
					'cover_photo' 	=> $cover_photo,
					'body' 			=> $body
				));

			if($post) {

				return 	Redirect::route('admin-dashboard')
						->with('global', 'The post has been created.')
						->with('alert', 'success');
			} else {
				return 	Redirect::route('post-create')
						->with('global', 'There was a problem creating the post.')
						->with('alert', 'alert')
						->withInput();				
			}
		}
		//fallback error
		return 	Redirect::route('admin-dashboard')
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert');
	}

	public function getUpdate($slug) {

		$post = Post::findBySlug($slug);

		return 	View::make('post.update')
				->with('post', $post);
	}

	public function postUpdate($slug) {
		$validator = Validator::make(Input::all(), array(
				'body' 		=> 'required|min:3',
				'image' 	=> 'image'
			));

		if($validator->fails()) {
			return 	Redirect::route('post-update', $slug)
					->withErrors($validator)
					->withInput();
		} else {

			$post 		= Post::findBySlug($slug);
			$post_id 	= Input::get('post_id');

			if($post_id != $post->id) {
				return 	Redirect::route('post-update', $slug)
						->withInput()
						->with('global', 'There was a problem finding the post requested.')
						->with('alert', 'alert');
			}

			$visible	= Input::has('visible') ? true : false;
			$featured 	= Input::has('featured') ? true : false;
			$body		= Input::get('body');

			if($post->cover_photo) {
				$cover_photo = $post->cover_photo;
			} else {
				$cover_photo = '';
			}

			if(Input::hasFile('image')) {

				if($post->cover_photo) {
					File::delete(public_path() . $post->cover_photo);
				}

				$file 			= Input::file('image');

				$ext 			= '.' . $file->getClientOriginalExtension();
				$filename 		= 'cover_' . time() . $ext;
				$relative_path 	= '/uploads/' . Str::slug(Auth::user()->username) . '/cover-images/';
				$cover_photo 	= $relative_path . $filename;
				
				$save_image 	= ImageProc::make($file->getRealPath())->widen(1280)->crop(1280, 400)->save(public_path() . $relative_path . $filename);
			}

			$post->update(array(
					'visible' 		=> $visible,
					'featured' 		=> $featured,
					'cover_photo' 	=> $cover_photo,
					'body'			=> $body
				));

			if($post) {
				return 	Redirect::route('post-slug', $post->slug)
						->with('global', 'The post has been updated successfully')
						->with('alert', 'success');
			} else {
				return 	Redirect::route('post-manage')
						->with('global', 'There was a problem updating the post')
						->with('alert', 'alert'); 
			}
		}
		//fallback error
		return 	Redirect::route('post-update', $slug)
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert');
	}

	public function postDeleteCover($slug) {

		$post 		= Post::findBySlug($slug);
		$post_id 	= Input::get('post_id');

		if($post_id != $post->id) {
			return 	Redirect::route('post-update', $slug)
					->withInput()
					->with('global', 'There was a problem finding the post requested.')
					->with('alert', 'alert');
		}

		File::delete(public_path() . $post->cover_photo);

		$update = $post->update(array(
				'cover_photo' => ''
			));

		if($update) {
			return 	Redirect::route('post-update', $post->slug)
					->with('global', 'The image has been removed successfully.')
					->with('alert', 'success')
					->withInput();
		} else {
			return 	Redirect::route('post-update', $post->slug)
					->with('global', 'There was a problem removing the requested image.')
					->with('alert', 'alert')
					->withInput();			
		}
		//fallback error
		return 	Redirect::route('post-update', $post->slug)
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert')
				->withInput();
	}

	public function postDelete($slug) {
		
		$post    = Post::findBySlug($slug);
		$post_id = Input::get('post_id');

		if($post_id != $post->id) {
			return 	Redirect::route('post-manage')
					->with('global', 'There was a problem finding the post requested.')
					->with('alert', 'alert');
		}

		if($post->cover_photo) {
			File::delete(public_path() . $post->cover_photo);
		}
		
		if($post->images) {
			$post->deleteImages();
		}

		if($post->comments) {
			$post->comments()->delete();
		}

		if($post->delete()) {
			return 	Redirect::route('post-manage')
					->with('global', 'The post has been successfully removed.')
					->with('alert', 'success');
		} else {
			return 	Redirect::route('post-manage')
					->with('global', 'There was a problem removing the post.')
					->with('alert', 'alert');
		}
		//fallback error
		return 	Redirect::route('post-manage')
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert');
	}


}