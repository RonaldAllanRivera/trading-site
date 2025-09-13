<!DOCTYPE html>
<html lang="en">
@include('landing.includes.head')
 <body class="body">
  <div class="main-wrapper">
    @include('landing.includes.header')
    @yield('content')
    @include('landing.includes.sticky')
    @include('landing.includes.footer')
  </div>
  @include('landing.includes.scripts')
  @stack('scripts')
  @stack('body_tracking')
 </body>
</html>
