@extends('backend')
@section('container-fluid')
<div class="main-content">
   <div class="container">
      <!-- start: PAGE HEADER -->
      <div class="row">
         <div class="col-sm-12">
            <!-- start: PAGE TITLE & BREADCRUMB -->
            <ol class="breadcrumb">
               <li>
                  <i class="clip-home-3"></i>
                  <a href="{{ route('dashboard.index') }}">
                     Dashboard
                  </a>
               </li>
               <li class="active">
                  Register Mesin
               </li>
            </ol>
            <div class="page-header">
               <h1>Register Mesin <small class="pl-3 font-weight-bold"> {{ config('app.description') }}</small></h1>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
         </div>
      </div>
      <!-- end: PAGE HEADER -->
      <!-- start: PAGE CONTENT -->
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-laptop"></i> Register Mesin
               </div>
               <div class="panel-body pt-5">
                  <form id="formRegister" class="form-horizontal" action="{{ route('typea.register-mesin.store') }}" method="POST">
                     <div class="form-group">
                        <div class="col-sm-3 fg">
                           <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="IP Address" >
                        </div>
                        <div class="col-sm-3 fg">
                           <input type="text" name="no_mesin" id="no_mesin" class="form-control" placeholder="No. Mesin" >
                        </div>
                        <div class="col-sm-3 fg">
                           <input type="text" name="nama_mesin" id="nama_mesin" class="form-control" placeholder="Nama Mesin" >
                        </div>
                        <div class="col-sm-3">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-laptop"></i> Register</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <!-- end: TEXT FIELDS PANEL -->
         </div>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <i class="fa fa-laptop"></i> Data Mesin
               </div>
               <div class="panel-body table-responsive">
                  <table id="tableRegister" class="table table-striped table-bordered table-hover w-100">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th>IP Address</th>
                           <th>Nama Device</th>
                           <th>Serial Number</th>
                           <th>Vendor</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody></tbody>
                  </table>
               </div>
            </div>
            <!-- end: TEXT FIELDS PANEL -->
         </div>
      </div>
   </div>
</div>
<div id="modalEdit" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" style="display: none;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title">Edit IP Address</h4>
   </div>
   <form id="formEditIP" method="PUT">
      <div class="modal-body">
         <div class="form-group mb-0">
            <input type="text" name="edit_ip_address" id="edit_ip_address" class="form-control" placeholder="IP Address Mesin">
         </div>
      </div>
      <div class="modal-footer">
         <button type="submit" class="btn btn-primary">
            <i class="fa fa-save mr-2"></i>Simpan
         </button>
         <button type="button" data-dismiss="modal" class="btn btn-default">
            Batal
         </button>
      </div>
   </form>
</div>
@endsection
@push('script')
<script>
   $(document).ready(function() {
      var mdl_base_url = "{{ route('typea.register-mesin.index') }}";
      const Toast = Swal.mixin({
           toast: true,
           position: 'middle-center',
           showConfirmButton: false,
           timer: 3000
       });

      var tableRegister =$('#tableRegister').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            url: "{{ route('typea.register-mesin.data') }}"
         },
         columns: [
            {data: 'DT_Row_Index', name: 'id', className: 'w-5 text-center'},
            {data: 'nama_mesin', name: 'nama_mesin', className: 'text-nowrap' },
            {data: 'ip_address', name: 'ip_address', className: 'text-nowrap' },
            {data: 'device_name', name: 'device_name', className: 'text-nowrap' },
            {data: 'serial_number', name: 'serial_number', className: 'text-nowrap' },
            {data: 'oem_vendor', name: 'oem_vendor', className: 'text-nowrap' },
            {data: 'action', name: 'action', className: 'w-15 text-center text-nowrap'}, 
         ],
         "initComplete": function(settings, json) {
            $('#tableRegister_filter input').unbind();
            $('#tableRegister_filter input').bind('keyup', function(e) {
               if (this.value == "" || e.keyCode == 13) {
                  $('#tableRegister').DataTable().search(this.value).draw();
               }
            });
         },
      });

      $('#formRegister').submit(function (event) {
         event.preventDefault();
         action = $('#formRegister').attr('action');
         method = $('#formRegister').attr('method');
         data   = $('#formRegister').serialize();

         $('#formRegister').find('.help-block').remove();
         $('#formRegister').find('.fg').removeClass('has-error');

         $.ajax({
            url: action,
            type: method,
            data: data,
            beforeSend: function () {
               Swal.fire({
                  html: 'Permintaan sedang di proses ... .!',
                  onBeforeOpen: () => {
                     Swal.showLoading()
                  }
               })
            },
            success: function (response) {
               Swal.close()
               if (response.success) {
                  Swal.fire({
                     text: response.message,
                     type: "success",
                  })
                  $('#tableRegister').DataTable().ajax.reload(null, false);
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
                  Swal.close()
                  // Toast.fire({
                  //    type: 'error',
                  //    title: res.message
                  // })

                  $.each(res, function (key, value) {
                     $('#' + key)
                         .closest('.fg')
                         .addClass('has-error')
                         .append('<span class="help-block">' + value[0] + '</span>');
                 });
               }
            }
         })
      });

      // modalEdit
      $('#tableRegister').on('click', '.btn-edit', function(event) {
         event.preventDefault();
         $.ajax({
            url: $(this).attr('href'),
            beforeSend: function () {
               Swal.fire({
                  text: 'Permintaan sedang di proses ... .',
                  onBeforeOpen: () => {
                     Swal.showLoading()
                  }
               })
            },
            success:function (response) {
               if (response.errors) {
                  Swal.close()
                  console.log(response);
               }
               if (response.success) {
                  Swal.close()
                  $('#formEditIP').attr('action', mdl_base_url + "/" + response.content.id);
                  $('#formEditIP').attr('method', "PUT");
                  $.each(response.content, function (index, val) {
                     $('#' + index).val(val)
                  });
                  $('#modalEdit').modal('show');
               }
            }
         })
      });

      $('#formEditIP').submit(function (event) {
         event.preventDefault();
         action = $('#formEditIP').attr('action');
         method = $('#formEditIP').attr('method');
         data   = $('#formEditIP').serialize();

         $('#formEditIP').find('.help-block').remove();
         $('#formEditIP').find('.form-group').removeClass('has-error');

         $.ajax({
            url: action,
            type: method,
            data: data,
            beforeSend: function () {
               Swal.fire({
                  html: 'Permintaan sedang di proses ... .!',
                  onBeforeOpen: () => {
                     Swal.showLoading()
                  }
               })
            },
            success: function (response) {
               Swal.close()
               if (response.success) {
                  Swal.fire({
                     text: response.message,
                     type: "success",
                  })
                  $('#modalEdit').modal('hide');
                  $('#tableRegister').DataTable().ajax.reload(null, false);
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
                  Swal.close()
                  // Toast.fire({
                  //    type: 'error',
                  //    title: res.message
                  // })
                  $('#edit_ip_address').closest('.form-group')
                  .addClass('has-error')
                  .append('<span class="help-block">' + res.edit_ip_address + '</span>');
               }
            }
         })
      });

   });
</script>
@endpush