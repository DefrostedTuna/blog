@extends('layout.double-column')

@section('title')
Posts
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>Posts</h2>
	</div>
	<hr class="margin-top-none">
</div>

<!--Pagination-->
{{ $posts->links() }}

<ul class="no-bullet">
<!--Post-->
@foreach($posts as $post)
<div class="row post-background padding">
	<li>
		<!--Timestamp-->
		<span>
		{{ HTML::image('assets/img/calendar.png', 'alt img', array('class' => 'va-top'))}}
		{{ $post->published() }}
		</span>

		<!--Post Title-->
		<h4 class="margin-bottom-none">
			<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
				{{ $post->title }}
			</a>
		</h4>
	</li>
</div>
@endforeach
</ul>
<!--/post/-->

<!--Pagination-->
{{ $posts->links() }}
@stop