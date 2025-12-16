<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kuesioner - Contoh Formulir</title>
  @include('includes.style')
</head>
<body>

  <div class="form-container">
    <div class="form-header">
      <img src="{{asset('assets/image/banner.jpg')}}" width="650" alt="">
    </div>

  @yield('content')
  </div>

  @include('includes.script')
</body>
</html>
