<?php
require_once "../src/Config/Conexion.php";
class mUsuario extends Conexion{
    public function __construct(){
        parent::__construct();
    }

    public function obtenerUsuario(){

    }

    public function añadirUsuario($nombre, $apellido, $password, $correo, $telefono, $deportes) {
        try {
            $sql = "INSERT INTO usuarios(nombreUsuario, apeNombre, password, correo, telefono, perfil) VALUES (?, ?, ?, ?, ?, ?)";
            $tipo = "u";
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssssss", $nombre, $apellido, $passwordHash, $correo, $telefono, $tipo);

            if (!$stmt->execute()) {
                throw new Exception("Fallo al introducir Usuario");
            }

            $idUsuario = $this->conexion->insert_id; 

            $sqlDeportes = "INSERT INTO usuarios_deportes (idDeporte, idUsuario) VALUES (?, ?)";
            $stmtDep = $this->conexion->prepare($sqlDeportes);

            $idDeporte = 0; 
            $stmtDep->bind_param("ii", $idDeporte, $idUsuario);

            foreach ($deportes as $deporte) {
                $idDeporte = $deporte; 
                if (!$stmtDep->execute()) { 
                    throw new Exception("Fallo al introducir deporte");
                }
            }

            return true;

        } catch (Exception $e) {
            return false;
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

    public function comprobarUsuario($nombre, $password){
        try{
            $sql = "SELECT * FROM usuarios WHERE nombreUsuario= ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s",$nombre);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if($fila = $resultado->fetch_assoc()){
                if(password_verify($password, $fila['password'])){
                    return $fila;
                }
            }

            throw new Exception("Usuario no encontrado");

        }catch(Exception $e){
            return false;
        }
    }

    public function listarUsuarios(){
        try{
            $sql = "SELECT usuarios.nombreUsuario,deportes.nombreDep 
                FROM usuarios_deportes 
                INNER JOIN usuarios ON usuarios_deportes.idUsuario = usuarios.idUsuario 
                INNER JOIN deportes ON usuarios_deportes.idDeporte = deportes.idDeporte 
                ORDER BY usuarios.nombreUsuario;";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }catch(Exception $e){
            return [];
        }
    }

    public function listarDeportes(){
        $sql = "SELECT deportes.nombreDep, COUNT(usuarios_deportes.idUsuario) AS numeroUsuarios
            FROM usuarios_deportes 
            INNER JOIN deportes ON usuarios_deportes.idDeporte = deportes.idDeporte
            GROUP BY deportes.idDeporte";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function totalAlumnosInscritos(){
        $sql = "SELECT COUNT(usuarios_deportes.idUsuario) AS numeroUsuarios FROM usuarios_deportes;";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

}

?>