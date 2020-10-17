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
                  Check Mesin Support
               </li>
            </ol>
            <div class="page-header">
               <h1>Check Mesin Support <small class="pl-3 font-weight-bold"> {{ config('app.description') }}</small></h1>
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
                  <i class="fa fa-check"></i> IP Address Finger Print
               </div>
               <div class="panel-body pt-5">
                  <form id="formCheck" class="form-horizontal" action="{{ route('typea.check-mesin-support.check') }}" method="POST">
                     <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-2">
                           <input type="text" name="input_ip_address" id="input_ip_address" class="form-control" placeholder="IP Address : 192.168.1.201" >
                        </div>
                        <div class="col-sm-2">
                           <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Check Mesin</button>
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
                  <i class="fa fa-refresh"></i> Result
               </div>
               <div class="panel-body">
                  <div class="row">
                     <div class="col-sm-6">
                        <table class="table table-striped w-100">
                           @php
                              $data1 = array('ip_address' => 'IP Address', 'platform' => 'Platform', 'serial_number' => 'Serial Number', 'oem_vendor' => 'OEM Vendor');
                           @endphp
                           @foreach ($data1 as $key => $value)
                           <tr>
                              <td class="w-25">{{ $value }}</td>
                              <td width="2px">:</td>
                              <td id="{{ $key }}"></td>
                           </tr>
                           @endforeach
                        </table>
                     </div>
                     <div class="col-sm-6">
                        <table class="table table-striped w-100">
                           @php
                              $data2 = array('mac_address' => 'MAC Address', 'device_name' => 'Device Name', 'manufacture_time' => 'Manufacture Time', 'firmware_version' => 'firmware Version');
                           @endphp
                           @foreach ($data2 as $key => $value)
                           <tr>
                              <td class="w-25">{{ $value }}</td>
                              <td width="2px">:</td>
                              <td id="{{ $key }}"></td>
                           </tr>
                           @endforeach
                        </table>
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table table-striped w-100">
                           @php
                              $data1 = array('Name' => 'Nama', 'PIN' => 'PIN', 'PIN2' => 'PIN2');
                           @endphp
                           @foreach ($data1 as $key => $value)
                           <tr>
                              <td class="w-25">{{ $value }}</td>
                              <td width="2px">:</td>
                              <td id="{{ $key }}"></td>
                           </tr>
                           @endforeach
                        </table>
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-12">
                        <table class="table table-striped w-100">
                           @php
                              $data1 = array('PINatt_log' => 'PIN', 'DateTime' => 'DateTime', 'Verified' => 'Verified');
                           @endphp
                           @foreach ($data1 as $key => $value)
                           <tr>
                              <td class="w-25">{{ $value }}</td>
                              <td width="2px">:</td>
                              <td id="{{ $key }}"></td>
                           </tr>
                           @endforeach
                        </table>
                     </div>
                  </div>
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
      const Toast = Swal.mixin({
           toast: true,
           position: 'middle-center',
           showConfirmButton: false,
           timer: 3000
       });

      $('#formCheck').submit(function (event) {
         event.preventDefault();
         action = $('#formCheck').attr('action');
         method = $('#formCheck').attr('method');
         data   = $('#formCheck').serialize();

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
                  $.each(response.info_mesin, function(index, val) {
                     $('#' + index).html(val)
                  });
                  $.each(response.user_info, function(index, val) {
                     $('#' + index).html(val)
                  });
                  $.each(response.att_log, function(index, val) {
                     $('#' + index).html(val)
                  });
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