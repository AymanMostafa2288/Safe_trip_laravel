@php
    $admin=config('var.dashboard_theme_dist');
    if(getDashboardCurrantLanguage() == 'ar')
        $admin=config('var.dashboard_theme_dist').'rtl';
@endphp
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>

<link href="{{ $admin }}/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="{{ $admin }}/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="{{ $admin }}/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<script type="text/javascript" src="{{ $admin }}/global/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="{{ $admin }}/global/plugins/ckeditor/config.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="{{ $admin }}/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/plugins/morris/morris.css" rel="stylesheet" type="text/css">
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="{{ $admin }}/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->
<link href="{{ $admin }}/global/css/components-rounded.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="{{ $admin }}/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css" id="style_color"/>

<link href="{{ $admin }}/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ $admin }}/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<!-- END THEME STYLES -->
<link href="{{ $admin }}/global/plugins/pekeUpload/style.css" rel="stylesheet"/>
<link rel="shortcut icon" href="favicon.ico"/>

@yield('style_url')

@yield('style_in_page')



<!-- END GLOBAL MANDATORY STYLES -->
