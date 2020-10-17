<head>
   <meta charset="utf-8">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
   <meta name="{{ config('app.description') }}" content="yes">
   <meta name="{{ config('app.description') }}" content="black">
   <meta content="{{ config('app.description') }} by Raden Parhanudin" name="description" />
   <meta content="Raden Parhanudin" name="author" />
   <title>{{ config('app.description') }}</title>
   <!-- end: META -->
   <!-- start: MAIN CSS -->
   <link type="text/css" rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700|Raleway:400,100,200,300,500,600,700,800,900/" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/bower_components/bootstrap/dist/css/bootstrap.min.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/bower_components/font-awesome/css/font-awesome.min.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/assets/fonts/clip-font.min.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/bower_components/iCheck/skins/all.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/assets/css/main.min.css" />
   <link type="text/css" rel="stylesheet" href="{{ asset('public/template') }}/assets/css/main-responsive.min.css" />
   <link type="text/css" rel="stylesheet" media="print" href="{{ asset('public/template') }}/assets/css/print.min.css" />
   <link type="text/css" rel="stylesheet" id="skin_color" href="{{ asset('public/template') }}/assets/css/theme/light.min.css" />
   <!-- end: MAIN CSS -->
   <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
   <link href="{{ asset('public/template') }}/bower_components/select2/dist/css/select2.min.css" rel="stylesheet" />
   <link href="{{ asset('public/template') }}/bower_components/datatables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="{{ asset('public/template') }}/bower_components/bootstrap-modal/css/bootstrap-modal-bs3patch.css">
   <link rel="stylesheet" href="{{ asset('public/template') }}/bower_components/bootstrap-modal/css/bootstrap-modal.css">
   @stack('style')
   {{-- <link href="{{ asset('public/template') }}/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" /> --}}
   <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
   <link rel="stylesheet" href="{{ asset('public/css/bs4.css') }}">
   <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
   <base href="{{ url('/') }}">
</head>