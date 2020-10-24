<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="WMS SEID.">
    <meta name="keywords" content="WMS SEID">
    <meta name="author" content="ThemeSelect">
    <title>User Login | WMS SEID</title>
    <link rel="apple-touch-icon" href="{{ url('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
    <link href="{{ url('materialize/css/icon.css') }}" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('materialize/vendors/vendors.min.css')}}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('materialize/css/materialize.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('materialize/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('materialize/css/pages/login.css')}}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{url('materialize/css/custom/custom.css')}}">
    <style type="text/css">
        .login-bg {
            background-image: none; 
        }
    </style>
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 1-column login-bg   blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <div id="login-page" class="row">
                    <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
                        <form class="login-form" method="POST" action="{{ url('login') }}">
                            @csrf
                            <div class="row center-align">
                                <div class="input-field col s12">
                                    <img src="{{asset('app_logo.png')}}">
                                    <h5 class="ml-4">SEID WAREHOUSE MANAGEMENT SYSTEM</h5>
                                </div>
                                <div class="col s12 center-align">
                                    @error('username')
                                    <span class="red-text darken-4 mb-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">person_outline</i>
                                    <input name="username" id="username" type="text" value="{{ old('username') }}" required>
                                    <label for="username" class="center-align">{{ __('Username') }}</label>
                                </div>
                            </div>
                            <div class="row margin">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix pt-2">lock_outline</i>
                                    <input name="password" id="password" type="password" required>
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12 ml-2 mt-1">
                                    <p>
                                        <label>
                                            <input type="checkbox" name="remember" id="remember" checked />
                                            <span>Ingat saya</span>
                                        </label>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    {{-- <a href="{{ url('dashboard') }}" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Masuk</a> --}}
                                    <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-blue-indigo col s12">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>

    <!-- BEGIN VENDOR JS-->
    <script src="{{url('materialize/js/vendors.min.js') }}"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="{{url('materialize/js/plugins.js') }}"></script>
    <script src="{{url('materialize/js/search.js') }}"></script>
    <script src="{{url('materialize/js/custom/custom-script.js') }}"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- END PAGE LEVEL JS-->
</body>

</html>
