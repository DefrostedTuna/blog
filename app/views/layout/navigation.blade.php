<div class="nav-wrap sticky">
  <nav class="top-bar" data-topbar data-options="sticky_on: large">
    <ul class="title-area">
      <li class="name">
        <h1>
          @if(Auth::check())
          <a href="{{ URL::route('admin-dashboard') }}">Admin|Dashboard</a>
          @else
          <a href="{{ URL::route('home') }}">Blog | Rick Bennett Coding</a>
          @endif
        </h1>
      </li>
       <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
      <li class="toggle-topbar"><a href="#" class="menu-icon"><span class="menu-icon">Menu</span></a></li>
    </ul>

    <section class="top-bar-section">
      
      <!--Search bar and Admin Account stuff-->
      <ul class="right">
        <!--Search-->
        <li class="has-form">
          {{ Form::open(array('url' => URL::route('post-search'))) }}
          <div class="row collapse">
            <div class="large-8 small-9 columns">
              <input type="search" name="search" placeholder="Find Stuff">
            </div>
            <div class="large-4 small-3 columns">
              <button type="submit" class="alert button expand">Search</button>
            </div>
          </div>
          {{ Form::close() }}
        </li>
        <!--Admin account stuff-->
        @if(Auth::check())
        <li class="divider"></li>
        <li class="has-dropdown">
          <a href="">Account</a>
          <ul class="dropdown">
            <li>
              <a href="{{ URL::route('account-change-password') }}">Change Password</a>
            </li>
            <li>
              <a href="{{ URL::route('account-log-out') }}">Logout</a>
            </li>
          </ul>
        </li>
        @endif
      </ul>

      <!-- Left Nav Section -->
      <ul class="left">

        <li class="divider"></li>

        <li>
          <a href="{{ URL::route('home') }}">Home</a>
        </li>

        <li class="divider"></li>
        
        <li class="has-dropdown">
          <a href="{{ URL::route('post-list') }}">Posts</a>
          <ul class="dropdown">
            <li>
            	<a href="{{ URL::route('post-archive') }}">Archive</a>
            </li>
            @if(Auth::check())
            <li>
              <a href="{{ URL::route('post-manage') }}">Manage</a>
            </li>
            <li>
              <a href="{{ URL::route('post-create') }}">Create</a>
            </li>
            @endif
          </ul>
        </li>
        
        <li class="divider"></li>
        
        <li>
          <a href="{{ URL::route('about') }}">About</a>
        </li>

        <li class="divider"></li>
      </ul>
    </section>
  </nav>        
</div><!--navwrap-->