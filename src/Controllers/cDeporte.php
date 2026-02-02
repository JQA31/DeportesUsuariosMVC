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

    public function formularioModificarDeporteV(){
        $idDeporte = $_GET['id'];
        $this->vista = "modificarDeporte.php";
        $deporte = $this->modelo->tomarDeporte($idDeporte);
        $this->mensaje['deporte'] = $deporte;
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

    public function borrarDeporte(){
        $idDeporte = $_GET["id"];
        if(isset($idDeporte)){
            if($this->modelo->borrarDeporte($idDeporte)===true){
                $this->mensaje["mensaje"] = "Deporte borrado correctamente";
            }else{
                $this->mensaje["mensaje"] = "Fallo al borrar el deporte";
            }
            
        }else{
            $this->mensaje["mensaje"] = "Fallo al intentar borrar el deporte";
        }
        $this->vista = "pantallaInicio.php";
    }

    public function modificarDeporte(){
        $idDeporte = $_GET['id'];
        $nombreDeporte = $_POST['nombreDep'];
        $imagen = $_FILES['imagen'];
        if(isset($idDeporte) && isset($nombreDeporte) && isset($imagen)){
            $directorioDestino = "../img/"; 
            $nombreArchivo = time() . "_" . $imagen['name'];
            $rutaCompleta = $directorioDestino . $nombreArchivo;
            if (move_uploaded_file($imagen['tmp_name'], $rutaCompleta)) {
                if($this->modelo->modificarDeporte($idDeporte,$nombreDeporte,$nombreArchivo)===true){
                    $this->mensaje["mensaje"] = "Deporte modificado correctamente";
                }else{
                    $this->mensaje["mensaje"] = "Fallo al modificar el deporte";    
                }
            }else{
                $this->mensaje["mensaje"] = "Error al subir la imagen al servidor. Revisa permisos de carpeta img/.";
            }
            
        }else{
            $this->mensaje["mensaje"] = "Fallo al intentar modificar el deporte";
        }
        $this->vista = "pantallaInicio.php";
    }
    
    public function obtenerDeportes(){  
        $deportes = $this->modelo->obtenerDeportes();
        $this->mensaje["deportesUs"] = $deportes;
        $this->vista = "pantallaInicio.php";
    }
}
?>