@extends('backend')
@section('container-fluid')
<div class="container-fluid">
   <!-- Page Heading -->
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
   </div>
   <!-- Content Row -->
   <div class="row">
      <!-- Content Column -->
      <div class="col-lg-12 mb-4">
         <div class="card shadow mb-4">
            <div class="card-header py-3">
               <h6 class="m-0 font-weight-bold text-primary text-center">Welcome Back</h6>
            </div>
            <div class="card-body">
               <div class="text-center">
                  <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('public/sbadmin') }}/img/undraw_posting_photo.svg" alt="">
               </div>
               <p class="text-center">
                  Jika bapak/ibu mengalami kendala dalam menggunakan aplikasi ini silahkan kontak <br> <strong class="text-info">WA : 082 342 788 059</strong>
               </p>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('script')
   <script src="{{ asset('public/sbadmin') }}/vendor/chart.js/Chart.min.js"></script>
   <script src="{{ asset('public/sbadmin') }}/js/demo/chart-area-demo.js"></script>
   <script src="{{ asset('public/sbadmin') }}/js/demo/chart-pie-demo.js"></script>
@endpush