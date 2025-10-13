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
      <h2>Formulir Kuesioner Kepuasan Pengguna</h2>
      <p>Harap isi formulir berikut dengan jujur untuk membantu kami meningkatkan layanan.</p>
    </div>

  @yield('content')
  </div>

  @include('includes.script')
</body>
</html>
