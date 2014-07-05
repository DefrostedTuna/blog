<?php 

class CommentController extends BaseController {

	public function getManage() {

		$pending_comments = Comment::pending();

		return View::make('comment.manage')
				->with('pending_comments', $pending_comments);
	}

	public function postApprove() {

		$id = Input::get('comment_id');

		$approve = Comment::findOrFail($id)->update(array(
						'approved' => 1
					));

		if($approve) {
			return 	Redirect::route('comments-manage')
					->with('global', 'Approved!')
					->with('alert', 'success');
		} else {
			return 	Redirect::route('comments-manage')
					->with('global', 'There was a problem approving this comment.')
					->with('alert', 'danger');
		}
		//fallback error
		return 	Redirect::route('comments-manage')
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'danger');

	}

	public function postCreate($slug) {
		$validator = Validator::make(Input::all(), array(
				'name' => 'required|min:3|max:50',
				'body' => 'required|min:3|max:1000'
			));

		if($validator->fails()) {
			return 	Redirect::to(URL::route('post-slug', $slug) . '#comment')
					->withErrors($validator)
					->withInput();
		} else {

			$post = Post::findBySlug($slug);
			$post_id = Input::get('post_id');

			$name = Input::get('name');
			$body = Input::get('body');


			if($post_id != $post->id) {
			return 	Redirect::route('post-slug', $slug)
					->withInput()
					->with('global', 'There was a problem finding the post requested.')
					->with('alert', 'alert');
			}

			$comment = Comment::create(array(
					'post_id'  => $post_id,
					'name'     => $name,
					'body'     => $body,
					'approved' => 0,
				));

			if($comment) {

				Mail::queue('emails.comment.new-comment', array('name' => $name, 'body' => $body, 'title' => $post->title), function($message) {
						$message->to('RBennett1106@Gmail.com')
								->subject('A new comment has been submitted!');
				});

				return 	Redirect::route('post-slug', $post->slug)
						->with('global', 'The comment has been submitted and will be reviewed shortly')
						->with('alert', 'success');
			} else {
				return 	Redirect::route('post-slug', $post->slug)
						->with('global', 'There was a problem submitting the comment, please try again later.')
						->with('alert', 'alert');				
			}
			//fallback error
			return 	Redirect::route('post-slug', $post->slug)
					->with('global', 'There was a problem processing the request.')
					->with('alert', 'alert');
		}
	}

	public function postDelete() {

		$id = Input::get('comment_id');

		$comment = Comment::findOrFail($id);

		if($comment->delete()) {
			return 	Redirect::back()
					->with('global', 'Comment successfully removed.')
					->with('alert', 'success');
		} else {
			return 	Redirect::back()
					->with('global', 'There was a problem removing the comment.')
					->with('alert', 'alert');
		}
		//fallback error
		return 	Redirect::back()
				->with('global', 'There was a problem processing the request.')
				->with('alert', 'alert');
	}

}