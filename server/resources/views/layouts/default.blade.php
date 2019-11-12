<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title','上海习业') - L/V 初始化框架</title> 
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>
  	@include('layouts._header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>
  </body>
</html>