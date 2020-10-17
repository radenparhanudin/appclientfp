@extends('backend')
@section('container-fluid')
<div class="main-content">
   <div class="container">
      <!-- start: PAGE HEADER -->
      <div class="row">
         <div class="col-sm-12">
            <div class="page-header">
               <h1>Dashboard <small>{{ config('app.description') }}</small></h1>
            </div>
            <!-- end: PAGE TITLE & BREADCRUMB -->
         </div>
      </div>
      <!-- end: PAGE HEADER -->
      <!-- start: PAGE CONTENT -->
      <div class="row">
         <div class="col-sm-6">
            <div class="core-box">
               <div class="heading">
                  <i class="clip-checkmark-circle circle-icon circle-green"></i>
                  <h2>Cek Mesin</h2>
               </div>
               <div class="content">
                  Digunakan untuk mengecek apakah mesin finger anda sudah support {{ config('app.description') }}
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="core-box">
               <div class="heading">
                  <i class="clip-data circle-icon circle-teal"></i>
                  <h2>Register Mesin</h2>
               </div>
               <div class="content">
                  Digunakan untuk mendaftar mesin finger anda kedalam aplikasi simpeg.
               </div>
            </div>
         </div>
         
      </div>
      <div class="row">
         <div class="col-sm-6">
            <div class="core-box">
               <div class="heading">
                  <i class="clip-user-plus circle-icon circle-bricky"></i>
                  <h2>Upload Log User</h2>
               </div>
               <div class="content">
                  Digunakan untuk mengupload data user mesin finger anda kedalam aplikasi simpeg.
               </div>
            </div>
         </div>
         <div class="col-sm-6">
            <div class="core-box">
               <div class="heading">
                  <i class="clip-upload-3 circle-icon circle-bricky"></i>
                  <h2>Upload Log Absensi</h2>
               </div>
               <div class="content">
                  Digunakan untuk mengupload data log absensi mesin finger anda kedalam aplikasi simpeg.
               </div>
            </div>
         </div>
      </div>
      <!-- end: PAGE CONTENT-->
   </div>
</div>
@endsection
@push('script')
<script>
   $(document).ready(function() {
   });
</script>
@endpush