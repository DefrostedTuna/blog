@extends('layout.single-column')

@section('title')
Change Password
@stop

@section('content-no-bg')
<div class="row">
	<div class="medium-8 large-6 columns medium-centered end bg-light text-center">
		
		<!--Heading-->
		<div class="row">
			<div class="small-8 medium-12 small-centered medium-uncentered columns">
				<h2>Change Password</h2>
			</div>
			<hr class="margin-top-none">
		</div>

		<!--Form-->
		<div class="row">
			<div class="medium-8 columns medium-centered">
				{{ Form::open(array('url' => URL::route('account-change-password'))) }}

				<!--Password-->
				<div class="row">
					<div class="medium-12 columns">
				        <input 	type="password" 
				        		name="current_password" 
				        		placeholder="Current Password"
				        		{{ $errors->has('current_password') ? 'class="error"' : '' }} >
			      		@if($errors->has('current_password'))
			      			<small class="error">
			      				{{ $errors->first('current_password') }}
			      			</small>
			      		@endif
			    	</div>
			    </div>

				<!--New Password-->
				<div class="row">
					<div class="medium-12 columns">
				        <input 	type="password" 
				        		name="new_password" 
				        		placeholder="New Password"
				        		{{ $errors->has('new_password') ? 'class="error"' : '' }} >
			      		@if($errors->has('new_password'))
			      			<small class="error">
			      				{{ $errors->first('new_password') }}
			      			</small>
			      		@endif
			    	</div>
			    </div>

				<!--Confirm New Password-->
				<div class="row">
					<div class="medium-12 columns">
				        <input 	type="password" 
				        		name="confirm_new_password" 
				        		placeholder="Confirm New Password"
				        		{{ $errors->has('confirm_new_password') ? 'class="error"' : '' }} >
			      		@if($errors->has('confirm_new_password'))
			      			<small class="error">
			      				{{ $errors->first('confirm_new_password') }}
			      			</small>
			      		@endif
			    	</div>
			    </div>

				<!--Submit-->
				<div class="row">
					<div class="medium-12 columns">
						<input type="submit" class="button success small radius margin-bottom-none" value="Submit">
					</div>
				</div>

				{{ Form::close() }}
			</div>
		</div>
		<!--/form/-->
	</div>
</div>
@stop