<?php 
if (isset($_GET['salir'])) {
    session_destroy();
    echo "<script>window.location='index.php';</script>";
}
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Escapar las variables del formulario para prevenir inyecciones SQL
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
    
        // Consulta preparada para buscar el usuario por su email
        $sql = "SELECT id, nombre, email, clave, idRol FROM usuarios WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($row = mysqli_fetch_assoc($result)) {
            // Verificar la contraseña almacenada con la contraseña proporcionada
            if (password_verify($password, $row['clave'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['nombre_usuario'] = $row['nombre'];
                $_SESSION['rol'] = $row['idRol'];
    
                echo '<script> 
                    Swal.fire({
                        title: "¡Bienvenido!",
                        text: "Nombre de usuario: ' . $_SESSION['nombre_usuario'] . '",
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
                echo '<script> 
                    Swal.fire({
                        title: "¡Verifique los datos!",
                        text: "Por favor, revise los datos ingresados.",
                        icon: "warning",
                        confirmButtonColor: "#ffc107",
                        confirmButtonText: "Aceptar",
                        willClose: () => {
                            window.location.href = "index.php?modulo=iniciar-sesion";
                        }
                    }); 
                </script>';
            }
        } else {
            echo '<script> 
                Swal.fire({
                    title: "¡Verifique los datos!",
                    text: "Por favor, revise los datos ingresados.",
                    icon: "warning",
                    confirmButtonColor: "#ffc107",
                    confirmButtonText: "Aceptar",
                    willClose: () => {
                        window.location.href = "index.php?modulo=iniciar-sesion";
                    }
                }); 
            </script>';
        }
    }
?>
<div class="w-full mt-10 mb-10 flex items-center justify-center">
    <div class="max-w-md w-4/5 md:w-full p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center mb-8">
            <img src="imagenes/logo-delegacion.png" alt="Logo-Delegación" class="w-full sm:w-1/2 rounded-lg">
        </div>
        <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">Acceso Delegación 32-33</h1>
        <form action="index.php?modulo=iniciar-sesion" method="post">
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm text-gray-600">Correo electrónico</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm text-gray-600">Contraseña</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" required>
            </div>
            <button type="submit" class="w-32 bg-gradient-to-r from-cyan-400 to-cyan-600 text-white py-2 rounded-lg mx-auto block focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 mb-2">Iniciar Sesión</button>
        </form>
        <div class="text-center">
            <p class="text-sm">¿No tiene una cuenta? <a href="index.php?modulo=registro" class="text-cyan-600">Registrarse</a></p>
        </div>
        <p class="text-xs text-gray-600 text-center mt-8">&copy; 2024 Delegación 32-33</p>
    </div>
</div>