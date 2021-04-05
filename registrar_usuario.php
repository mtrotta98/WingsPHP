<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de administracion Wings</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="desarrollo/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="desarrollo/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="desarrollo/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img src="imagenes/logo_wings.jpg" width="50%" height="50%">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <div class="login-box-msg">
          <p style="display:none; color:#FF0000" id="muestra">* Las contraseñas no coinciden</p>
          <p style="display:none; color:#FF0000" id="muestra2">* Debe llenar todos los campos</p>
      </div>

      <form action="#" method="post" id="formulario_carga_usuario" name="formulario_carga_usuario">
        <div class="input-group mb-3">
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" id="clave" name="clave" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" id="Rclave" name="Rclave" class="form-control" placeholder="Repeat password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="button" class="btn btn-primary btn-block" id="aceptar" name="aceptar" onclick="registrar_usuario()">Accept</button>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-block btn-danger" onclick="location.href='index.php'">Cancel</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="desarrollo/plugins/jQuery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="desarrollo/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="desarrollo/dist/js/adminlte.min.js"></script>
<script>
        function registrar_usuario(){
            pass1 = document.getElementById('clave');
            pass2 = document.getElementById('Rclave');
            usuario = document.getElementById('usuario');
            mostrar = document.getElementById('muestra');
            mostrar2 = document.getElementById('muestra2');
            if((usuario.value == "") || (pass1.value == "") || (pass2.value == "")){
              mostrar2.style.display='block';
            }else if(pass1.value != pass2.value){
              mostrar.style.display='block';
            }else{
              $.ajax({
                    type: "POST",
                    url: "acciones.php?valor=17&accion=cargar",
                    data: $("#formulario_carga_usuario").serialize(),
                    dataType: "html",
                    success: function(data) {
                        alert("Datos Guardados!!!");
                        //alert(data);
                        window.location = "index.php";
                    }
                }); 
            }
        }
</script>
</body>
</html>
                