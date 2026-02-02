<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Deporte</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Modificar Deporte</h1>
    <form action="index.php?controller=Deporte&action=modificarDeporte&id=<?php echo $controlador->mensaje['deporte'][0]['idDeporte'] ?>" method="POST" enctype="multipart/form-data">
        <label for="nombreDep">Nombre del Deporte:</label>
        <input type="text" name="nombreDep" id="nombreDep" required maxlength="15" value=<?php echo "'".$controlador->mensaje['deporte'][0]['nombreDep']."'"; ?>>
        </br></br>
        <label for="imagen">Imagen del Deporte:</label>
        <img width=100 src="../img/<?php echo $controlador->mensaje['deporte'][0]['imagen'] ?>" alt="hola">
        <input type="file" name="imagen" id="imagen" accept="image/*" required>
        </br></br>
        <input type="submit" value="Guardar Deporte">
    </form>

    <a href="index.php?controller=Deporte&action=listarDeportes">Volver</a>
</body>
</html>