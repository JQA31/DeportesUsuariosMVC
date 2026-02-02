<?php
    require_once "Models/mUsuario.php";
    Class cUsuario{
        private $modelo;
        public $vista;
        public $mensaje = [];

        public function __construct(){
            $this->modelo = new mUsuario();
        }

        public function default(){
            $this->vista = "inicio.php";
        }

        public function iniciarSesionV(){
            //Este metodo solo redirige a la vista de iniciar sesión
            $this->vista = "inicioSesion.php";
        }

        public function registrarUsuarioV(){
            $this->mensaje['deportes'] = $this->modelo->obtenerDeportes();
            $this->vista = "registro.php";
        }
 
        public function iniciarSesion(){
            if(!$this->validarDatos($_POST["nombreUsuario"],$_POST["password"])){
                $this->mensaje["mensaje"] = "No se rellenaron bien los datos";
                $this->vista = "inicioSesion.php";
            }else{
                $usuario = $this->modelo->comprobarUsuario($_POST["nombreUsuario"],$_POST["password"]);
                if($usuario){
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['usuario'] = $usuario;
                    $this->vista = "pantallaInicio.php";
                }else{
                    $this->mensaje["mensaje"] = "Usuario o contraseña incorrectos";
                    $this->vista = "inicioSesion.php";
                }
            }
            return;
        }

        public function validarDatos($nombre,$password){
            $nombre = trim($nombre);
            $password = trim($password);

            if(empty($nombre) || empty($password)){
                return false;
            }
            return true;
        }

        public function registrarUsuario(){
            $nombreUsuario = $_POST["nombreUsuario"];
            $apellidoNombre = $_POST["apellidoNombre"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $telefono = $_POST["telefono"];
            $deportes = $_POST["deportes"] ?? [];
            $condiciones = $_POST["condiciones"] ?? false;
            if(!$condiciones){
                $this->registrarUsuarioV();
                $this->mensaje["mensaje"] = "Debe aceptar las condiciones";
                return;
            }
            if(empty($nombreUsuario) || empty($apellidoNombre) || empty($email) || empty($telefono) || empty($password)){
                $this->registrarUsuarioV();
                $this->mensaje["mensaje"] = "Error en la introducción de datos";
                
            }else{
                if($this->modelo->añadirUsuario($nombreUsuario,$apellidoNombre,$password,$email,$telefono,$deportes)==true){
                    $this->mensaje["mensaje"] = "Datos correctos";
                    $this->vista = "inicioSesion.php";
                }else{
                    $this->mensaje["mensaje"] = "Error en la inserción de datos";
                    $this->registrarUsuarioV();
                }
            }
        }

        public function listarUsuarios(){
            $usuarios = $this->modelo->listarUsuarios();
            $this->mensaje["usuariosDep"] = $usuarios;
            $this->vista = "pantallaInicio.php";
        }

        public function totalAlumnosInscritos(){
            $alumnos = $this->modelo->totalAlumnosInscritos();
            $this->mensaje['alumnos'] = $alumnos;
            $this->vista = "pantallaInicio.php";
        }

        public function cerrarSesion(){
            session_start();
            session_destroy();
            header("Location: index.php?controller=Usuario&action=default");
        }

        public function borrarUsuario(){
            $idUsuario = $_GET["id"];
            if(isset($idUsuario)){
                $resultado = $this->modelo->borrarUsuario($idUsuario);
                if($resultado === true){
                    $this->mensaje["mensaje"] = "Usuario eliminado correctamente";
                }else{
                    $this->mensaje["mensaje"] = $resultado;
                }
            }else{  
                $this->mensaje["mensaje"] = "Fallo al intentar borrar el usuario";
            }
            $this->listarUsuarios();
        }

        public function modificarUsuarioV(){
            $idUsuario = $_GET["id"];
            if(isset($idUsuario)){
                $usuario = $this->modelo->obtenerUsuario($idUsuario);
                $deportes = $this->modelo->obtenerDeportes();
                $this->mensaje["usuario"] = $usuario;
                $this->mensaje["deportes"] = $deportes;
                $this->vista = "modificarUsuario.php";
            }else{
                $this->mensaje["mensaje"] = "Fallo al intentar modificar el usuario";
                $this->listarUsuarios();
            }
        }

        public function modificarUsuario(){
            $idUsuario = $_POST["idUsuario"];
            $nombreUsuario = $_POST["nombreUsuario"];
            $apellidoNombre = $_POST["apellidoNombre"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];
            $deportes = $_POST["deportes"] ?? [];
            $condiciones = $_POST["condiciones"] ?? false;  
            if(!$condiciones){
                $this->modificarUsuarioV();
                $this->mensaje["mensaje"] = "Debe aceptar las condiciones";
                return;
            }
            if(empty($nombreUsuario) || empty($apellidoNombre) || empty($email) || empty($telefono)){
                $this->modificarUsuarioV();
                $this->mensaje["mensaje"] = "Error en la introducción de datos";
                
            }else{
                if($this->modelo->modificarUsuario($idUsuario,$nombreUsuario,$apellidoNombre,$email,$telefono,$deportes)==true){
                    $this->mensaje["mensaje"] = "Datos correctos";
                    $this->listarUsuarios();
                }else{
                    $this->mensaje["mensaje"] = "Error en la inserción de datos";
                    $this->modificarUsuarioV();
                }
            }
        }

        public function tomarUsuario(){
            $idUsuario = $_GET["id"];
            if(isset($idUsuario)){  
                $usuario = $this->modelo->obtenerUsuario($idUsuario);
                $this->mensaje["usuario"] = $usuario;
                $this->vista = "modificarUsuario.php";
            }else{
                $this->mensaje["mensaje"] = "Fallo al intentar modificar el usuario";
                $this->listarUsuarios();
            }
        }

    }
?>