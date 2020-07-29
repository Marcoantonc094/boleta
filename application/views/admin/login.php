<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Sign up and login form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
  <link rel="stylesheet" href="<?php echo base_url('assets/logeo/style.css');?>">
</head>
<body>
<!-- partial:index.partial.html -->
<body>
  <div class="container">
    <div class="backbox">
      <div class="loginMsg">
        <div class="textcontent">
          <p class="title">Sistema de Control de Boletas de Garantia</p>
          <p>INF – 316 sistemas de información gerencial</p>
          <button id="switch1" class="boton" style="display: block; margin: 0 auto;">Inicio de sesion</button>
        </div>
      </div>
      <div class="signupMsg visibility">
        <div class="textcontent">
          <p class="title">DESARROLLADO POR</p>
          <p>- Marco A. Calderon Condori</p>
          <p>- Erick Aguilar Lozano</p>
          <p>- Fernández Tristán Cecilia E.</p>
          <p>- Apaza Ramirez Yhoseline Jael</p>
          <p>- Cori Tipo Luis Fernando</p>
          <button id="switch2" class="boton">Inicio</button>
        </div>
      </div>
    </div>
    <!-- backbox -->
    <div class="frontbox">
      <div class="login">
         <img src="<?php echo base_url('assets/img/logoumsa.png');?>">
      </div>
      <div class="signup hide">
        <h2>Inicio de sesion</h2>
        <div class="inputbox">
          <form action="<?php echo base_url('inicio/ingreso')?>" method="post">
                    <input type="text" id="user" name="user" class="caja" placeholder="Usuario" required>
                    <input type="password" id="pass" name="pass" class="caja" placeholder="Contraseña" required>
                    <p style="text-align: center;">
                        <input type="submit" name="submit" value="Ingresar" class="boton" style="display: block; margin: 0 auto;">
                    </p>
            </form>
        </div>
      </div>
    </div>
    <!-- frontbox -->
  </div>
</body>
</html>
<!-- partial -->
  <script  src="<?php echo base_url('assets/js/script.js');?>"></script>
</body>
</html>
