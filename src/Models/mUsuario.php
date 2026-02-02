<?php
require_once "Config/Conexion.php";
class mUsuario extends Conexion{
    public function __construct(){
        parent::__construct();
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
            $sql = "SELECT usuarios.nombreUsuario,deportes.nombreDep, usuarios.idUsuario 
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

    public function totalAlumnosInscritos(){
        $sql = "SELECT COUNT(usuarios_deportes.idUsuario) AS numeroUsuarios FROM usuarios_deportes;";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

    public function borrarUsuario($idUsuario){
        try{
            $sql = "DELETE FROM usuarios WHERE idUsuario = ?";
            $sql2 = "DELETE FROM usuarios_deportes WHERE idUsuario = ?";    
            $stmt = $this->conexion->prepare($sql);
            $stmt2 = $this->conexion->prepare($sql2);
            $stmt->bind_param("i",$idUsuario);
            $stmt2->bind_param("i",$idUsuario);
            if($stmt->execute() && $stmt2->execute()){
                return true;
            }else{
                throw new Exception("Error al eliminar el usuario");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function modificarUsuario($idUsuario,$nombreUsuario,$apellidoNombre,$email,$telefono,$deportes){
        try{
            $sql = "UPDATE usuarios SET nombreUsuario = ?, apeNombre = ?, correo = ?, telefono = ? WHERE idUsuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssssi",$nombreUsuario,$apellidoNombre,$email,$telefono,$idUsuario);
            
            // Eliminar deportes existentes
            $sqlDelete = "DELETE FROM usuarios_deportes WHERE idUsuario = ?";
            $stmtDelete = $this->conexion->prepare($sqlDelete);
            $stmtDelete->bind_param("i", $idUsuario);
            
            if(!$stmtDelete->execute()){
                 throw new Exception("Error al eliminar deportes antiguos");
            }

            // Insertar nuevos deportes
            $sqlInsert = "INSERT INTO usuarios_deportes (idDeporte, idUsuario) VALUES (?, ?)";
            $stmtInsert = $this->conexion->prepare($sqlInsert);
            $stmtInsert->bind_param("ii", $idDeporte, $idUsuario);

            foreach($deportes as $deporte){
                $idDeporte = $deporte;
                if(!$stmtInsert->execute()){
                    throw new Exception("Error al insertar nuevos deportes");
                }
            }
            
            if($stmt->execute()){ 
                return true;
            }else{
                throw new Exception("Error al modificar el usuario");
            }
        }catch(Exception $e){
            return $e->getMessage();
        }   
    }

    public function obtenerUsuario($idUsuario){
        try{
            $sql = "SELECT * FROM usuarios WHERE idUsuario = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i",$idUsuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }catch(Exception $e){
            return [];
        }
    }

}

?>