<!DOCTYPE html>
<!--[if IE 8]><html class="ie8 no-js" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie9 no-js" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html class="no-js">
   <!--<![endif]-->
   @include('backend/head')
   <body>
      <!-- start: HEADER -->
      @include('backend/navbar')
      <!-- end: HEADER -->
      <!-- start: MAIN CONTAINER -->
      <div class="main-container">
         <div class="navbar-content">
            <!-- start: SIDEBAR -->
            @include('backend/sidebar')
            <!-- end: SIDEBAR -->
         </div>
         <!-- start: PAGE -->
         @yield('container-fluid')
         <!-- end: PAGE -->
      </div>
      <!-- end: MAIN CONTAINER -->
      <!-- start: FOOTER -->
      @include('backend/footer')
      <!-- end: FOOTER -->
      @include('backend/foot')
   </body>
</html>