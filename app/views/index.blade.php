@extends('layout.double-column')
<!--REFACTORED-->

@section('title')
Home
@stop

@section('content')
<!--Pagination-->
<div class="spacer"></div>
{{ $posts->links() }}

<!--Post-->
@foreach($posts as $post)
<div class="row">
	<div class="medium-12 columns">
		
		<!--Timestamp-->
		<span>
			{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top'))}}
			{{ $post->published() }}
		</span>

		<!--Post Title-->
		<h3 class="margin-top-none">
			<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
				{{ $post->title }}
			</a>
		</h3>

		<!--Cover Image-->
		@if($post->cover_photo)
		<div class="row">
			<div class="medium-12 medium-centered columns">
				<p>
					<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
						{{ HTML::image($post->cover_photo) }}
					</a>
				</p>
			</div>
		</div>
		@endif

		<hr class="margin-top-none">
	</div>
</div>
@endforeach
<!--/post/-->

<!--Pagination-->
{{ $posts->links() }}
@stop