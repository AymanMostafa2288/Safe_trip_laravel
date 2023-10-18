<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.2
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>{{ appSettings('app_name') }} - Dashboard</title>
<link rel="icon" type="image/x-icon" href="{{ readFileStorage(appSettings('app_favicon')) }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="{{ config('var.dashboard_theme_dist') }}/admin/pages/css/login.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME STYLES -->
<link href="{{ config('var.dashboard_theme_dist') }}/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="{{ config('var.dashboard_theme_dist') }}/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="{{ config('var.dashboard_theme_dist') }}/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="login">
<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
<div class="menu-toggler sidebar-toggler">
</div>
<!-- END SIDEBAR TOGGLER BUTTON -->
<!-- BEGIN LOGO -->

<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
	<!-- BEGIN LOGIN FORM -->

	<form class="login-form" action="{{ route('post_login') }}" method="post">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<h3 class="form-title">Sign In</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any Email and password. </span>
		</div>
		@isset($message)
			<div id="prefix_1227265261315" class="Metronic-alerts alert alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{ $message }}
			</div>
		@endisset
		@if (session('error'))
        	<div id="prefix_1227265261315" class="Metronic-alerts alert alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
				{{ session('error') }}
			</div>
		@endif
		@if (session('errors'))

			@php
				$errors=session('errors')->all();
			@endphp

			@foreach($errors as $error)
				<div id="prefix_1227265261315" class="Metronic-alerts alert alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
					{{ $error }}
				</div>
			@endforeach
		@endif
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="email" name="email" autocomplete="off" placeholder="Email"  value="{{ (isset($email))?$email:old('email') }}"/>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<input class="form-control form-control-solid placeholder-no-fix" type="password" name="password" autocomplete="off" placeholder="Password"/>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-success uppercase">Sign In</button>
		</div>
		<div class="logo">
			<a href="{{ route('dashboard_login') }}">
			<img src="{{ readFileStorage(appSettings('app_logo')) }}" alt="{{ appSettings('app_name') }} Logo" style="width: 50%;"/>
			</a>
		</div>
	</form>
	<!-- END LOGIN FORM -->


</div>

<!-- END LOGIN -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/respond.min.js"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ config('var.dashboard_theme_dist') }}/global/scripts/metronic.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/layout/scripts/demo.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/pages/scripts/login.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Login.init();
Demo.init();
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
