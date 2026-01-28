<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Inicio de Sesión</h1>
    <?php
        if(isset($controlador->mensaje['mensaje'])){
            echo "<h3>".$controlador->mensaje['mensaje']."</h3>";
        }
    ?>
    <form action="index.php?controller=Usuario&action=iniciarSesion" method="POST">
        <label for="nombreUsuario">Nombre de Usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario">
        </br></br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
        </br></br>
        <input type="submit" value="Iniciar Sesión">
    </form>
</body>
</html>