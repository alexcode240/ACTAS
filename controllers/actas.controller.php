<?php
class ActasController
{


    /*=============================================
	MOSTRAR Areas
	=============================================*/

    static public function ctrShowActas($item, $valor)
    {
        $valor = intval($valor);
        
        $respuesta = ModelActas::mdlShowActas($item, $valor);

        return $respuesta;
    }
}
