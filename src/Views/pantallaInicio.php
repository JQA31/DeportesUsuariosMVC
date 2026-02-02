<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
        if (!isset($_SESSION['usuario'])){
            echo "<h1>No se ha iniciado sesion</h1>";
            echo "<h2><a href='index.php?controller=Usuario&action=iniciarSesionV'>Iniciar Sesion</a></h2>";
            exit();
        }else{
            $user = $_SESSION['usuario'];
        }   
        if($user['perfil'] === "c"){
            echo "<h1>PANTALLA INICIO ADMIN</h1>";
            echo "<h2>Bienvenido, " . $user['apeNombre'] . "</h2>";
        }else{
            echo "<h1>PANTALLA INICIO USER</h1>";
            echo "<h2>Bienvenido, " . $user['apeNombre'] . "</h2>";
        }
    ?>

    <?php
        if(isset($controlador->mensaje["mensaje"])){
            echo "<h3>".$controlador->mensaje["mensaje"]."</h3>";
        }
    ?>

    <nav>
        <ul>
            <?php
                if($user['perfil']==="c"){
                    echo "<li><a href='index.php?controller=Usuario&action=listarUsuarios'>Usuarios</a></li>";
                    echo "<li><a href='index.php?controller=Usuario&action=totalAlumnosInscritos'>Total de alumnos inscritos</a></li>";
                    echo "<li><a href='index.php?controller=Deporte&action=listarDeportes'>Deportes</a></li>";
                    echo "<li><a href='index.php?controller=Deporte&action=formularioDeporteV'>Agregar Deportes</a></li>";
                }
            ?>
            <li><a href="index.php?controller=Usuario&action=cerrarSesion">Cerrar Sesion</a></li>
        </ul>
    </nav>

    

    <?php
        if(isset($controlador->mensaje['usuariosDep'])){
            $ultimoId = $controlador->mensaje['usuariosDep'][0]['idUsuario'];
            echo "<h3>" . $controlador->mensaje['usuariosDep'][0]['nombreUsuario'] . " ---- 
            <a href='index.php?controller=Usuario&action=borrarUsuario&id=".$controlador->mensaje['usuariosDep'][0]['idUsuario']."'>Eliminar</a>
            <a href='index.php?controller=Usuario&action=modificarUsuarioV&id=".$controlador->mensaje['usuariosDep'][0]['idUsuario']."'>Modificar</a></h3>";
            foreach($controlador->mensaje['usuariosDep'] as $fila){
                if($fila['idUsuario'] === $ultimoId){
                    echo "<p> - ".$fila['nombreDep']."</p>";
                }else{
                    $ultimoId = $fila['idUsuario'];
                    echo "<h3>" . $fila['nombreUsuario'] . " ---- 
                    <a href='index.php?controller=Usuario&action=borrarUsuario&id=".$fila['idUsuario']."'>Eliminar</a>
                    <a href='index.php?controller=Usuario&action=modificarUsuarioV&id=".$fila['idUsuario']."'>Modificar</a></h3>";
                    echo "<p> - ".$fila['nombreDep']."</p>";
                   
                }
            }
        }
    ?>

    <?php
        if(isset($controlador->mensaje['alumnos'])){
            echo "<h3> Numero de Alumnos en deportes: ".$controlador->mensaje['alumnos']['numeroUsuarios']." </h3>";
        }
    ?>

    <?php
        if(isset($controlador->mensaje['deportesUs'])){
            foreach($controlador->mensaje['deportesUs'] as $fila){
                echo "<h3>".$fila['nombreDep']."</h3>";
                echo "<p> Numero de Alumnos en este deporte: ".$fila['numeroUsuarios']." </p>";
                echo "<img width='100' src='../img/" . $fila['imagen'] . "'>";
                echo "<p><a href='index.php?controller=Deporte&action=borrarDeporte&id=".$fila['idDeporte']."'>Eliminar</a></p>";
                echo "<p><a href='index.php?controller=Deporte&action=formularioModificarDeporteV&id=".$fila['idDeporte']."'>Modificar</a></p>";
            }
        }
    ?>

</body>
</html>