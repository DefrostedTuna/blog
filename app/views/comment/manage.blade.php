@extends('layout.double-column')

@section('title')
Manage Comments
@stop

@section('content')
<!--Heading-->
<div class="row text-center">
	<div class="small-8 medium-12 small-centered medium-uncentered columns small-only-text-center">
		<h2>Manage Comments</h2>
	</div>
	<hr class="margin-top-none">
</div>
<!--/heading/-->

<!--Main-->
<div class="row">
	<div class="medium-12 columns">

		@if(!count($pending_comments))
		<div class="medium-8 medium-centered columns panel text-center">
			<h4>There are no comments pending approval!</h4>
		</div>
		@endif

		<!--Comments-->
		@foreach($pending_comments as $comment)
		<div class="row">

			<!--Comment contents-->
			<div class="medium-10 medium-centered columns">
				<h4><a href="{{ URL::route('post-slug', $comment->post->slug) }}" class="plain-link-dark">{{ $comment->post->title }}</a></h4>
				<div class="panel">
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
			<!--/comment contents/-->

			<!--Buttons-->
			<div class="row text-center">
				<!--Approve-->
				<div class="small-4 small-offset-2 medium-2 medium-offset-4 columns">
					{{ Form::open(array('url' => URL::route('comments-approve'))) }}
					<input type="hidden" name="comment_id" value="{{ $comment->id }}">
					<input type="submit" class="button success tiny radius" Value="Approve!">
					{{ Form::close() }}
				</div>

				<!--Delete-->
				<div class="small-4 medium-2 end columns">
					{{ Form::open(array('url' => URL::route('comments-delete'))) }}
					<input type="hidden" name="comment_id" value="{{ $comment->id }}">
					<input 	type="submit" 
							class="button alert tiny radius" 
							onClick="return confirm('Are you sure you want to delete this?')" 
							Value="Delete">
					{{ Form::close() }}
				</div>
			</div>
			<!--/buttons/-->
		</div>
		<hr class="margin-top-none">
		@endforeach
		<!--/comments/-->
	</div>
</div>
<!--/main/-->
@stop