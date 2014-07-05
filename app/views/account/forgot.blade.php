@extends('layout.single-column')

@section('title')
Forgot Password
@stop

@section('content-no-bg')
<div class="row">
	<div class="medium-8 large-6 columns medium-centered end bg-light text-center">
		
		<!--Heading-->
		<div class="row">
			<div class="small-8 medium-12 small-centered medium-uncentered columns">
				<h2>Recover Password</h2>
			</div>
			<hr class="margin-top-none">
		</div>

		<!--Form-->
		<div class="row">
			<div class="medium-8 columns medium-centered">
				{{ Form::open(array('url' => URL::route('account-forgot-password'))) }}

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

				<!--Submit-->
				<div class="row">
					<div class="medium-12 columns">
						<input type="submit" class="button success radius small margin-bottom-none" value="Submit">
					</div> 
				</div>

				{{ Form::close() }}
			</div>
		</div>
		<!--/form/-->
	</div>
</div>
@stop