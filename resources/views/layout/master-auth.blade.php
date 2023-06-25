<!doctype html>
<html class="h-full bg-white">
  <head>
      <title>Product Management</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Scripts -->
      <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

      <!-- import tailwind -->
      <script src="{{ asset('js/app.js') }}" defer></script>
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

      <title>Product Management</title>


      <!--Regular Datatables CSS-->
      <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
      <!--Responsive Extension Datatables CSS-->
      <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  </head>



  <body class="bg-white text-gray-900 tracking-wider leading-normal">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 p-6">
        @yield('main-content')
    </div>
  </body>
</html>