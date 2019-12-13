<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title', 'Sistema') &mdash; {{ env('APP_NAME') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  @yield('css')

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        @include('admin.partials.topnav')
      </nav>
      <div class="main-sidebar">
        @include('admin.partials.sidebar')
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        @include('admin.partials.footer')
      </footer>
    </div>
  </div>

  <script src="{{ route('js.dynamic') }}"></script>
  <script src="{{ asset('js/app.js') }}?{{ uniqid() }}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
  <script src="{{ asset('assets/modules/popper.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.js') }}"></script>
  
  <script src="{{ asset('assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  
  @yield('scripts')
</body>
</html>
