@if(count(Post::getFeatured()))
<h3>Featured</h3>
	<ul class="no-bullet">
	@foreach(Post::getFeatured() as $post)
		<li>
			<a class="plain-link-light" href="{{ URL::route('post-slug', $post->slug) }}">
				{{ $post->title }}
			</a>
		</li>
	@endforeach
	</ul>
@endif

@if(count(Post::getRecent()))
<h3>Recent</h3>
	<ul class="no-bullet">
	@foreach(Post::getRecent() as $post)
		<li>
			<a class="plain-link-light" href="{{ URL::route('post-slug', $post->slug) }}">
				{{ $post->title }}
			</a>
		</li>
	@endforeach
	</ul>
@endif

@if(count(Comment::getRecent()))
<h4>Recent Comments</h4>
	<ul class="no-bullet">
	@foreach(Comment::getRecent() as $comment)
		<li>
			<a class="plain-link-light" href="{{ URL::route('post-slug', $comment->post->slug) }}">
				{{ $comment->name }}
			</a>
		</li>
	@endforeach
	</ul>
@endif