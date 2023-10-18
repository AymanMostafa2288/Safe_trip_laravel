<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/respond.min.js"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ config('var.dashboard_theme_dist') }}/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="{{ config('var.dashboard_theme_dist') }}/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="{{ config('var.dashboard_theme_dist') }}/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="{{ config('var.dashboard_theme_dist') }}/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/global/scripts/metronic.js" type="text/javascript"></script>

<script src="{{ config('var.dashboard_theme_dist') }}/global/plugins/pekeUpload/script.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script src="{{ config('var.dashboard_theme_dist') }}/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/pages/scripts/form-samples.js"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/pages/scripts/index3.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="{{ config('var.dashboard_theme_dist') }}/admin/pages/scripts/table-managed.js"></script>


<script>
    var mainUrl='{{url("/")}}';
    var dashboardUrl= '{{url("/")}}'+'/'+'{{ config("var.dashboard_route") }}';
</script>
<script src="{{ config('var.dashboard_theme_dist') }}/custom.js"></script>
@yield('script_url')
@yield('script_url_custom')

@yield('script_in_page')
@yield('script_in_page_custom')