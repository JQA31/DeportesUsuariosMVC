<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio</title>
</head>
<body>
    <?php
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user = $_SESSION['usuario'] ?? null;
        if($user && $user['perfil'] === "c"){
            echo "<h1>PANTALLA INICIO ADMIN</h1>";
            echo "<h2>Bienvenido, " . $user['apeNombre'] . "</h2>";
        }else{
            echo "<h1>PANTALLA INICIO USER</h1>";
            echo "<h2>Bienvenido, " . $user['apeNombre'] . "</h2>";
        }
    ?>

    <nav>
        <ul>
            <?php
                if($user['perfil']==="c"){
                    echo "<li><a href='index.php?controller=Usuario&action=listarUsuarios'>Usuarios</a></li>";
                    echo "<li><a href='index.php?controller=Usuario&action=totalAlumnosInscritos'>Total de alumnos inscritos</a></li>";
                    echo "<li><a href='index.php?controller=Usuario&action=listarDeportes'>Deportes</a></li>";
                }
            ?>
            <li><a href="index.php?controller=Usuario&action=cerrarSesion">Cerrar Sesion</a></li>
        </ul>
    </nav>

    <h3>Datos:</h3>

    <?php
        if(isset($controlador->mensaje['usuariosDep'])){
            foreach($controlador->mensaje['usuariosDep'] as $fila){
                echo "<p>".$fila['nombreUsuario']." - ".$fila['nombreDep']."</p>";
            }
        }
    ?>

    <?php
        if(isset($controlador->mensaje['alumnos'])){
            echo "<p> Numero de Alumnos en deportes: ".$controlador->mensaje['alumnos']['numeroUsuarios']." </p>";
        }
    ?>

    <?php
        if(isset($controlador->mensaje['deportesUs'])){
            foreach($controlador->mensaje['deportesUs'] as $fila){
                echo "<p>".$fila['nombreDep']." - ".$fila['numeroUsuarios']."</p>";
            }
        }
    ?>

</body>
</html>