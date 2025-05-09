<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Aquí deberías agregar la lógica para guardar el usuario en tu base de datos
    // Por ahora, solo almacenaremos el nombre en la sesión
    $_SESSION['nombre_usuario'] = $nombre;
    
    // Redirigir a la página de bienvenida
    header("Location: bienvenida.php");
    exit();
}
?>