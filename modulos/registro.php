<?php
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['password'])) {
      $nombre = mysqli_real_escape_string($con, $_POST['nombre']);
      $apellido = mysqli_real_escape_string($con, $_POST['apellido']);
      $email = mysqli_real_escape_string($con, $_POST['email']);
      $password = mysqli_real_escape_string($con, $_POST['password']);
  
      // Verificar si el usuario ya existe
      $chequeoUsuario = "SELECT * FROM usuarios WHERE email = '$email'";
      $chequeoResultado = mysqli_query($con, $chequeoUsuario);
  
      if (mysqli_num_rows($chequeoResultado) != 0) {
          echo '<script> 
          Swal.fire({
              title: "¡Oops!",
              text: "Este usuario ya existe. Por favor, inicia sesión.",
              icon: "error",
              showCloseButton: true,
              confirmButtonColor: "#3085d6",
              confirmButtonText: "Iniciar Sesión",
              allowOutsideClick: false,
              willClose: () => {
                  window.location.href = "index.php?modulo=iniciar-sesion";
              }
          }); 
      </script>';
          exit();
      } else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          $rolPorDefecto = 1;
  
          $insertarUsuario = "INSERT INTO usuarios (nombre, apellido, email, clave, idRol) VALUES ('$nombre', '$apellido', '$email', '$hashed_password', $rolPorDefecto)";
          $insertarResultado = mysqli_query($con, $insertarUsuario);
  
          if ($insertarResultado) {
              echo '<script> 
                       Swal.fire({
                      title: "¡Registro Exitoso!",
                      html: "<p>Gracias por registrarse.",
                      icon: "success",
                      confirmButtonColor: "#4caf50",
                      confirmButtonText: "Aceptar",
                      allowOutsideClick: false,
                      willClose: () => {
                          window.location.href = "index.php";
                      }
                  }); 
              </script>';
          } else {
              echo "Error: No se pudo insertar el registro";
          }
      }
  }
?>
<div class="w-full mt-10 mb-10 flex items-center justify-center">
    <div class="max-w-md w-4/5 md:w-full p-6 bg-white rounded-lg shadow-lg">
      <div class="flex justify-center mb-8">
        <img src="imagenes/logo-delegacion.png" alt="Logo-Delegación" class="w-full sm:w-1/2 rounded-lg">
      </div>
      <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">Registro</h1>
      <form action="index.php?modulo=registro" method="post">
        <div class="mb-4">
          <label for="nombre" class="block mb-2 text-sm text-gray-600">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
        </div>
        <div class="mb-4">
          <label for="apellido" class="block mb-2 text-sm text-gray-600">Apellido</label>
          <input type="text" id="apellido" name="apellido" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
        </div>
        <div class="mb-4">
          <label for="email" class="block mb-2 text-sm text-gray-600">Correo electrónico</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
        </div>
        <div class="mb-4">
          <label for="password" class="block mb-2 text-sm text-gray-600">Contraseña</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
        </div>
        <button type="submit" class="w-32 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 mb-2">Registrarse</button>
      </form>
      <div class="text-center">
        <p class="text-sm">¿Ya tienes una cuenta? <a href="index.php?modulo=iniciar-sesion" class="text-cyan-600">Inicia sesión</a></p>
      </div>
      <p class="text-xs text-gray-600 text-center mt-8">&copy; 2025 Delegación 32-33</p>
    </div>
  </div>