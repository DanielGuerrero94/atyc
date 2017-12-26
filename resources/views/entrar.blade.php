<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CUS-SUMAR-Capacitacion</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" ></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/plugins/iCheck/square/blue.css")}}">
  <!-- ADMIN-LTE -->
  <link rel="stylesheet" type="text/css" href="{{asset("/bower_components/admin-lte/dist/css/skins/_all-skins.min.css")}}">

  <link rel="stylesheet" type="text/css" href="{{url("/css/atyc.css")}}">
</head>
<body class="hold-transition login-page">
  <div class="login-box panel panel-primary">
    <div class="login-logo">
      <p><b>Atyc</b></p>
    </div>
    <hr>
    <div class="login-box-body">
      <p class="login-box-msg"><b>Iniciar sesión</b></p>
      <form action="{{ url('/login') }}" role="form" method="post">
        {{ csrf_field() }}        
        <div class="form-group has-feedback">
          <input id="name" type="text" name="name" class="form-control" placeholder="Nombre" required autofocus>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @if ($errors->has('name'))
          <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
          <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
	<hr>
        <div class="row">
          <div class="col-xs-4 col-xs-offset-4">
            <button type="submit" class="btn btn-primary btn-block ">Entrar</button>
          </div>
        </div>
      </form>
      <!-- jQuery 2.2.3 -->
      <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
      <!-- Bootstrap 3.3.6 -->
      <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" ></script>
      <!-- iCheck -->
      <script type="text/javascript" src="{{ asset ("/bower_components/admin-lte/plugins/iCheck/icheck.min.js") }}" ></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
