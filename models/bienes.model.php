<?php
require_once "connection.php";

class ModelBienes
{

    /*=============================================
	CREAR LEVANTAMIENTO
	=============================================*/

    static public function mdlCrearBienes($tabla, $datos)
    {


        $stmt = Connection::connect()->prepare("INSERT INTO $tabla(FIACTAID, FIBMPACTIVOFIJO, FIBMPBAJOCOSTO, FIBMFACTIVOFIJO, FIBMFBAJOCOSTO) VALUES (:FIACTAID, :FIBMPACTIVOFIJO, :FIBMPBAJOCOSTO, :FIBMFACTIVOFIJO, :FIBMFBAJOCOSTO)");

        $stmt->bindParam(":FIACTAID", $datos["FIACTAID"], PDO::PARAM_INT);
        $stmt->bindParam(":FIBMPACTIVOFIJO", $datos["FIBMPACTIVOFIJO"], PDO::PARAM_INT);
        $stmt->bindParam(":FIBMPBAJOCOSTO", $datos["FIBMPBAJOCOSTO"], PDO::PARAM_INT);
        $stmt->bindParam(":FIBMFACTIVOFIJO", $datos["FIBMFACTIVOFIJO"], PDO::PARAM_INT);
        $stmt->bindParam(":FIBMFBAJOCOSTO", $datos["FIBMFBAJOCOSTO"], PDO::PARAM_INT);


        if ($stmt->execute()) {

            return "ok";
        } else {

            return  "error";
        }

        $stmt->close();
        $stmt = null;
      
    }
}
