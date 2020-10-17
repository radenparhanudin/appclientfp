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
                  Upload Log Absensi
               </li>
            </ol>
            <div class="page-header">
               <h1>Upload Log Absensi <small class="pl-3 font-weight-bold"> {{ config('app.description') }}</small></h1>
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
                  <i class="fa fa-upload"></i> Upload Log Absensi
               </div>
               <div class="panel-body pt-5">
                  <form id="formUploadLogAbsensi" class="form-horizontal" action="{{ route('typea.upload-log-attandance.store') }}" method="POST">
                     <div class="form-group">
                        <div class="col-sm-9 fg">
                           <select name="mesin_id" id="mesin_id" required class="form-control select2" data-placeholder="Pilih Mesin">
                              <option></option>
                           </select>
                        </div>
                        <div class="col-sm-3">
                           <button type="submit" class="btn btn-danger"><i class="fa fa-upload"></i> Upload</button>
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
                  <table id="tableUploadLogAbsensi" class="table table-striped table-bordered table-hover w-100">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>PIN</th>
                           <th>Tanggal</th>
                           <th>Jam</th>
                           <th>Mesin</th>
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
@endsection
@push('script')
<script>
   $(document).ready(function() {
      var mdl_base_url = "{{ route('typea.upload-log-attandance.index') }}";
      var get_mesin    = "{{ route('typea.upload-log-attandance.get_mesin') }}";

      const Toast = Swal.mixin({
           toast: true,
           position: 'middle-center',
           showConfirmButton: false,
           timer: 3000
       });

      $.post(get_mesin, function(data, textStatus, xhr) {
         $('#mesin_id').empty();
         $('#mesin_id').append('<option></option>')
         $('#mesin_id').append('<option></option>')
         $.each(data.content, function(index, val) {
            $('#mesin_id').append('<option value="'+ val.id +'">'+val.nama_mesin+'</option>')
         });
      });

      var tableUploadLogAbsensi =$('#tableUploadLogAbsensi').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
            url: "{{ route('typea.upload-log-attandance.data') }}"
         },
         columns: [
            {data: 'DT_Row_Index', name: 'id', className: 'w-5 text-center'},
            {data: 'PIN', name: 'PIN', className: 'text-nowrap' },
            {data: 'Date', name: 'Date', className: 'text-nowrap' },
            {data: 'Time', name: 'Time', className: 'text-nowrap' },
            {data: 'nama_mesin', name: 'nama_mesin', className: 'text-nowrap' },
         ],
         "order": [[ 2, "desc" ], [ 3, "desc" ]],
         "initComplete": function(settings, json) {
            $('#tableUploadLogAbsensi_filter input').unbind();
            $('#tableUploadLogAbsensi_filter input').bind('keyup', function(e) {
               if (this.value == "" || e.keyCode == 13) {
                  $('#tableUploadLogAbsensi').DataTable().search(this.value).draw();
               }
            });
         },
      });

      $('#formUploadLogAbsensi').submit(function (event) {
         event.preventDefault();
         action = $('#formUploadLogAbsensi').attr('action');
         method = $('#formUploadLogAbsensi').attr('method');
         data   = $('#formUploadLogAbsensi').serialize();

         $('#formUploadLogAbsensi').find('.help-block').remove();
         $('#formUploadLogAbsensi').find('.fg').removeClass('has-error');

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
                  $('#tableUploadLogAbsensi').DataTable().ajax.reload(null, false);
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
                  Toast.fire({
                     type: 'error',
                     title: res.message
                  })

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
                  Toast.fire({
                     type: 'error',
                     title: res.message
                  })
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