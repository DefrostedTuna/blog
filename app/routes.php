<?php

/*--------------------------------------------------------------
| Public Routes ================================================
|---------------------------------------------------------------
*/
	//GET//
	Route::get('/', array(
		'as' 	=> 'home',
		'uses' 	=> 'HomeController@getIndex'
	));

	//GET//
	Route::get('/about', array(
		'as' 	=> 'about',
		'uses' 	=> 'HomeController@getAbout'
	));

	//GET//
	Route::get('/search/{query}', array(
		'as' 	=> 'get-search',
		'uses' 	=> 'HomeController@getSearch'
	));

	//POST//
	Route::post('/search', array(
		'as' 	=> 'post-search',
		'uses' 	=> 'HomeController@postSearch'
	))
	//filters//
	->before('csrf');

	//POST//
	Route::post('/about', array(
		'as' 	=> 'contact',
		'uses' 	=> 'HomeController@postContact'
	))
	//filters//
	->before('csrf');

/*------------------------------------------------------------------
| Account Routes ===================================================
|-------------------------------------------------------------------
*/
	/*--------------------------------------------------------------
	| Account Login Routes
	*/
		//GET//
		Route::get('/account/login', array(
			'as' 	=> 'account-log-in',
			'uses' 	=> 'AccountController@getLogIn'
			))
		//filters//
		->before('guest');

		//POST//
		Route::post('/account/login', array(
			'as' 	=> 'account-log-in', 
			'uses' 	=> 'AccountController@postLogIn'
			))
		//filters//
		->before('guest')
		->before('csrf');


	/*--------------------------------------------------------------
	| Account Logout Route
	*/
		//GET//
		Route::get('/account/logout', array(
			'as' 	=> 'account-log-out',
			'uses' 	=> 'AccountController@getLogOut'
			))
		//filters//
		->before('auth');

	/*--------------------------------------------------------------
	| Account Change Password Routes
	*/
		//GET//
		Route::get('account/change-password', array(
			'as' 	=> 'account-change-password',
			'uses' 	=> 'AccountController@getChangePassword'
			))
		//filters//
		->before('auth');

		//POST//
		Route::post('account/change-password', array(
			'as' 	=> 'account-change-password',
			'uses' 	=> 'AccountController@postChangePassword'
			))
		//filters//
		->before('auth')
		->before('csrf');

	/*--------------------------------------------------------------
	| Account Forgot Password Routes
	*/
		//GET//
		Route::get('/account/forgot-password', array(
			'as' 	=> 'account-forgot-password',
			'uses' 	=> 'AccountController@getForgotPassword'
			))
		//filters//
		->before('guest');

		//POST//
		Route::post('/account/forgot-password', array(
			'as' 	=> 'account-forgot-password', 
			'uses' 	=> 'AccountController@postForgotPassword'
			))
		//filters//
		->before('guest')
		->before('csrf');

	/*--------------------------------------------------------------
	| Account Recover Route
	*/
		//GET//
		Route::get('/account/recover/{code}', array(
			'as' 	=> 'account-recover',
			'uses' 	=> 'AccountController@getRecover'
			))
		//filters//
		->before('guest');

/*-- End Account Routes ------------------------------------------*/

/*------------------------------------------------------------------
| Admin Routes =====================================================
|-------------------------------------------------------------------
*/
	/*--------------------------------------------------------------
	| Admin Dashboard Routes
	*/
		//GET//
		Route::get('/admin/dashboard', array(
			'as' 	=> 'admin-dashboard',
			'uses' 	=> 'AdminController@getIndex'
			))
		//filters//
		->before('auth');

		//Redirect to Dashboard//
		Route::get('/admin', function() {
			return Redirect::route('admin-dashboard');
			})
		//filters//
		->before('auth');

/*-- End Admin Routes --------------------------------------------*/

/*------------------------------------------------------------------
| Post Management Routes ===========================================
|-------------------------------------------------------------------
*/
	/*--------------------------------------------------------------
	|  Post List Route
	*/
		//GET//
		Route::get('/post', array(
			'as' 	=> 'post-list',
			'uses' 	=> 'PostController@getList'
		));

	/*--------------------------------------------------------------
	|  Post Archive Route
	*/
		//GET//
		Route::get('/post/archive', array(
			'as' 	=> 'post-archive',
			'uses' 	=> 'PostController@getArchive'
		));

	/*--------------------------------------------------------------
	| Post View(Single/Slug) Route
	*/	
		//GET//
		Route::get('/post/{slug}', array(
			'as' 	=> 'post-slug',
			'uses' 	=> 'PostController@getSlug'
		));

	/*--------------------------------------------------------------
	| Post List(Tag) Route
	*/		
		//GET//
		Route::get('/post/{tag}', array(
			'as' 	=> 'post-tag',
			'uses' 	=> 'PostController@getTag'
		));
	
	/*--------------------------------------------------------------
	| Post Manage Route
	*/
		//GET//
		Route::get('/admin/post/manage', array(
			'as' 	=> 'post-manage',
			'uses' 	=> 'PostController@getManage'
		))
		//filters//
		->before('auth');

	/*--------------------------------------------------------------
	| Post Create Route
	*/
		//GET//
		Route::get('/admin/post/create', array(
			'as' 	=> 'post-create',
			'uses' 	=> 'PostController@getCreate'
		))
		//filters//
		->before('auth');

		//POST//
		Route::post('/admin/post/create', array(
			'as' 	=> 'post-create',
			'uses' 	=> 'PostController@postCreate'
		))
		//filters//
		->before('auth')
		->before('csrf');

	/*--------------------------------------------------------------
	| Post Update Route
	*/
		//GET/
		Route::get('/admin/post/update/{slug}', array(
			'as' 	=> 'post-update',
			'uses' 	=> 'PostController@getUpdate'
		))
		//filters//
		->before('auth');

		//POST//
		Route::post('/admin/post/update/{slug}', array(
			'as' 	=> 'post-update',
			'uses' 	=> 'PostController@postUpdate'
		))
		//filters//
		->before('auth')
		->before('csrf');
	
	/*--------------------------------------------------------------
	| Post Delete Route
	*/
		//POST//
		Route::post('/admin/post/delete/{slug}', array(
			'as' 	=> 'post-delete',
			'uses' 	=> 'PostController@postDelete'
		))
		//filters//
		->before('auth')
		->before('csrf');		

	/*--------------------------------------------------------------
	| Post Delete(Cover Image) Route
	*/
		//POST//
		Route::post('/admin/post/delete-cover/{slug}', array(
			'as' 	=> 'post-delete-cover',
			'uses' 	=> 'PostController@postDeleteCover'
		))
		//filters//
		->before('auth')
		->before('csrf');

/*-- End Post Management Routes ----------------------------------*/

/*------------------------------------------------------------------
| Comment Routes ===================================================
|-------------------------------------------------------------------
*/
	/*--------------------------------------------------------------
	| Comments Manage Route
	*/
		//GET//
		Route::get('/admin/comments', array(
			'as' 	=> 'comments-manage',
			'uses' 	=> 'CommentController@getManage'
		))
		//filters//
		->before('auth');

	/*--------------------------------------------------------------
	| Comments Create Route
	*/
		//POST//
		Route::post('/post/{slug}/comment', array(
			'as' 	=> 'comments-create',
			'uses' 	=> 'CommentController@postCreate'
		))
		//filters//
		->before('csrf');

	/*--------------------------------------------------------------
	| Comments Approve Route
	*/
		//POST//
		Route::post('admin/comments/approve/', array(
			'as' 	=> 'comments-approve',
			'uses' 	=> 'CommentController@postApprove'
		))
		//filters//
		->before('auth')
		->before('csrf');

	/*--------------------------------------------------------------
	| Comments Delete Route
	*/
		//POST//
		Route::post('admin/comments/delete/', array(
			'as' 	=> 'comments-delete',
			'uses' 	=> 'CommentController@postDelete'
		))
		//filters//
		->before('auth')
		->before('csrf');

/*-- End Comment Routes ------------------------------------------*/

/*------------------------------------------------------------------
| Image Routes =====================================================
|-------------------------------------------------------------------
*/
	/*--------------------------------------------------------------
	| Image View Route
	*/
		//GET//
		Route::get('/image/{filename}', array(
			'as' 	=> 'image-view',
			'uses' 	=> 'ImageController@getView'
		));

	/*--------------------------------------------------------------
	| Image manage Route
	*/
		//GET//
		Route::get('/admin/image/manage/{slug}', array(
			'as' 	=> 'image-manage',
			'uses' 	=> 'ImageController@getManage'
		))
		//filters//
		->before('auth');

	/*--------------------------------------------------------------
	| Image Add Route
	*/
		//POST//
		Route::post('/admin/image/add/{slug}', array(
			'as' 	=> 'image-add',
			'uses' 	=> 'ImageController@postAdd'
		))
		//filters//
		->before('auth')
		->before('csrf');

	/*--------------------------------------------------------------
	| Image Delete Route
	*/
		//POST//
		Route::post('/admin/image/delete/{slug}', array(
			'as' 	=> 'image-delete',
			'uses' 	=> 'ImageController@postDelete'
		))
		//filters//
		->before('auth')
		->before('csrf');

/*-- End Image Routes --------------------------------------------*/