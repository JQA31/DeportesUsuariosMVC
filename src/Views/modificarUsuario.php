<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Formulario de Modificación</h1>
    <?php
        if(isset($controlador->mensaje['mensaje'])){
            echo "<h3>".$controlador->mensaje['mensaje']."</h3>";
        }
    ?>
    <form action="index.php?controller=Usuario&action=modificarUsuario" method="POST">
        <label for="nombreUsuario">Nombre de Usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario" value=<?php echo "'".$controlador->mensaje['usuario'][0]['nombreUsuario']."'"; ?>>
        </br></br>
        <label for="apellidoNombre">Apellidos y Nombres:</label>
        <input type="text" name="apellidoNombre" id="apellidoNombre" value=<?php echo "'".$controlador->mensaje['usuario'][0]['apeNombre']."'"; ?>>
        </br></br>
        <label for="email">Correo:</label>
        <input type="text" name="email" id="email" value=<?php echo "'".$controlador->mensaje['usuario'][0]['correo']."'"; ?>>
        </br></br>
        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value=<?php echo "'".$controlador->mensaje['usuario'][0]['telefono']."'"; ?>>
        </br></br>
        <label for="deporte">Deportes:</label>
        </br>
        <?php
            foreach($controlador->mensaje['deportes'] as $deporte){
                echo "<input type='checkbox' name='deportes[]' value='".$deporte["idDeporte"]."'>".$deporte["nombreDep"]."</br>";
            }
        ?>
        </br>
        <input type="hidden" name="idUsuario" value=<?php echo "'".$controlador->mensaje['usuario'][0]['idUsuario']."'"; ?>>
        <label for="condiciones">Acepto los terminos y condiciones</label>
        <input type="checkbox" name="condiciones" id="condiciones">
        </br></br>
        <input type="submit" Value="Modificar">
    </form>
    <a href="index.php?controller=Usuario&action=listarUsuarios">Volver</a>
</body>
</html>