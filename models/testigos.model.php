<?php

require_once "connection.php";

class ModelTestigos
{

    /*=============================================
	MOSTRAR USUARIOS
	=============================================*/

    static public function mdlShowTestigos($tabla1, $tabla2, $item, $valor)
    {

        if ($item != null) {

            $stmt = Connection::connect()->prepare("SELECT $tabla2.FCNOMBRE, $tabla2.FCEMPLEADO FROM $tabla1 INNER JOIN $tabla2 ON($tabla1.FIEMPLEADOID = $tabla2.FIEMPLEADOID) WHERE $item = :$item");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt->close();

            $stmt = null;
        } else {

            $stmt = Connection::connect()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt->close();

            $stmt = null;
        }
    }
}
