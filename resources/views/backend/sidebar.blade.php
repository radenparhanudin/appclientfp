{{-- 
@if (Request::is('dashboard'))
@include("dashboard::sidebar")
@endif
@if (Request::is('typea/*'))
@include("typea::sidebar")
@endif
--}}
<div class="main-navigation navbar-collapse collapse">
   <!-- start: MAIN MENU TOGGLER BUTTON -->
   <div class="navigation-toggler">
      <i class="clip-chevron-left"></i>
      <i class="clip-chevron-right"></i>
   </div>
   <!-- end: MAIN MENU TOGGLER BUTTON -->
   <!-- start: MAIN NAVIGATION MENU -->
   <ul class="main-navigation-menu">
      <li>
         <!--active open-->
         <a href="{{ route('dashboard.index') }}">
            <i class="clip-home-3"></i>
            <span class="title"> Dashboard </span><span class="selected"></span>
         </a>
      </li>
      <li class=" {{ set_active(['typea.check-mesin-support.index', 'typea.register-mesin.index', 'typea.upload-log-attandance.index'], 'open') }}">
         <a href="javascript:void(0)">
            <i class="clip-screen"></i>
            <span class="title"> Mesin Tipe A </span><i class="icon-arrow"></i>
            <span class="selected"></span>
         </a>
         <ul class="sub-menu {{ set_active([
            'typea.check-mesin-support.index', 'typea.register-mesin.index',
            'typea.upload-log-user.index', 'typea.upload-log-attandance.index'
            ], 'd-block') }}">
            <li class="{{ set_active('typea.upload-log-attandance.index') }}">
               <a href="{{ route('typea.upload-log-attandance.index') }}">
                  <span class="title">Upload Log Absensi</span>
               </a>
            </li>
            <li class="{{ set_active('typea.upload-log-user.index') }}">
               <a href="{{ route('typea.upload-log-user.index') }}">
                  <span class="title">Upload Log User</span>
               </a>
            </li>
            <li class="{{ set_active('typea.register-mesin.index') }}">
               <a href="{{ route('typea.register-mesin.index') }}">
                  <span class="title">Register Mesin</span>
               </a>
            </li>
            <li class="{{ set_active('typea.check-mesin-support.index') }}">
               <a href="{{ route('typea.check-mesin-support.index') }}">
                  <span class="title">Check Mesin Support</span>
               </a>
            </li>
         </ul>
      </li>
   </ul>
   <!-- end: MAIN NAVIGATION MENU -->
</div>