@include('backend.headers.'.config('var.dashboard_theme').'.index')
<div class="page-header navbar navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="page-header-inner">
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="{{ route('main_dashboard') }}">
			<img src="{{ readFileStorage(appSettings('app_logo')) }}" alt="logo" class="logo-default"/>
			</a>
			<div class="menu-toggler sidebar-toggler">
				<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
			</div>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->

        @include('backend.layouts.'.config('var.dashboard_theme').'.top_menu')
	</div>
	<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>



<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		@include('backend.layouts.'.config('var.dashboard_theme').'.menu')
	</div>
	<!-- END SIDEBAR -->

@yield('page_content')

	<!-- END CONTENT -->
</div>







<!-- BEGIN FOOTER -->
<div class="page-footer">
	{{-- <div class="page-footer-inner">
		 2014 &copy; Metronic by keenthemes.
	</div> --}}
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>


@include('backend.footer.'.config('var.dashboard_theme').'.index')
