<?php

class AreasController
{


    /*=============================================
	MOSTRAR Areas
	=============================================*/

    static public function ctrShowAreas($item, $valor)
    {

        $tabla = "tbareas";

        $respuesta = ModelAreas::mdlShowAreas($tabla, $item, $valor);

        return $respuesta;
    }
}
