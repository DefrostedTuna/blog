@extends('layout.double-column')

@section('title')
About
@stop

@section('content')
<div class="row text-center">
	<div class="medium-12 columns">
		<h2>About</h2>
	</div>
	<hr class="margin-top-none">
</div>

<div class="medium-12 columns text-center">
	<h3>A blog huh?</h3>
	<p><strong>So what exactly is it about?</strong> Well everything I suppose. From updates on the progress of current projects and code snippets that I've found useful, to stuff like video game content. I imagine there will be quite a variety of things to sift through shortly.</p>

	<h3>Okay, so  <em>who's</em> blog are we talking about?</h3>
	<p><strong>Who's in charge of all the stuff here?</strong> That'd be me, Rick Bennett. I'm a web developer who likes the same things that most of your average tech nerds enjoy. Learning whatever I stumble across, geeking out over the latest technology, playing video games, and spending long hours in front of the computer because im too stubborn to give up on somthing I'm stuck on.</p> 
	<p>If you'd like to check out some of my work, head over to my <strong><a href="http://www.rickbennettcoding.com" target="_blank">portfolio</a></strong> and sift through what I've got there.</p>

	<h3>Now that we've got that sorted out...</h3>
	<p><strong><em>Why</em> are you keeping a blog?</strong> Why <em class="underline">not</em>? I suppose this is for fun mainly. I figure this is a good way to keep everyone up to speed with everything that's going on concerning my web projects and various other stuff. It's also going to be pretty cool to see how far I've come with my skills as a developer as I look back at earlier topics.</p>

</div>

<hr class="margin-bottom-none">

<div class="medium-12 columns">
	<h3>Contact</h3>
	<p><strong>Need to contact me?</strong> Fill out the form below and I'll get back to you as soon as I can!</p>
	{{ Form::open(array('url' => URL::route('contact'))) }}

		<!--Email-->
		<div class="row">
			<div class="medium-12 columns">
				<input 	type="email" 
						name="email" 
						placeholder="Email"
						{{ $errors->has('email') ? "class='error'" : ''}}
						value={{{ Input::old('email') ? Input::old('email') : '' }}}>	
				@if($errors->has('email'))
				<small class="error">
  					{{ $errors->first('email') }}
  				</small>
				@endif	
			</div>
		</div>
		
		<!--Subject-->
		<div class="row">
			<div class="medium-12 columns">
				<input 	type="text" 
						name="subject" 
						placeholder="Subject (Optional)"
						{{ $errors->has('subject') ? "class='error'" : ''}}
						value={{{ Input::old('subject') ? Input::old('subject') : '' }}}>
				@if($errors->has('subject'))
				<small class="error">
  					{{ $errors->first('subject') }}
  				</small>
				@endif			
			</div>
		</div>

		<!--Body-->
		<div class="row">
			<div class="medium-12 columns">
				<textarea 	name="body" 
							placeholder="Email contents..."
							{{ $errors->has('body') ? "class='error'" : ''}}>{{{ Input::old('body') ? Input::old('body') : '' }}}</textarea>
				@if($errors->has('body'))
				<small class="error">
  					{{ $errors->first('body') }}
  				</small>
				@endif			
			</div>
		</div>
		
		<!--Submit-->
		<div class="row text-center">
			<div class="medium-8 large-6 medium-centered columns">
				<input type="submit" class="button tiny success radius expand" value="Submit">
			</div>
		</div>
	{{ Form::close() }}	
</div>
@stop