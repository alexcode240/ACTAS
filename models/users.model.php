<?php

require_once "connection.php";

class ModelUsers
{

    /*=============================================
	MOSTRAR USUARIOS
	=============================================*/

    static public function mdlShowUsers($tabla, $item, $valor)
    {

        if ($item != null) {

            $stmt = Connection::connect()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
          
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

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
