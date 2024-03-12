<?php
    if(isset($_GET['registrarse'])) {
        
    }
?>
<div class="w-full mt-10 mb-10 flex items-center justify-center">
    <div class="max-w-md w-4/5 md:w-full p-6 bg-white rounded-lg shadow-lg">
      <div class="flex justify-center mb-8">
        <img src="Imagenes/logo-delegacion.jpg" alt="Logo-Delegación" class="w-44 h-48 md:w-56 md:h-56 rounded-lg">
      </div>
      <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">Registro</h1>
      <form action="index.php?modulo=registro&accion=registrarse" method="post">
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
        <div class="mb-6">
          <label for="confirmPassword" class="block mb-2 text-sm text-gray-600">Repetir contraseña</label>
          <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
        </div>
        <button type="submit" class="w-32 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 mb-2">Registro</button>
      </form>
      <div class="text-center">
        <p class="text-sm">¿Ya tienes una cuenta? <a href="#" class="text-cyan-600">Inicia sesión</a></p>
      </div>
      <p class="text-xs text-gray-600 text-center mt-8">&copy; 2023 WCS LAT</p>
    </div>
  </div>