<!-- BEGIN PAGE TOP -->
<div class="page-top">
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
        <ul class="nav navbar-nav pull-right">
            <li class="separator hide">
            </li>
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            @include('backend.layouts.'.config('var.dashboard_theme').'.notification')
            <!-- BEGIN USER LOGIN DROPDOWN -->
            
            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
            <li class="dropdown dropdown-user dropdown-dark">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="username username-hide-on-mobile"> {{ auth()->guard('admin')->user()->first_name . ' ' . auth()->guard('admin')->user()->last_name }}</span> </span>
                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
               
                </a>
                <ul class="dropdown-menu dropdown-menu-default">
                    <li>
                        <a href="{{ route('dashboard_profile') }}">
                        <i class="icon-user"></i> My Profile </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard_logout') }}">
                        <i class="icon-key"></i> Log Out </a>
                    </li>
                </ul>
            </li>
            <!-- END USER LOGIN DROPDOWN -->
        </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
</div>
<!-- END PAGE TOP -->