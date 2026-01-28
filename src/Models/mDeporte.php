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
        $sql = "SELECT deportes.nombreDep, deportes.imagen, COUNT(usuarios_deportes.idUsuario) AS numeroUsuarios
            FROM deportes
            LEFT JOIN usuarios_deportes ON usuarios_deportes.idDeporte = deportes.idDeporte
            GROUP BY deportes.idDeporte, deportes.nombreDep, deportes.imagen";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>