<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">

        <li class="start">
            <a href="{{ route('main_dashboard') }}">
            <i class="icon-home"></i>
            <span class="title">{{ appendToLanguage($lang,'globals','Dashboard') }}</span>
            </a>
        </li>
        @php
            $modules = getModulesFromGroup('without_department');
            $dashboard_route = config('var.dashboard_route');
            $current_uri=request()->route()->uri();
        @endphp
        @foreach ($modules as $module)
            @if(checkAdminPermission("view",$module->id))
                <li {{ ($current_uri==$dashboard_route.'/'.'modules/'.$module->route_repo)?'active':'' }}>
                    <a href="{{ route($module->route_repo.'.index') }}">
                        <i class="icon-info"></i>
                        <span class="title">{{ appendToLanguage($lang,'globals',$module->name) }}</span>
                    </a>
                </li>
            @endif
        @endforeach

        @foreach (getDepartments(true) as $key=>$department)

            @if ($department['name']!=null && checkDebpartmentShow($department['name']))
                <li {{ (checkDepartmentActive($department['name'],request()->route()->uri()))?'class=active':'' }}>
                    <a href="javascript:;">
                    <i class="{{ $department['icon'] }}"></i>
                    <span class="title">{{ appendToLanguage($lang,'globals',$department['title']) }}</span>
                    <span class="arrow "></span>
                    </a>
                    @php
                        $sub_departments = getDepartments(true,$department['name']);
                        $modules = getModulesFromGroup($department['name']);
                        $dashboard_route = config('var.dashboard_route');
                        $current_uri=request()->route()->uri();
                    @endphp
                    <ul class="sub-menu">
                        @foreach ($sub_departments as $sub_department)
                            @if (checkDebpartmentShow($department['name']))
                                @php
                                    $sub_modules = getModulesFromGroup($sub_department['name']);
                                @endphp
                                <li {{ (checkDepartmentActive($department['name'],request()->route()->uri()))?'class=active':'' }}>
                                    <a href="javascript:;">
                                        {{ appendToLanguage($lang,'globals',$sub_department['title']) }}<span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        @foreach ($sub_modules as $sub_module)
                                            @if(checkAdminPermission("view",$sub_module->id))
                                                <li>
                                                    <a href="{{ route($sub_module->route_repo.'.index') }}">{{ appendToLanguage($lang,'globals',$sub_module->name) }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </li>
                            @endif

                        @endforeach


                        @foreach ($modules as $module)
                            @if(checkAdminPermission("view",$module->id))
                                <li {{ ($current_uri==$dashboard_route.'/'.'modules/'.$module->route_repo)?'active':'' }}>
                                    <a href="{{ route($module->route_repo.'.index') }}">{{ appendToLanguage($lang,'globals',$module->name) }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif

        @endforeach





        @if(checkAdminPermission(3,['Roles','Admin','Branches'],'specific'))
            <li>
                <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">{{ appendToLanguage($lang,'globals','Administration') }}</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    @if(checkAdminPermission(3,'Roles','specific'))
                    <li>
                        <a href="{{ route('roles.index') }}">
                            {{ appendToLanguage($lang,'globals','Roles && Permissions') }}</a>
                    </li>
                    @endif

                    @if(checkAdminPermission(3,'Admin','specific'))
                    <li>
                        <a href="{{ route('admins.index') }}">
                            {{ appendToLanguage($lang,'globals','Admins') }}</a>
                    </li>
                    @endif

                    @if(checkAdminPermission(3,'Branches','specific'))
                    <li>
                        <a href="{{ route('branches.index') }}">
                            {{ appendToLanguage($lang,'globals','Branches') }}</a>
                    </li>
                    @endif

                    @if(checkAdminPermission('',"logs_section",true))
                    {{-- <li>
                        <a href="login_3.html">
                            {{ appendToLanguage($lang,'globals','Activities Logs') }}</a>
                    </li> --}}
                    @endif
                    @if(checkAdminPermission(1,"Boards",true))
                    <li class="start">
                        <a href="{{ route('boards.index') }}">
                        {{ appendToLanguage($lang,'globals','Boards') }}
                        </a>
                    </li>
                    @endif


                </ul>
            </li>
        @endif

        {{-- <li>
            <a href="javascript:;">
            <i class="icon-bar-chart"></i>
            <span class="title">{{ appendToLanguage($lang,'globals','Reports') }}</span>
            <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                @foreach (reportsLinks() as $key=>$value)
                    @if(checkAdminPermission($key,$key,'report'))
                        <li class="start">
                            <a href="{{ route('dashboard_single_report',$key) }}">
                            <i class="icon-info"></i>
                            <span class="title">{{ appendToLanguage($lang,'globals',$value) }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </li> --}}
        @if(checkAdminPermission(3,'ContactUs','specific'))
            <li>
                <a href="{{ route('contact-us.index') }}">
                    <i class="icon-envelope"></i>
                    {{ appendToLanguage($lang,'globals','Contact Us') }}
                    <span class="badge badge-danger" id="contactUs_badge">{{ getBadge(1) }}</span>
                </a>
            </li>
        @endif
        @if(checkAdminPermission(3,[1,2,3,4,5],'specific') || checkAdminPermission(3,['Countries','States','Cities','Districts'],'specific'))
            <li>
                <a href="javascript:;">
                <i class="icon-settings"></i>
                <span class="title">{{ appendToLanguage($lang,'globals','Settings') }}</span>
                <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    @if(checkAdminPermission(3,[1,2,3,4,5],'specific'))
                        <li>
                            <a href="javascript:;">
                                <span class="title">{{ appendToLanguage($lang,'globals','Configrations') }}</span>
                                <span class="arrow "></span>
                                </a>
                                <ul class="sub-menu">
                                    @if(checkAdminPermission(1,'Settings','specific'))
                                        <li>
                                            <a href="{{ route('generals.index') }}">
                                                {{ appendToLanguage($lang,'globals','Gloable Configrations') }}</a>
                                        </li>
                                    @endif
                                    @if(checkAdminPermission(2,'Settings','specific'))
                                        <li>
                                            <a href="{{ route('seo.index') }}">
                                                {{ appendToLanguage($lang,'globals','Seo Configrations') }}</a>
                                        </li>
                                    @endif
                                    @if(checkAdminPermission(3,'Settings','specific'))
                                        <li>
                                            <a href="#">
                                                {{ appendToLanguage($lang,'globals','Email Configrations') }}</a>
                                        </li>
                                    @endif
                                    @if(checkAdminPermission(4,'Settings','specific'))
                                        <li>
                                            <a href="{{ route('generals.index') }}?type=payment_methods">
                                                {{ appendToLanguage($lang,'globals','Payment Configrations') }}</a>
                                        </li>
                                    @endif
                                    @if(checkAdminPermission(5,'Settings','specific'))
                                        <li class="start">
                                            <a href="{{ route('dashboard_lang') }}">
                                            <span class="title">{{ appendToLanguage($lang,'globals','Translations Configrations') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                        </li>
                    @endif

                    @if(checkAdminPermission(3,['Countries','States','Cities','Districts'],'specific'))
                        <li>
                            <a href="javascript:;">
                                <span class="title">{{ appendToLanguage($lang,'globals','Locations') }}</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                @if(checkAdminPermission(3,'Countries','specific'))
                                <li>
                                    <a href="{{ route('location.country.index') }}">
                                        {{ appendToLanguage($lang,'globals','Country') }}
                                    </a>
                                </li>
                                @endif
                                @if(checkAdminPermission(3,'States','specific'))
                                <li>
                                    <a href="{{ route('location.state.index') }}">
                                        {{ appendToLanguage($lang,'globals','State') }}
                                    </a>
                                </li>
                                @endif
                                @if(checkAdminPermission(3,'Cities','specific'))
                                <li>
                                    <a href="{{ route('location.city.index') }}">
                                        {{ appendToLanguage($lang,'globals','City') }}
                                    </a>
                                </li>
                                @endif
                                @if(checkAdminPermission(3,'Districts','specific'))
                                <li>
                                    <a href="{{ route("location.district.index") }}">
                                        {{ appendToLanguage($lang,'globals','District') }}
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if(checkAdminPermission(6,'Settings','specific'))
                    <li>
                        <a href="{{ route('generals.index') }}?type=static_pages">
                            {{ appendToLanguage($lang,'globals','Static Pages') }}
                        </a>
                    </li>
                    @endif
                    @if(checkAdminPermission(7,'Settings','specific'))
                    <li>
                        <a href="{{ route('generals.index') }}?type=sochiel_links">
                            {{ appendToLanguage($lang,'globals','Sochiel Media Links') }}
                        </a>
                    </li>
                    @endif


                </ul>
            </li>
        @endif

        @if(auth()->guard('admin')->user()->is_developer==1)
        <li>
            <a href="javascript:;">
            <i class="icon-settings"></i>
            <span class="title">{{ appendToLanguage($lang,'globals','Installation') }}</span>
            <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="javascript:;">
                        {{ appendToLanguage($lang,'globals','DataBase Management') }}<span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('connect_database.add_form') }}">{{ appendToLanguage($lang,'globals','Connection') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('tables.index') }}">{{ appendToLanguage($lang,'globals','Tables & Fields') }}</a>
                        </li>

                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        {{ appendToLanguage($lang,'globals','Builders Management') }}<span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('modules.index') }}">{{ appendToLanguage($lang,'globals','Modules') }}</a>
                        </li>
                        <li>

                            <a href="{{ route('counters.index') }}">{{ appendToLanguage($lang,'globals','Counters') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('charts.index') }}">{{ appendToLanguage($lang,'globals','Charts') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('reports.index') }}">{{ appendToLanguage($lang,'globals','Reports') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('api.index') }}">{{ appendToLanguage($lang,'globals','Api') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('tranfare.index') }}">{{ appendToLanguage($lang,'globals','Enums') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('notifications.index') }}">{{ appendToLanguage($lang,'globals','Notifications') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('tranfare.index') }}">{{ appendToLanguage($lang,'globals','Data transfer') }}</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                    {{ appendToLanguage($lang,'globals','FrontEnd Management') }}<span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Themes && Static Pages') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Css & JavaScript Links') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Navigation Management') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Header & Footer') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','HomePage & Layouts') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Components & Forms') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Pages Builder') }}</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                        {{ appendToLanguage($lang,'globals','Api Management') }}<span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Variables') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Requests') }}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;">
                    {{ appendToLanguage($lang,'globals','Settings Management') }}<span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="{{ route('generals.index') }}?type=system_config">
                                {{ appendToLanguage($lang,'globals','Main Settings') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('languages.index') }}">{{ appendToLanguage($lang,'globals','Languages') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('codes.index') }}">{{ appendToLanguage($lang,'globals','Codes') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','User Types && Dashboards') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('generals.index') }}?type=sochiel_media_login">{{ appendToLanguage($lang,'globals','Social Login') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Cash Management') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Packages') }}</a>
                        </li>
                        <li>
                            <a href="#">{{ appendToLanguage($lang,'globals','Email') }}</a>
                        </li>

                    </ul>
                </li>
            </ul>
        </li>
        @endif

    </ul>
    <!-- END SIDEBAR MENU -->
</div>
