@extends('layout.single-column')

@section('title')
Login
@stop

@section('content-no-bg')
<div class="row">
	<div class="medium-8 large-6 columns medium-centered end bg-light text-center">
		
		<!--Heading-->
		<div class="row">
			<div class="small-8 medium-12 small-centered medium-uncentered columns">
				<h2>Login</h2>
			</div>
			<hr class="margin-top-none">
		</div>

		<!--Form-->
		<div class="row">
			<div class="medium-8 columns medium-centered">
				{{ Form::open(array('url' => URL::route('account-log-in'))) }}

				<!--Email-->
				<div class="row">
					<div class="medium-12 columns">
				        <input 	type="text" 
				        		name="email" 
				        		id="email" 
				        		placeholder="Email"
				        		{{ $errors->has('email') ? 'class="error"' : '' }}
				        		{{{ Input::old('email') ? Input::old('email') : '' }}}>
			      		@if($errors->has('email'))
			      			<small class="error">
			      				{{ $errors->first('email') }}
			      			</small>
			      		@endif
			    	</div>
			    </div>

				<!--Password-->
				<div class="row">
					<div class="medium-12 columns">
				        <input 	type="password" 
				        		name="password" 
				        		id="password" 
				        		placeholder="Password"
				        		{{ $errors->has('password') ? 'class="error"' : '' }}>
			      		@if($errors->has('password'))
			      			<small class="error">
			      				{{ $errors->first('password') }}
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

				<hr>

				<!--Forgot Password-->
				<div class="row">
					<div class="medium-10 medium-centered end columns">
						<a href="{{ URL::route('account-forgot-password') }}" class="button alert tiny radius margin-bottom-none">Forgot password?</a>
					</div>
				</div>

				{{ Form::close() }}
			</div>
		</div>
		<!--/form/-->
	</div>
</div>
@stop