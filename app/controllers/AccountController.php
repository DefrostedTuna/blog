<?php

class AccountController extends BaseController {

	public function getLogIn() {
		return View::make('account.login');
	}

	public function postLogIn() {
		$validator = Validator::make(Input::all(), array(
				'email' 	=> 'required|email|min:3|max:255',
				'password' 	=> 'required|min:3'
			));

		if($validator->fails()) {
			return 	Redirect::route('account-log-in')
					->withErrors($validator)
					->withInput();
		} else {

			$email 		= Input::get('email');
			$password 	= Input::get('password');
			$remember 	= (Input::has('remember')) ? true : false;

			$auth = Auth::attempt(array(
					'email' 	=> $email,
					'password' 	=> $password
			), $remember);

			if($auth) {
				return 	Redirect::intended('/')
						->with('global', 'You have been logged in as ' . Auth::user()->username . '!')
						->with('alert', 'success');
			} else {
				return 	Redirect::route('account-log-in')
						->with('global', 'The email or password were incorrect')
						->with('alert', 'alert');
			}
		}
		//fallback error
		return 	Redirect::route('account-log-in')
				->with('global', 'There was a problem processing the request');

	}

	public function getLogOut() {
		Auth::logout();
		return Redirect::route('home');
	}

	public function getSettings() {
		return View::make('account.settings');
	}

	public function getChangePassword() {
		return View::make('account.password');
	}

	public function postChangePassword() {
		$validator = Validator::make(Input::all(), array(
				'current_password' 		=> 'required|min:3',
				'new_password' 			=> 'required|min:3',
				'confirm_new_password' 	=> 'required|min:3|same:new_password'
			));

		if($validator->fails()) {
			return 	Redirect::route('account-change-password')
					->withErrors($validator)
					->withInput();
		} else {

			$id 				= Auth::user()->id;
			$current_password 	= Input::get('current_password');
			$new_password 		= Input::get('new_password');
			
			
			$user 				= User::findOrFail($id);

			if(Hash::check($current_password, $user->getAuthPassword())) {
				
				$user->password = Hash::make($new_password);
				
				if($user->save()) {
					return 	Redirect::route('account-change-password')
							->with('global', 'Your password has been updated.')
							->with('alert', 'success');
				} else {
					return 	Redirect::route('account-change-password')
							->with('global', 'There was a problem updating your password.')
							->with('alert', 'alert');
				}
			} else {
				return 	Redirect::route('account-change-password')
						->with('global', 'Your password was incorrect.')
						->with('alert', 'alert');
			}
		}
		//fallback error
		return 	Redirect::route('account-settings')
				->with('global', 'There was a problem processing the request.');
	}

	public function getForgotPassword() {
		return View::make('account.forgot');
	}

	public function postForgotPassword() {
		$validator = Validator::make(Input::all(), array(
				'email' => 'required|email|min:3|max:255'
			));

		if($validator->fails()) {
			return 	Redirect::route('account-forgot-password')
					->withErrors($validator)
					->withInput();
		} else {

			$user = User::where('email', '=', Input::get('email'));

			if($user->count()) {

				$user = $user->first();

				$code 					= str_random(60);
				$password 				= str_random(10);
				
				$user->code 			= $code;
				$user->password_temp 	= $password;

				if($user->save()) {

					Mail::queue('emails.auth.forgot', array(
						'link'     => URL::route('account-recover', $code),
						'username' => $user->username, 
						'password' => $password), 
							function($message) use($user) {
								$message
								->to($user->email, $user->username)
								->subject('Your new password');
							}); 

					return 	Redirect::route('home')
							->with('global', 'We have sent an email containing a new password, please check your inbox shortly and follow the link to activate it.')
							->with('alert', 'success');
				} else {
					return 	Redirect::route('account-forgot-password')
							->with('global', 'There was a problem requesting a new password, please try again later')
							->with('alert', 'alert');
				}
			}
		}
		//fallback error
		return 	Redirect::route('account-forgot-password')
				->with ('global', 'There was a problem processing the request.');

	}

	public function getRecover($code) {

		$user = User::where('code', '=', $code)
					->where('password_temp', '!=', '');

		if($user->count()) {

			$user = $user->first();

			$user->password 		= Hash::make($user->password_temp);
			
			$user->password_temp 	= '';
			$user->code 			= '';

			if($user->save()) {	
				return 	Redirect::route('home')
						->with('global', 'You can now log in with your new password!');
			}	else {
				return 	Redirect::route('home')
						->with('global', 'There was a problem recovering your account. Please try again later.');
			}
		}
		//fallback error
		return 	Redirect::route('home')
				->with ('global', 'There was a problem processing the request.');
	}

}