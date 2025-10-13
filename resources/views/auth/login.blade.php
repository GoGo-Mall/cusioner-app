 <!DOCTYPE html>
 <html lang="id">

 <head>
     <meta charset="UTF-8">
     <title>Login</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 </head>

 <body class="bg-light d-flex align-items-center" style="height:100vh;">
     <div class="container">
         <div class="row justify-content-center">
             <div class="col-md-4">
                 <div class="card shadow">
                     <div class="card-header text-center">Login</div>
                     <div class="card-body">
                         @if (session('error'))
                             <div class="alert alert-danger">{{ session('error') }}</div>
                         @endif
                         <form method="POST" action="{{ route('login.process') }}">
                             @csrf
                             <div class="mb-3">
                                 <label>Email</label>
                                 <input type="email" name="email" class="form-control" required>
                             </div>
                             <div class="mb-3">
                                 <label>Password</label>
                                 <input type="password" name="password" class="form-control" required>
                             </div>
                             <button class="btn btn-primary w-100">Login</button>
                         </form>
                     </div>
                 </div>
                 <p class="text-center mt-3 text-muted">Gunakan:
                     <br>Admin → admin@mail.com / admin123
                     <br>User → user@mail.com / user123
                 </p>
             </div>
         </div>
     </div>
 </body>

 </html>
