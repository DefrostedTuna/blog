@extends('layout.double-column')
<!--REFACTORED-->

@section('title')
Archive
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>Archive</h2>
	</div>
	<hr class="margin-top-none">
</div>

@foreach($archives as $year => $months)
<div class="row">
	<div class="medium-12 columns">
		<fieldset>
			<legend><h3>{{ $year }}</h3></legend>
				@foreach($months as $month => $posts)
				<div class="row">
					<h5>
						<span class="plain-link-dark" onClick="toggle_visibility('{{$year.$month}}')">
							{{ $month }}
						</span>
					</h5>
					<ul id="{{ $year.$month }}" class="hide no-bullet panel">
						@foreach($posts as $post)
						<li style="border-bottom: dotted black 1px">
							<span style="color: green">
								<strong>{{ $post->created_at->format('dS') }}</strong>
							</span>
							|
							<a href="{{ URL::route('post-slug', $post->slug) }}" class="plain-link-dark">
								<strong>{{ $post->title }}</strong>
							</a>
						</li>
						@endforeach
					</ul>
				</div>
				@endforeach
		</fieldset>
	</div>
</div>
@endforeach
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