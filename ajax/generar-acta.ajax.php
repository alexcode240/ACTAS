<?php

require_once "../models/oficios.model.php";

class AjaxCrearActa {
    public $fcOficio;
    public $fcFechaNotificacion;
    public $fdFechaNotificacion;
    public $fcFecha;
    public $fdFecha;

    public function ajaxNuevaActa(){
        $tabla = "tboficios";
        $datos = array(
            "FCOFICIO" => $this -> fcOficio,
            "FCFECHANOTIFICACION" => $this -> fcFechaNotificacion,
            "FDFECHANOTIFICACION" => $this -> fdFechaNotificacion,
            "FCFECHA" => $this -> fcFecha,
            "FDFECHA" => $this -> fdFecha
        );

        $respuesta = ModelOficios::mdlCrearOficio($tabla, $datos);

        if ($respuesta == "ok") {
            echo true;
        }else{
            echo false;
        }
        
    }
}

if(isset($_POST['FCOFICIO'])){
    $crearActa = new AjaxCrearActa();
    $crearActa -> fcOficio = $_POST['FCOFICIO'];
    $crearActa -> fcFechaNotificacion = $_POST['FCFECHANOTIFICACION'];
    $crearActa -> fdFechaNotificacion = $_POST['FDFECHANOTIFICACION'];
    $crearActa -> fcFecha = $_POST['FCFECHA'];
    $crearActa -> fdFecha = $_POST['FDFECHA'];
    $crearActa -> ajaxNuevaActa();
}