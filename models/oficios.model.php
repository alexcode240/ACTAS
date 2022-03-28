<?php 
require_once "connection.php";

class ModelOficios{
    /*=============================================
	CREAR OFICIO
	=============================================*/

    static public function mdlCrearOficio($tabla, $datos)
    {
        $stmt = Connection::connect()->prepare("INSERT INTO $tabla(FCOFICIO, FCFECHANOTIFICACION, FDFECHANOTIFICACION, FCFECHA, FDFECHA) VALUES (:FCOFICIO, :FCFECHANOTIFICACION, :FDFECHANOTIFICACION, :FCFECHA, :FDFECHA)");

        $stmt->bindParam(":FCOFICIO", $datos["FCOFICIO"], PDO::PARAM_STR);
        $stmt->bindParam(":FCFECHANOTIFICACION", $datos["FCFECHANOTIFICACION"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHANOTIFICACION", $datos["FDFECHANOTIFICACION"], PDO::PARAM_STR);
        $stmt->bindParam(":FCFECHA", $datos["FCFECHA"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHA", $datos["FDFECHA"], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }
}