<?php
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

    $rutaControlador = "Controllers/c".$controlador.".php";

    include $rutaControlador;

    $clase = "C".$controlador;
    $controlador = new $clase();

    $datos = $controlador->$accion();

    require_once "Views/".$controlador->vista;
?>