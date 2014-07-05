@extends('layout.single-column')

@section('title')
Manage Images - {{ $post->title }}
@stop

@section('content')
<div class="row">
	<div class="medium-12 columns text-center">
		<h2><a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">{{ $post->title }}</a></h2>
	</div>
	<hr class="margin-top-none">
</div>

<!--Results-->
@if(Session::has('success') || Session::has('failed'))
<div class="row">

	<!--Succeeded-->
	@if(Session::has('success') && !empty(Session::get('success')))
	<div class="medium-6 columns text-left">
		<fieldset>
			<legend>
				<h4>Succeeded</h4>
			</legend>
			<ul>
				@foreach(Session::get('success') as $image)
					<li class="break-word" style="font-weight: bold; color: green">{{ $image }}</li>
				@endforeach
			</ul>
		</fieldset>
	</div>
	@endif

	<!--Failed-->
	@if(Session::has('failed') && !empty(Session::get('failed')))
	<div class="medium-6 columns text-left">
		<fieldset>
			<legend>
				<h4>Failed</h4>
			</legend>
			<ul>
				@foreach(Session::get('failed') as $image)
					<li	class="break-word" style="font-weight: bold; color: red">{{ $image }}</li>
				@endforeach
			</ul>
		</fieldset>
	</div>
	@endif
</div>
<hr>
@endif
<!--/results/-->

<!--Buttons-->
<div class="row text-center">
	<div class="medium-6 columns">
		<button class="button radius tiny expand" onClick="toggle_visibility('image-upload');">Upload images</button>
	</div>
	<div class="medium-6 columns">
		<a href="{{ URL::route('post-update', $post->slug) }}" class="button radius tiny expand">Update post</a>
	</div>
</div>

<!--Input-->
<div id="image-upload" class="row hide">
<hr class="margin-top-none">
	<div class="medium-8 medium-centered columns">
	{{ Form::open(array('url' => URL::route('image-add', $post->slug), 'files' => true, 'class' => 'margin-bottom-none')) }}	
		
		<!--Upload Form-->
		<fieldset>
			<legend>
				<label for="images">
					<strong>Images</strong>
				</label>
			</legend>
			<input 	type="file"
					name="images[]"
					id="images"
					multiple>
		</fieldset>

		<!--Submit-->
		<div class="row text-center">
			<div class="small-12 medium-6 large-4 medium-centered columns">
				<input type="hidden" name="post_id" value="{{ $post->id }}">
				<input type="submit" class="button success radius small expand" value="Upload">
			</div>
		</div>

		{{ Form::close() }}
	</div>
</div>
<!--/input/-->


@if(!count($post->images))
<hr class="margin-top-none">
<div class="row">
	<div class="medium-10 medium-centered columns panel">
		<h3>There are no images associated with this article.</h3>
		<p>If you would like to upload some, please click the upload button above.</p>
	</div>
</div>
@endif

<!--Block Grid-->
@if(count($post->images))
<hr class="margin-top-none">
<div class="row text-center">
	<div class="medium-12 columns">
		<ul 
			{{ (count($post->images) >= 2) ? 'class="small-block-grid-2 medium-block-grid-4 large-block-grid-5"' : 'class="no-bullet"' }}>
			@foreach($post->images as $image)
				<li>
					<a href="{{ URL::route('image-view', $image->filename) }}" target="_blank">
					{{ HTML::image($image->thumb, 'alt img', array('class' => 'th')) }}
					</a>
					<div class="medium-12 columns">
						{{ Form::open(array('url' => URL::route('image-delete', $post->slug))) }}
							<input type="hidden" name="image_id" value="{{ $image->id }}">
							<small>
								<button class="label alert radius" onclick="this.form.submit()">
									Delete
								</button>
							</small>
						{{ Form::close() }}
					</div>
				</li>
			@endforeach
		</ul>
	</div>
</div>
@endif
<!--/block grid/-->
@stop

@section('script')
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
@stop