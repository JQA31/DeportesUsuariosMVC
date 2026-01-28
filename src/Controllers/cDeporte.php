<?php
require_once "Models/mDeporte.php";

class cDeporte {
    private $modelo;
    public $vista;
    public $mensaje = [];

    public function __construct() {
        $this->modelo = new mDeporte();
    }

    public function formularioDeporteV() {
        $this->vista = "agregarDeporte.php";
    }

    public function guardarDeporte() {
        $nombre = $_POST['nombreDep'];
        $archivo = $_FILES['imagen'];

        $directorioDestino = "../img/"; 
        $nombreArchivo = time() . "_" . $archivo['name'];
        $rutaCompleta = $directorioDestino . $nombreArchivo;

        if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
            if ($this->modelo->insertarDeporte($nombre, $nombreArchivo)) {
                $this->mensaje['mensaje'] = "Deporte e imagen guardados con éxito";
            } else {
                $this->mensaje['mensaje'] = "Error al guardar en la base de datos";
            }
        } else {
            $this->mensaje['mensaje'] = "Error al subir la imagen al servidor. Revisa permisos de carpeta img/.";
        }

        $this->vista = "pantallaInicio.php"; 
    }

    public function listarDeportes(){
            $deportes = $this->modelo->listarDeportes();
            $this->mensaje["deportesUs"] = $deportes;
            $this->vista = "pantallaInicio.php";
    }
}
?>