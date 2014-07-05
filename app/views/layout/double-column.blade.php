<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title') | Rick Bennett Coding</title>
        {{ HTML::style('assets/css/foundation.css') }}
        {{ HTML::style('assets/css/prettify.css') }}
        {{ HTML::style('assets/css/common.css') }}
    </head>
    <body onload="prettyPrint()">
    <!--Wrapper-->
    <div class="wrapper">

        <!-- Header Stuff -->
        @include('layout.header')

        <!-- Nav Bar -->
        @include('layout.navigation')

        <!--Global Alerts-->
        @if(Session::has('global'))
        <div class="spacer"></div>
        <div class="row text-center">
            <div class="medium-8 columns medium-centered">
                <div data-alert class="alert-box {{ (Session::has('alert')) ? Session::get('alert') : '' }}">
                    {{ Session::get('global') }}
                    <a href="#" class="close">&times;</a>
                </div>
            </div>
        </div>
        @endif

        <!--Content-->
        <div class="spacer"></div>
        <div class="row">

            <!--Container for left and right side, needed to fix large screen markup-->
            <div class="medium-11 large-11 medium-centered columns">
                <div class="row">
                    <!--Left Sidebar-->
                    <div id="left-side" class="medium-12 large-9 columns bg-light">
                        @yield('content')
                    </div>

                    <!--Right Sidebar-->
                    <div id="right-side" class="large-3 columns show-for-large-up bg-dark text-right">
                        @include('layout.sidebar')
                    </div>
                </div>
            </div>

        </div>

        <!--Push For Footer-->
        <div class="push"></div>

    </div>
    <!--/wrapper/-->


    <!-- Footer -->
    <div class="spacer"></div>
    <footer>
    @include('layout.footer')
    </footer>

    <!--Javascript-->
    {{ HTML::script("assets/js/vendor/jquery.js") }}
    {{ HTML::script("assets/js/foundation.min.js") }}
    {{ HTML::script("assets/js/vendor/modernizr.js") }}
    {{ HTML::script('assets/js/prettify.js') }}
    {{ HTML::script('assets/js/ckeditor/ckeditor.js')}}

    <!-- Custom -->
    @yield('script')

    <!-- Foundation main-->
    <script>
        $(document).foundation();
    </script>
    <!-- CKEditor -->
    <script>
        CKEDITOR.replace( 'wysiwyg' );
    </script>
    </body>
</html>