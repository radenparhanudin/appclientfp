@extends('auth')
@section('auth-body')
<div class="main-login col-sm-4 col-sm-offset-4">
	<div class="logo">
		{{ config('app.description') }}
	</div>
	<!-- start: LOGIN BOX -->
	<div class="box-login">
		<h3>Login App</h3>
		<p>
			Silahkan login menggunakan akun simpeg
		</p>
		<form id="formLogin" action="{{ route('auth.login') }}" method="POST">
			<fieldset>
				<div class="form-group">
					<span class="input-icon">
						<input type="text" name="username" id="username" class="form-control" placeholder="Username">
						<i class="fa fa-user"></i>
					</span>
				</div>
				<div class="form-group form-actions">
					<span class="input-icon">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password">
						<i class="fa fa-lock"></i>
					</span>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-bricky pull-right">
						Login <i class="fa fa-arrow-circle-right"></i>
					</button>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- end: LOGIN BOX -->
	<!-- start: COPYRIGHT -->
	<div class="copyright">
		<script>
			document.write(new Date().getFullYear())
		</script> &copy; <a href="http://sikda.lombokbaratkab.go.id/portal/"target="_blank">Prakom BKD & PSDM Lombok Barat.</a>
	</div>
	<!-- end: COPYRIGHT -->
</div>
@endsection
@push('script')
<script src="{{ asset('public/template') }}/assets/js/min/login.min.js"></script> <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
	jQuery(document).ready(function() {
		Login.init();
		
	    const Toast = Swal.mixin({
	        toast: true,
	        position: 'middle-center',
	        showConfirmButton: false,
	        timer: 3000
	    });

		$('#formLogin').submit(function (event) {
	        event.preventDefault();
			action = $('#formLogin').attr('action');
			method = $('#formLogin').attr('method');
			data   = $('#formLogin').serialize();

	        $.ajax({
	            url: action,
	            type: method,
	            data: data,
	            beforeSend: function () {
	                Swal.fire({
	                    html: 'Sedang mengecek data pengguna ... .!',
	                    onBeforeOpen: () => {
	                        Swal.showLoading()
	                    }
	                })
	            },
	            success: function (response) {
	                Swal.close()
	                if (response.success) {
	                	Swal.fire({
							title: 'Login Berhasil!',
							text: response.message,
							timer: 3000,
							type: "success",
							showConfirmButton: false
						}).then(function() {
						  	window.location.href = "{{ route('dashboard.index') }}";
						})
	                }

	                if (response.errors) {
	                    Toast.fire({
	                        title: response.message,
	                        type: 'error',
	                    })
	                }

	            },
	            error: function (xhr) {
	                var res = xhr.responseJSON;
	                if ($.isEmptyObject(res) == false) {
	                    Toast.fire({
	                        type: 'error',
	                        title: res.message
	                    })
	                }
	            }
	        })
	    });
	});
</script>
@endpush