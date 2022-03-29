<?php

require_once "../models/oficios.model.php";
require_once "../models/levantamientos.model.php";
require_once "../models/actas.model.php";
require_once "../models/bienes.model.php";

class AjaxCrearActa {
    public $fcOficio;
    public $fcFechaNotificacion;
    public $fdFechaNotificacion;
    public $fcFechaOficio;
    public $fdFechaOficio;
    public $fcFechaInicioLevantamiento;
    public $fdFechaInicioLevantamiento;
    public $fcFechaFinLevantamiento;
    public $fdFechaFinLevantamiento;
    public $fcFolioActa;
    public $fiAreaIdActa;
    public $fcFechaElaboracionActa;
    public $fdFechaElaboracionActa;
    public $bmpActivoFijo;
    public $bmpBajoCosto;
    public $bmfActivoFijo;
    public $bmfBajoCosto;


    public function ajaxNuevaActa(){
        $tablaOficios = "tboficios";
        $datosOficio = array(
            "FCOFICIO" => $this -> fcOficio,
            "FCFECHANOTIFICACION" => $this -> fcFechaNotificacion,
            "FDFECHANOTIFICACION" => $this -> fdFechaNotificacion,
            "FCFECHA" => $this -> fcFechaOficio,
            "FDFECHA" => $this -> fdFechaOficio
        );

        $respuestaOficio = ModelOficios::mdlCrearOficio($tablaOficios, $datosOficio);
        if ($respuestaOficio != "error") {
            $oficioId = $respuestaOficio;
            
            $tablaLevantamientos = "tblevantamientos";

            $datosLevantamiento = array(
                "FIOFICIOID" => $oficioId,
                "FCFECHAFIN" => $this -> fcFechaFinLevantamiento,
                "FDFECHAFIN" => $this -> fdFechaFinLevantamiento,
                "FCFECHA" => $this -> fcFechaInicioLevantamiento,
                "FDFECHA" => $this -> fdFechaInicioLevantamiento
            );

            $respuestaLevantamiento = ModelLevantamientos::mdlCrearLevantamiento($tablaLevantamientos, $datosLevantamiento);
            
            if ($respuestaLevantamiento == "ok") {
               
                $tablaActas = "tbactas";
                $datosActa = array(

                    "FCFOLIO" => $this -> fcFolioActa,
                    "FIAREAID" => $this -> fiAreaIdActa,
                    "FIOFICIOID" => $oficioId,
                    "FCFECHA" => $this -> fcFechaElaboracionActa,
                    "FDFECHA" => $this -> fdFechaElaboracionActa
                );

                $respuestaActa = ModelActas::mdlCrearActa($tablaActas, $datosActa);
                //echo json_encode($respuestaActa);
                if ($respuestaActa != "error") {
                    $actaId = $respuestaActa;
                    $tablaBienes = "tbbienes";
                    $datosBienes = array(
                        "FIACTAID" => $actaId,
                        "FIBMPACTIVOFIJO" => $this -> bmpActivoFijo,
                        "FIBMPBAJOCOSTO" => $this -> bmpBajoCosto,
                        "FIBMFACTIVOFIJO" => $this -> bmfActivoFijo,
                        "FIBMFBAJOCOSTO" => $this -> bmfBajoCosto
                    );

                    $respuestaBienes = ModelBienes::mdlCrearBienes($tablaBienes, $datosBienes);
                    
                    if ($respuestaBienes == "ok") {
                        echo $actaId;
                    } else {
                        echo false;
                    }

                    
                } else {
                    echo false;
                }
            }else {
                echo false;
            }

            
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
    $crearActa -> fcFechaOficio = $_POST['FCFECHAOFICIO'];
    $crearActa -> fdFechaOficio = $_POST['FDFECHAOFICIO'];
    $crearActa -> fcFechaInicioLevantamiento = $_POST['FCFECHAINICIOLEVANTAMIENTO'];
    $crearActa -> fdFechaInicioLevantamiento = $_POST['FDFECHAINICIOLEVANTAMIENTO'];
    $crearActa -> fcFechaFinLevantamiento = $_POST['FCFECHAFINLEVANTAMIENTO'];
    $crearActa -> fdFechaFinLevantamiento = $_POST['FDFECHAFINLEVANTAMIENTO'];
    $crearActa -> fcFolioActa = $_POST['FCFOLIOACTA'];
    $crearActa -> fiAreaIdActa = $_POST['FIAREAIDACTA'];
    $crearActa -> fcFechaElaboracionActa = $_POST['FCFECHAELABORACIONACTA'];
    $crearActa -> fdFechaElaboracionActa = $_POST['FDFECHAELABORACIONACTA'];
    $crearActa -> bmpActivoFijo = $_POST['FIBMPACTIVOFIJO'];
    $crearActa -> bmpBajoCosto = $_POST['FIBMPBAJOCOSTO'];
    $crearActa -> bmfActivoFijo = $_POST['FIBMFACTIVOFIJO'];
    $crearActa -> bmfBajoCosto = $_POST['FIBMFBAJOCOSTO'];
    $crearActa -> ajaxNuevaActa();
}