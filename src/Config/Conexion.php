<?php
    require_once "configdb.php";
    class Conexion{
        protected $conexion;
        public function __construct(){
            try{
                $this->conexion = new mysqli(host,user,password,bbdd);
                if(!$this->conexion){
                    throw new Exception("Fallo al conectar con el servidor");
                }
            }catch(Exception $e){
                echo "Error: ". $e->getMessage();
            }
        }

        public function cerrarConexion(){
            $this->conexion->close();
        }
    }

?>