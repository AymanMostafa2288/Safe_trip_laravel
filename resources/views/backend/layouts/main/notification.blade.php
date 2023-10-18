 <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->



<!-- END NOTIFICATION DROPDOWN -->
<li class="separator hide">
</li>
@foreach (getNotifications() as $notifications)
<li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <i class="{{ $notifications['icon'] }}"></i>
    <span class="badge badge-danger">
        {{ $notifications['count'] }} </span>
    </a>
    <ul class="dropdown-menu">
        <li class="external">
            <h3>{{ $notifications['name'] }}</h3>
        </li>
        <li>
            <div class="slimScrollDiv" style="position: relative; overflow: scroll; width: auto; height: 275px;"><ul class="dropdown-menu-list scroller" style="height: 275px; overflow: hidden; width: auto;" data-handle-color="#637283" data-initialized="1">
                @foreach (getNotifications($notifications['id'])??[] as $noti)
                <li>
                    <a href="{{ route($noti->url.'.show',$noti->row_id) }}?notify_show={{ $noti->id }}">

                    <span class="photo">
                        <i class="{{ $notifications['icon'] }}"></i>
                    </span>
                    <span class="subject">
                        <span class="from"> {{ $notifications['message'] }} </span>
                        <span class="time"> {{ date('Y-m-d',strtotime($noti->created_at)) }} </span>
                    </span>
                    <span class="message">
                        {{ $noti->message }}
                    </span>

                    </a>
                </li>
                @endforeach


            </ul><div class="slimScrollBar" style="background: rgb(99, 114, 131); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
        </li>
    </ul>
</li>
@endforeach

<!-- BEGIN TODO DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-extended dropdown-tasks dropdown-dark" id="header_task_bar">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <i class="icon-globe"></i>

    </a>
    <ul class="dropdown-menu extended tasks">

        <li>
            <ul class="dropdown-menu-list scroller" style="height: 110px;" data-handle-color="#637283">
                <li>
                    <a href="{{ route('dashboard_switch_lang',['lang'=>'ar']) }}">
                    <span class="task">
                        <span class="desc">Arabic </span>
                        <span class="percent">
                            @if($lang=='ar')
                            <span aria-hidden="true" class="icon-check"></span>
                            @endif
                        </span>
                    </span>

                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard_switch_lang',['lang'=>'en']) }}">
                    <span class="task">
                        <span class="desc">English</span>
                        <span class="percent">
                            @if($lang=='en')
                            <span aria-hidden="true" class="icon-check"></span>
                            @endif
                        </span>
                    </span>

                    </a>
                </li>



            </ul>
        </li>
    </ul>
</li>
<!-- END TODO DROPDOWN -->
