<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->
<html>
<head>
  <title>Login</title>
  <link href="{{ URL::asset('src/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Login</h5>
            @include('includes.info-box')
            <form action="{{ route('admin.login') }}" method="POST">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus>
              </div>
              <div class="form-group">
                <label for="inputPassword">Password</label>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password">
              </div>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
              <button class="btn  btn-primary btn-block text-uppercase" type="submit">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>