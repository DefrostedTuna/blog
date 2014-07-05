@extends('layout.single-column')

@section('title')
{{ $post->title }}
@stop

@section('content')
<div class="row">
	<div class="medium-12 columns">
		<h2>{{ $post->title }}</h2>
	</div>
</div>

<!--Timestamp-->
<div class="row">
	<div class="medium-12 columns">
		<span>
			{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top'))}}
			{{ date_format($post->created_at, "D M d, Y") }}
			&nbsp
			{{ HTML::image('assets/img/pen.png', 'alt img', array('class' => 'va-top'))}}
			{{ $post->author->first_name . ' ' . $post->author->last_name }}
		
			@if(Auth::check())
			<a href="{{ URL::route('post-update', $post->slug) }}">
				<button class="right label radius">
					<strong>Update</strong>
				</button>
			</a>
			@endif	
		</span>
	</div>
</div>
<!--/timestamp/-->

<hr>

<!--Cover Photo-->
@if($post->cover_photo)
<div class="row text-center">
	<div class="medium-12 columns">
		<p>{{ HTML::image($post->cover_photo) }}</p>
	</div>
</div>
<hr class="margin-top-none">
@endif

<!--Body-->
<div class="row">
	<div class="medium-12 columns">
		<p>
			{{ $post->body }}
		</p>
	</div>
</div>

<hr>

<!--Attached Images-->
@if(count($post->images))
<!--Block Grid Toggle-->
<div class="row">
	<div class="small-12 medium-6 large-4 medium-centered columns">
		<button class="expand radius tiny margin-bottom-none" onClick="toggle_visibility('block-grid')">
			<strong>Click to show/hide images</strong>
		</button>
	</div>
</div>

<hr>

<!--Block Grid-->
<div id="block-grid" class="row text-center hide">
	<div class="medium-12 columns">
		<ul 
			{{ (count($post->images) >= 3) ? 'class="small-block-grid-2 medium-block-grid-3 large-block-grid-5"' : 'class="no-bullet"' }}>
			@foreach($post->images as $image)
				<li>
					<a href="{{ URL::route('image-view', $image->filename) }}" target="_blank">
					{{ HTML::image($image->thumb, 'alt img', array('class' => 'th')) }}
					</a>
				</li>
			@endforeach
		</ul>
		<hr class="margin-top-none">
	</div>
</div>
@endif
<!--/attached images/-->

<!--Comments-->
<div class="row">
	<div class="medium-10 large-8 medium-centered columns">
		<!--Comment Heading-->
		<div class="row text-center">
			<div class="medium-12 columns">
				<h4>Comments</h4>
			</div>	
		</div>

		<!--No Comments Message-->
		@if(!count($post->approvedComments))
		<div class="row text-center">
			<div class="medium-12 coumns">
				<div class="panel">
					<h5>No comments found!</h5>
					<p>Be the first to submit one!</p>
				</div>
			</div>
		</div>
		@endif

		<!--Approved Comments-->
		@foreach($post->approvedComments as $comment)
		<div class="row">
			<div class="medium-12 columns">
				<div class="panel">
						{{ Form::open(array('url' => URL::route('comments-delete'),
											'class' => 'inline margin-bottom-none'))}}
							<input type="hidden" name="comment_id" value="{{ $comment->id }}">
							<input 	type="submit" 
									class="right button label radius alert" 
									onClick="return confirm('Are you sure you want to delete this?')" 
									value="Delete">
						{{ Form::close() }}
						<span>
							{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top')) }}
							{{ $comment->publishedShort() }}
							&nbsp
							{{ HTML::image('assets/img/pen.png', 'alt img', array('class' => 'va-top')) }}
							{{ $comment->name }}
						</span>
						<hr class="margin-top-none">
					<p>{{{ $comment->body }}}</p>
				</div>
			</div>
		</div>
		@endforeach

		<hr>

		<!--Comment Form-->
		<div class="row">
			<div class="medium-12 columns">
				<h4>Post comment</h4>
				<div class="panel">
					{{ Form::open(array('url' => URL::route('comments-create', $post->slug))) }}

					<!--Name-->
					<div class="row">
						<div class="medium-12 columns">
							<input 	type="text"
									name="name"
									placeholder="Name"
									{{ $errors->has('name') ? 'class="error"' : '' }}
									value={{{ Input::old('name') ? Input::old('name') : '' }}}>
							@if($errors->has('name'))
			  				<small class="error">
			  					{{ $errors->first('name') }}
			  				</small>
			  				@endif
						</div>
					</div>

					<!--Body-->
					<div class="row">
						<div class="medium-12 columns">
							<textarea 	name="body"
										id="comment"
										placeholder="Enter comment here..."
										{{ $errors->has('body') ? 'class="mceNoEditor comment error"' : 'class="mceNoEditor comment"' }}
										>{{{ Input::old('body') ? Input::old('body') : '' }}}</textarea>
							@if($errors->has('body'))
			  				<small class="error">
			  					{{ $errors->first('body') }}
			  				</small>
			  				@endif
			  				<p class="countdown margin-top-none text-center">Maximum of 1000 characters.</p>
						</div>
					</div>

					<!--Submit-->
					<div class="row text-center">
						<div class="medium-12 columns">
							<input type="hidden" name="post_id" value="{{ $post->id }}">
							<input type="submit" class="button tiny radius success" value="Submit">
						</div>
					</div>

					{{ Form::close() }}	
				</div><!--panel-->
			</div>
		</div>
		<!--/comment form/-->
	</div>
</div>
<!--/comments/-->
@stop

@section('script')
<script>
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
<script>
$('.comment').keyup(function () {
    var left = 1000 - $(this).val().length;
    if (left < 0) {
        left = 0;
        $('.countdown').css({
        	color: 'red',
        	fontWeight: 'bold'
        });
    } else {
    	    $('.countdown').css({
	    	color: 'black',
	    	fontWeight: 'normal'
	    });
    }
    $('.countdown').text(left + ' characters remaining.');
});
</script>
@stop