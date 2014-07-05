@extends('layout.double-column')

@section('title')
Admin Dashboard
@stop

@section('content')
<div class="row">
	<div class="medium-12 columns">
		<h3 class="text-center">Welcome {{ Auth::user()->first_name }}, what would you like to do?</h3>		
	</div>
	<hr>
</div>

<div class="row text-center">
	<div class="medium-12 columns">
		<!--Post Management-->
			<div class="medium-6 columns">
				<fieldset>
					<legend><h3>Posts</h3></legend>
					<a href="{{ URL::route('post-manage') }}">
						<button class="tiny radius expand">Manage</button>
					</a>
					<a href="{{ URL::route('post-create') }}">
						<button class="tiny radius expand">Create</button>
					</a>
				</fieldset>				
			</div>

		<!--Comment Management-->
			<div class="medium-6 columns">
				<fieldset>
					<legend><h3>Comments</h3></legend>
					<a href="{{ URL::route('comments-manage') }}">
						<button class="tiny radius expand">Manage</button>
					</a>
					@if(count($pending_comments) > 1)
						<span style="font-weight: bold; color: red">({{ count($pending_comments) }} comments pending)</span>
					@elseif(count($pending_comments) > 0)
						<span style="font-weight: bold; color: red">({{ count($pending_comments) }} comments pending)</span>
					@elseif(count($pending_comments) == 0)
						<span style="font-weight: bold; color: green">(No comments pending)</span>
					@endif
				</fieldset>				
			</div>
	</div>
</div>
@stop