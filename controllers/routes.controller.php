<?php

class Route
{

    /*=============================================
	RUTA LADO DEL CLIENTE
	=============================================*/

    public static function ctrRoute()
    {

        return "http://localhost/ACTASCIR/";
    }

    /*=============================================
	REQUEST ACTUAL
	=============================================*/

    public static function ctrRequest()
    {
        if (isset($_REQUEST["ruta"])) {

            return $_REQUEST["ruta"];
        } else {
            return "";
        }
    }

    /*=============================================
	RUTA LADO DEL SERVIDOR
	=============================================*/

    public static function ctrRouteServer()
    {

        return "http://localhost/ACTASCIR/";
    }
}
