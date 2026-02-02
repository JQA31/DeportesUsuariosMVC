<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if(!isset($_GET['controller'])){
        $controlador = 'Usuario';
    }else{
        $controlador = $_GET['controller'];
    }

    if(!isset($_GET['action'])){
        $accion = 'default';
    }else{
        $accion = $_GET['action'];
    }

    $controladoresPublicos=["Usuario"];

	if(!in_array($controlador, $controladoresPublicos) && !isset($_SESSION['usuario'])){
		$controlador='Usuario';
		$accion='iniciarSesionV';
	}

    $rutaControlador = "Controllers/c".$controlador.".php";

    if(!file_exists($rutaControlador)){
		$controlador='Usuario';
		$accion='iniciarSesionV';
	}

    include $rutaControlador;

    $clase = "c".$controlador;

    $controlador = new $clase();

    $datos = $controlador->$accion();
    
    require_once "Views/".$controlador->vista;
?>