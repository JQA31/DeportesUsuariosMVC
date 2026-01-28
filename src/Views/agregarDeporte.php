<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Deporte</title>
</head>
<body>
    <form action="index.php?controller=Deporte&action=guardarDeporte" method="POST" enctype="multipart/form-data">
        <label for="nombreDep">Nombre del Deporte:</label>
        <input type="text" name="nombreDep" id="nombreDep" required maxlength="15">
        </br></br>
        <label for="imagen">Imagen del Deporte:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>
        </br></br>
        <input type="submit" value="Guardar Deporte">
    </form>
</body>
</html>