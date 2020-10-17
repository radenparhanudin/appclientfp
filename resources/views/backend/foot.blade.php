<!-- start: MAIN JAVASCRIPTS -->
<!--[if lt IE 9]>
<script src="{{ asset('public/template') }}/bower_components/respond/dest/respond.min.js"></script>
<script src="{{ asset('public/template') }}/bower_components/Flot/excanvas.min.js"></script>
<script src="{{ asset('public/template') }}/bower_components/jquery-1.x/dist/jquery.min.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!--<![endif]-->
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/blockUI/jquery.blockUI.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/perfect-scrollbar/js/min/perfect-scrollbar.jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/bower_components/jquery.cookie/jquery.cookie.js"></script>
<script src="{{ asset('public/template') }}/bower_components/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{ asset('public/template/bower_components/jquery-validation/src/localization/messages_id.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="{{ asset('public/template') }}/assets/js/min/main.min.js"></script>
<script src="{{ asset('public/js/app.js') }}"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{ asset('public/template') }}/bower_components/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('public/template') }}/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('public/template') }}/bower_components/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="{{ asset('public/template') }}/bower_components/bootstrap-modal/js/bootstrap-modal.js"></script>
<script src="{{ asset('public/template') }}/bower_components/bootstrap-modal/js/bootstrap-modalmanager.js"></script>
@stack('script')
