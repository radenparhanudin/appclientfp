$(document).ready(function() {
	Main.init();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $('.select2').select2();
});