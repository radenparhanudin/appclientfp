<div class="navbar navbar-inverse navbar-fixed-top">
   <!-- start: TOP NAVIGATION CONTAINER -->
   <div class="container">
      <div class="navbar-header">
         <!-- start: RESPONSIVE MENU TOGGLER -->
         <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
         <span class="clip-list-2"></span>
         </button>
         <!-- end: RESPONSIVE MENU TOGGLER -->
         <!-- start: LOGO -->
         <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.description') }}
         </a>
         <!-- end: LOGO -->
      </div>
      <div class="navbar-tools">
         <!-- start: TOP NAVIGATION MENU -->
         <ul class="nav navbar-right">
            <!-- start: USER DROPDOWN -->
            <li class="dropdown current-user">
               <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
                  <img src="{{ asset('public/template') }}/assets/images/avatar-1-small.jpg" class="circle-img" alt="">
                  <span class="username text-lowercase">{{ config('app.name') }}</span>
                  <i class="clip-chevron-down"></i>
               </a>
               <ul class="dropdown-menu">
                  <li>
                     <a href="{{ route('auth.logout') }}">
                        <i class="clip-exit"></i> &nbsp;Keluar
                     </a>
                  </li>
               </ul>
            </li>
            <!-- end: USER DROPDOWN -->
         </ul>
         <!-- end: TOP NAVIGATION MENU -->
      </div>
   </div>
   <!-- end: TOP NAVIGATION CONTAINER -->
</div>