<?php
require_once "Config/Conexion.php";

class mDeporte extends Conexion {
    public function __construct() {
        parent::__construct();
    }

    public function insertarDeporte($nombre, $nombreImagen) {
        try {
            $sql = "INSERT INTO deportes (nombreDep, imagen) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ss", $nombre, $nombreImagen);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function listarDeportes(){
        $sql = "SELECT deportes.idDeporte, deportes.nombreDep, deportes.imagen, COUNT(usuarios_deportes.idUsuario) AS numeroUsuarios
            FROM deportes
            LEFT JOIN usuarios_deportes ON usuarios_deportes.idDeporte = deportes.idDeporte
            GROUP BY deportes.idDeporte, deportes.nombreDep, deportes.imagen";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function borrarDeporte($idDeporte){
        try{
            $sql = "DELETE FROM deportes WHERE idDeporte = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i",$idDeporte);
            if($stmt->execute()){
                return true;
            }else{
                throw new Exception("Error al eliminar el deporte");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function modificarDeporte($idDeporte,$nombreDeporte,$nombreImagen){
        try{
            $sql = "UPDATE deportes SET nombreDep = ?, imagen = ? WHERE idDeporte = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssi",$nombreDeporte,$nombreImagen, $idDeporte);
            if($stmt->execute()){
                return true;
            }else{
                throw new Exception("Error al modificar el deporte");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function tomarDeporte($idDeporte){
        try{
            $sql = "SELECT * FROM deportes WHERE idDeporte = ?;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i",$idDeporte);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function obtenerDeportes(){
        try {
            $sql = "SELECT * FROM deportes";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();

            $deportes = [];
            while ($fila = $resultado->fetch_assoc()) {
                $deportes[] = $fila;
            }

            return $deportes; 
            
        } catch (Exception $e) {
            return []; 
        }
    }
}
?>