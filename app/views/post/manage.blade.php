@extends('layout.double-column')

@section('title')
Manage Posts
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>Manage Posts</h2>
	</div>
	<hr class="margin-top-none">
</div>

<!--Pagination-->
{{ $posts->links() }}

<!--Post-->
@foreach($posts as $post)
<div class="row">
	<div class="medium-12 columns">

		<!--Timestamp-->
		<div class="row">
			<div class="medium-12 columns">
				<span>
					{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top')) }}
					{{ date_format($post->created_at, "D M d, Y") }}
				</span>
			</div>
		</div>

		<!--Post title-->
		<div class="medium-8 columns">
			<h4 class="margin-top-none">
				<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
					{{ $post->title }}
				</a>
			</h4>
		</div>

		<!--Buttons-->
		<div class="medium-4 columns text-center">
					
			<!--Edit-->
			<div class="small-4 medium-6 small-offset-2 medium-offset-0 columns">
				<a href="{{ URL::route('post-update', $post->slug) }}" class="button tiny radius expand margin-bottom-none">
					Edit
				</a>						
			</div>

			<!--Delete-->
			<div class="small-4 medium-6 end columns">
				{{ Form::open(array('url' => URL::route('post-delete', $post->slug))) }}
					<input type="hidden" name="post_id" value="{{ $post->id }}">
					<input 	type="submit" 
							class="button alert tiny radius expand margin-bottom-none"
							onClick="return confirm('Are you sure you want to delete this?')"
							Value="Delete">
				{{ Form::close() }}
			</div>
		</div>
		<!--/buttons/-->

		<hr class="margin-top-none">
	</div>
</div>
@endforeach
<!--/post/-->

<!--Pagination-->
{{ $posts->links() }}
@stop