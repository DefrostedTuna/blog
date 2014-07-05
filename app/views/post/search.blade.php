@extends('layout.double-column')

@section('title')
Search
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>Search Results</h2>
	</div>
	<hr class="margin-top-none">
</div>

@if(!count($posts))
<div class="medium-8 medium-centered columns panel text-center">
	<h4>No results found!</h4>
</div>
@endif

<!--Pagination-->
{{ $posts->links() }}
<!--/pagination/-->

<!--Post-->
@foreach($posts as $post)
<div class="row">
	<div class="medium-12 columns margin-bottom">
		<!--Timestamp-->
		<span>
			{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top'))}}
			{{ $post->published() }}
		</span>
		<!--/timestamp/-->

		<!--Post Title-->
		<h4>
			<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
				{{ $post->title }}
			</a>
		</h4>
		<!--/post title/-->
	</div>	
</div>
@endforeach
<!--/post/-->

<!--Pagination-->
{{ $posts->links() }}
<!--/pagination/-->
@stop