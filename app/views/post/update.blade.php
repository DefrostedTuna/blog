@extends('layout.single-column')

@section('title')
Update - {{ $post->title }}
@stop

@section('content')
<div class="row">
	<div class="medium-12 columns text-center">
		<h2>
			<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
				{{ $post->title }}
			</a>
		</h2>
	</div>
	<hr class="no-margin-bottom">
</div>

<!--Image Stuff-->
<div class="row text-center">	
	
	<!--Image-->
	@if($post->cover_photo)
	<div class="small-12 small-centered columns">
		{{ HTML::image($post->cover_photo) }}
		<hr>
	</div>

	<!--Remove Image-->
	<div class="medium-6 column">
		{{ Form::open(array('url' => URL::route('post-delete-cover', $post->slug))) }}
			<input type="hidden" value="{{ $post->id }}" name="post_id">
			<input type="submit" class="button alert tiny expand radius margin-bottom-none" value="Remove cover photo">
		{{ Form::close() }}
	</div>
	@endif

	<!--Attached Images-->
	<div class="medium-6 columns">
		<a href="{{ URL::route('image-manage', $post->slug) }}" class="button expand tiny radius">
			Manage attached images
		</a>
	</div>
</div>
<!--/image stuff/-->

<hr class="margin-top-none">

<!--Input-->
<div class="row">
	<div class="medium-12 columns">
	{{ Form::open(array('url' => URL::route('post-update', $post->slug), 'files' => true)) }}	

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
								{{ Input::old() ? (Input::old('featured') ? 'checked' : ($post->featured ? 'checked' : '' )) : ($post->featured ? 'checked' : '' ) }}>
						<label for="featured">Featured</label>
					</div>

					<!--Visible-->
					<div class="small-6 large-6 columns text-center">
						<input 	type="checkbox" 
								name="visible"
								id="visible"
								{{ Input::old() ? (Input::old('visible') ? 'checked' : '' ) : ($post->visible ? 'checked' : '') }}>
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
				/>{{ $post->body ? $post->body : '' }}</textarea>
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
				<input type="hidden" name="post_id" value="{{ $post->id }}">
				<input type="submit" class="button success radius small expand" value="Update">
			</div>
		</div>

	{{ Form::close() }}
	</div>
</div>
<!--/input/-->
@stop