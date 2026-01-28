<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Formulario de Inscripción</h1>
    <?php
        if(isset($controlador->mensaje['mensaje'])){
            echo "<h3>".$controlador->mensaje['mensaje']."</h3>";
        }
    ?>
    <form action="index.php?controller=Usuario&action=registrarUsuario" method="POST">
        <label for="nombreUsuario">Nombre de Usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario">
        </br></br>
        <label for="apellidoNombre">Apellidos y Nombres:</label>
        <input type="text" name="apellidoNombre" id="apellidoNombre">
        </br></br>
        <label for="password">Contraseña:</label>
        <input type="text" name="password" id="password">
        </br></br>
        <label for="email">Correo:</label>
        <input type="text" name="email" id="email">
        </br></br>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono">
        </br></br>
        <label for="deporte">Deportes:</label>
        </br>
        <?php
            foreach($controlador->mensaje['deportes'] as $deporte){
                echo "<input type='checkbox' name='deportes[]' value='".$deporte["idDeporte"]."'>".$deporte["nombreDep"]."</br>";
            }
        ?>
        </br>
        <label for="condiciones">Acepto los terminos y condiciones</label>
        <input type="checkbox" name="condiciones" id="condiciones">
        </br></br>
        <input type="submit" Value="Inscribirse">
    </form>
</body>
</html>