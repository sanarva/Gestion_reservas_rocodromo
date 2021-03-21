<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Sandra Arcas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Listado usuarios</title>

    <!-- Estilos para la aplicación -->
    <!-- Estilos de Bootstrap 4-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <!-- Estilos para iconos (Font Awesome)-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Estilos propios -->
    <link rel="stylesheet" href="../styles/main.css"> 
</head>

<body>
  
  <div class="container">
      <p class= "closeSession"><i class="fas fa-sign-out-alt fa-lg"></i> Cerrar sesión</p> 
      <h1>LISTADO DE USUARIOS</h1>
      
      <p class="border-bottom">Filtros:</p>

      <form action="" >
                
        <div class="filterLayoutItems">
          <label for="userNameFilter" class="col-form-label d-block"><i class="far fa-user"></i> Nombre usuario:</label>
          <input type="text" name="userNameFilter" id="userNameFilter">
        </div>
        
        <div class="filterLayoutItems">
          <label for="cardNumberFilter" class="col-form-label d-block"><i class="far fa-address-card"></i> Nº tarjeta:</label>
          <input type="text" name="cardNumberFilter" id="cardNumberFilter">
        </div>
       
        <div class="filterLayoutItems">
          <input type="checkbox" name="checkAllUsers" id="checkAllUsers">
          <label for="checkAllUsers" class="col-form-label">Mostrar usuarios inactivos</label>
        </div>

        <div class="row mt-2">
          <div class="col-12">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
          </div>
        </div>
      </form>
      
      <table class="table  mt-5">
        <thead>
            <tr>
              <th>NOMBRE USUARIO</th>
              <th class="text-center">TIPO</th>
              <th class="text-center">Nº TARJETA</th>
              <th>EMAIL</th>
              <th class="text-center">ESTADO</th>
              <th class="text-center">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
          <tr> <!--Por cada reserva que exista en la base de datos, tendrá que aparecer un registro-->
            <td id="userNameUL"  name="userNameUL">Sandra Arcas Valero</td>
            <td id="userTypeUL"  name="userTypeUL" class="text-center">Admin</td>
            <td class="text-center" id="cardNumberUL"  name="cardNumberUL">0108</td>
            <td id="emailUL"  name="emailUL">plosky21@hotmail.com</td>
            <td id="userStatusUL"  name="userStatusUL" class="text-center"><i class="fas fa-check fa-lg text-success"></i></td>
            <td class="d-flex justify-content-center">
              <i class="fas fa-pen-square fa-lg text-info cursorHand mr-4"></i>
              <i class="fas fa-times-circle fa-lg text-danger cursorHand"></i>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div class="row">
        <div class="col-12">
          <a class="btn btn-primary" href="user.php">Crear usuario</a>
        </div>
      </div>
  </div>

  <!-- Scripts para Bootstrap 4-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>

</html>