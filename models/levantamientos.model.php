<?php
require_once "connection.php";
class ModelLevantamientos{

    /*=============================================
	CREAR LEVANTAMIENTO
	=============================================*/

    static public function mdlCrearLevantamiento($tabla, $datos)
    {

        $stmt = Connection::connect()->prepare("INSERT INTO $tabla(FIOFICIOID, FCFECHAFIN, FDFECHAFIN, FCFECHA, FDFECHA) VALUES (:FIOFICIOID, :FCFECHAFIN, :FDFECHAFIN, :FCFECHA, :FDFECHA)");

        $stmt->bindParam(":FIOFICIOID", $datos["FIOFICIOID"], PDO::PARAM_INT);
        $stmt->bindParam(":FCFECHAFIN", $datos["FCFECHAFIN"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHAFIN", $datos["FDFECHAFIN"], PDO::PARAM_STR);
        $stmt->bindParam(":FCFECHA", $datos["FCFECHA"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHA", $datos["FDFECHA"], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return "ok";
        } else {

            return  "error";
        }

        $stmt->close();
        $stmt = null;
    }
}
