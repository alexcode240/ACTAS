<?php
class TestigosController
{


    /*=============================================
    MOSTRAR Testigos
    =============================================*/

    static public function ctrShowTestigos($item, $valor)
    {

        $tabla1 = "tbtestigos";
        $tabla2 = "tbempleados";


        $respuesta = ModelTestigos::mdlShowTestigos($tabla1, $tabla2, $item, $valor);
        
        return $respuesta;
    }
}