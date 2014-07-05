<?php

class HomeController extends BaseController {

	public function getIndex() {

		$posts = Post::getVisible(5);

		return 	View::make('index')
				->with('posts', $posts);

	}

	public function getAbout() {

		return View::make('about');
	}

	public function getSearch($query) {
		/*
		** Process the search query that was passed 
		** from the post input, followed by the
		** number of results to be displayed on each page
		*/
		$search_results = Post::search($query, 5);

		return 	View::make('post.search')
				->with('posts', $search_results);
	}

	public function postSearch() {
		/*
		** Get post input from search form and 
		** send to route for cleaner url string
		*/
		if(Input::has('search')) {
			$query = Input::get('search');
		} else {
			return 	Redirect::back()
					->with('global', 'You must enter a keyword to search for.')
					->with('alert', 'alert');
		}

		return Redirect::route('get-search', $query);
	}

	public function postContact() {
		$validator = Validator::make(Input::all(), array(
			'email'   => 'required|email|min:3|max:255',
			'subject' => 'required|min:3|max:100',
			'body'    => 'required|min:3|max:1000'
		));

		if($validator->fails()) {
			return 	Redirect::route('about')
					->withErrors($validator)
					->withInput();
		} else {

			$email   = Input::get('email');
			$subject = Input::has('subject') ? Input::get('subject') : '(No Subject)';
			$body    = Input::get('body');
			
			
			$mail = Mail::queue('emails.contact.contact', 
								 array('email' => $email, 'subject' => $subject, 'body' => $body), 
								 function ($message) use($subject){
									$message->to('RBennett1106@Gmail.com')
											->subject($subject);
								});
		

			if($mail) {
				return 	Redirect::route('about')
						->with('global', 'Message has been sent!')
						->with('alert', 'success');
			} else {
				return 	Redirect::route('about')
						->with('global', 'There was a problem sending the message.')
						->with('alert', 'alert');
			}
			//fallback error
			return 	Redirect::route('about')
					->with('global', 'There was a problem processing the request.')
					->with('alert', 'alert');
		}
	}

}
