@extends('layout.single-column')

@section('title')
Create Post
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>Create</h2>
	</div>
	<hr class="margin-top-none">
</div>

<!--Input-->
<div class="row">
	<div class="medium-12 medium-centered columns">
	{{ Form::open(array('url' => URL::route('post-create'), 'files' => true)) }}
		
		<!--Title-->
		<div class="row">
			<div class="medium-8 large-8 medium-centered columns">
				<input 	type="text" 
						name="title" 
						placeholder="Title"
						{{ $errors->has('title') ? 'class="error"' : '' }}
						value="{{{ Input::old('title') ? Input::old('title') : '' }}}"
				>
				@if($errors->has('title'))
  				<small class="error">
  					{{ $errors->first('title') }}
  				</small>
  				@endif
			</div>
		</div>

		<!--Photo/Visibility-->
		<div class="row">
			<!--Photo-->
			<div class="medium-9 large-6 medium-centered large-uncentered columns">
				<fieldset>
					<legend>Cover Photo</legend>
					<input 	type="file" 
							name="image"
							{{ $errors->has('image') ? 'class="error"' : '' }}>
					@if($errors->has('image'))
	  				<small class="error">
	  					{{ $errors->first('image') }}
	  				</small>
	  				@endif
  				</fieldset>						
			</div>

			<!--Checkboxes-->
			<div class="medium-9 large-6 medium-centered large-uncentered columns">
				<fieldset>
					<legend>Visibility</legend>
					<!--Featured-->
					<div class="small-6 large-6 columns text-center">
						<input 	type="checkbox" 
								name="featured"
								id="featured"
								{{{ Input::old('featured') ? "checked" : '' }}}>
						<label for="featured">Featured</label>
					</div>

					<!--Visible-->
					<div class="small-6 large-6 columns text-center">
						<input 	type="checkbox" 
								name="visible"
								id="visible"
								{{ Input::old() ? (Input::old('visible') ? 'checked' : '' ) : 'checked' }}>
						<label for="visible">Visible</label>
					</div>
				</fieldset>
			</div>
			<!--/checkboxes/-->
		</div>
		<!--/photo/visibility/-->

		<!--Body-->
		<div class="row">
			<div class="medium-12 columns margin-bottom-2">
			<label>Body</label>
				<textarea 	id="wysiwyg"
							name="body"
							{{ $errors->has('body') ? 'class="error"' : '' }}
				/>{{{ Input::old('body') ? Input::old('body') : '' }}}</textarea>
				
				@if($errors->has('body'))
  				<small class="error">
  					{{ $errors->first('body') }}
  				</small>
  				@endif						
			</div>
		</div>

		<!--Submit-->
		<div class="row text-center">
			<div class="medium-12 columns">
				<input type="submit" class="button success small radius expand" value="Create">
			</div>
		</div>

	{{ Form::close() }}
	</div>
</div>
<!--/input/-->
@stop