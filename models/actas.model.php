<?php
require_once "connection.php";
class ModelActas
{

    /*=============================================
	CREAR LEVANTAMIENTO
	=============================================*/

    static public function mdlCrearActa($tabla, $datos)
    {
        $connect = Connection::connect();

        $stmt = $connect->prepare("INSERT INTO $tabla(FCFOLIO, FIAREAID, FIOFICIOID, FCFECHAFIN, FDFECHAFIN, FCFECHA, FDFECHA) VALUES (:FCFOLIO, :FIAREAID, :FIOFICIOID, :FCFECHAFIN, :FDFECHAFIN, :FCFECHA, :FDFECHA)");

        $stmt->bindParam(":FCFOLIO", $datos["FCFOLIO"], PDO::PARAM_STR);
        $stmt->bindParam(":FIAREAID", $datos["FIAREAID"], PDO::PARAM_INT);
        $stmt->bindParam(":FIOFICIOID", $datos["FIOFICIOID"], PDO::PARAM_INT);
        $stmt->bindParam(":FCFECHAFIN", $datos["FCFECHAFIN"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHAFIN", $datos["FDFECHAFIN"], PDO::PARAM_STR);
        $stmt->bindParam(":FCFECHA", $datos["FCFECHA"], PDO::PARAM_STR);
        $stmt->bindParam(":FDFECHA", $datos["FDFECHA"], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return $connect->lastInsertId();
        } else {

            return  "error";
        }

        $stmt->close();
        $stmt = null;
        $connect->close();
        $connect = null;
    }

    /*=============================================
    MOSTRAR ACTAS
    =============================================*/

    static public function mdlShowActas($item, $valor)
    {

        if ($item != null) {

            $stmt = Connection::connect()->prepare("SELECT tbactas.FCFOLIO, 
                                                    tbactas.FCFECHAFIN AS FCFECHAFINACTA,
                                                    tbactas.FDFECHAFIN AS FDFECHAFINACTA,
                                                    tbactas.FCFECHA AS FCFECHAACTA, 
                                                    tbactas.FDFECHA AS FDFECHAACTA, 
                                                    AREAS.FCAREA, 
                                                    AREAS.FCDIRECCION, 
                                                    AREAS.FINUMAREA,
                                                    OFICIOS.FCOFICIO,
                                                    OFICIOS.FCFECHANOTIFICACION,
                                                    OFICIOS.FDFECHANOTIFICACION,
                                                    OFICIOS.FCFECHA AS FCFECHAOFICIO,
                                                    OFICIOS.FDFECHA AS FDFECHAOFICIO, 
                                                    LEVANTAMIENTOS.FCFECHAFIN AS FCFECHAFINLEVANTAMIENTO, 
                                                    LEVANTAMIENTOS.FDFECHAFIN AS FDFECHAFINLEVANTAMIENTO, 
                                                    LEVANTAMIENTOS.FCFECHA AS FCFECHALEVANTAMIENTO, 
                                                    LEVANTAMIENTOS.FDFECHA AS FDFECHALEVANTAMIENTO,
                                                    BIENES.FIBMPACTIVOFIJO,
                                                    BIENES.FIBMPBAJOCOSTO,
                                                    BIENES.FIBMFACTIVOFIJO,
                                                    BIENES.FIBMFBAJOCOSTO,
                                                    IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 1 GROUP BY FIAREAID),' ') AS FCCONTRALOR,
                                                    IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 2 GROUP BY FIAREAID),' ') AS FCPATRIMONIO,
                                                    IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 3 GROUP BY FIAREAID),' ') AS FCJEFEPATRIMONIO,
                                                    IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 4 GROUP BY FIAREAID),' ') AS FCSSINDICATURA,
                                                    IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 5 GROUP BY FIAREAID),' ') AS FCENLACE,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 1 GROUP BY FIAREAID),' ') AS FCNUMCONTRALOR,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 2 GROUP BY FIAREAID),' ') AS FCNUMPATRIMONIO,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 3 GROUP BY FIAREAID),' ') AS FCNUMJEFEPATRIMONIO,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 4 GROUP BY FIAREAID),' ') AS FCNUMSSINDICATURA,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 5 GROUP BY FIAREAID),' ') AS FCNUMENLACE

                                                    FROM tbactas 
                                                    INNER JOIN tbbienes AS BIENES ON (tbactas.FIACTAID = BIENES.FIACTAID) 
                                                    INNER JOIN tbareas AS AREAS ON (tbactas.FIAREAID = AREAS.FIAREAID) 
                                                    INNER JOIN tboficios AS OFICIOS ON (tbactas.FIOFICIOID = OFICIOS.FIOFICIOID)
                                                    INNER JOIN tblevantamientos AS LEVANTAMIENTOS ON (OFICIOS.FIOFICIOID = LEVANTAMIENTOS.FIOFICIOID) 
                                                    INNER JOIN tbempleados AS EMPLEADOS ON (AREAS.FIAREAID = EMPLEADOS.FIAREAID)
                                                    WHERE tbactas.FIACTAID = :$item GROUP BY tbactas.FIACTAID");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Connection::connect()->prepare("SELECT tbactas.FCFOLIO, 
        tbactas.FCFECHA AS FCFECHAACTA, 
        tbactas.FDFECHA AS FDFECHAACTA, 
        AREAS.FCAREA, 
        AREAS.FCDIRECCION, 
        AREAS.FINUMAREA,
        OFICIOS.FCOFICIO,
        OFICIOS.FCFECHANOTIFICACION,
        OFICIOS.FDFECHANOTIFICACION,
        OFICIOS.FCFECHA AS FCFECHAOFICIO,
        OFICIOS.FDFECHA AS FDFECHAOFICIO, 
        LEVANTAMIENTOS.FCFECHAFIN AS FCFECHAFINLEVANTAMIENTO, 
        LEVANTAMIENTOS.FDFECHAFIN AS FDFECHAFINLEVANTAMIENTO, 
        LEVANTAMIENTOS.FCFECHA AS FCFECHALEVANTAMIENTO, 
        LEVANTAMIENTOS.FDFECHA AS FDFECHALEVANTAMIENTO,
        BIENES.FIBMPACTIVOFIJO,
        BIENES.FIBMPBAJOCOSTO,
        BIENES.FIBMFACTIVOFIJO,
        BIENES.FIBMFBAJOCOSTO,
        IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 1 GROUP BY FIAREAID),' ') AS FCCONTRALOR,
        IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 2 GROUP BY FIAREAID),' ') AS FCPATRIMONIO,
        IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 3 GROUP BY FIAREAID),' ') AS FCJEFEPATRIMONIO,
        IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 4 GROUP BY FIAREAID),' ') AS FCSSINDICATURA,
        IFNULL((SELECT FCNOMBRE FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 5 GROUP BY FIAREAID),' ') AS FCENLACE,
         IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 1 GROUP BY FIAREAID),' ') AS FCNUMCONTRALOR,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 2 GROUP BY FIAREAID),' ') AS FCNUMPATRIMONIO,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 3 GROUP BY FIAREAID),' ') AS FCNUMJEFEPATRIMONIO,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 4 GROUP BY FIAREAID),' ') AS FCNUMSSINDICATURA,
                                                    IFNULL((SELECT FCEMPLEADO FROM tbempleados WHERE tbempleados.FIAREAID = AREAS.FIAREAID AND tbempleados.FICARGOID = 5 GROUP BY FIAREAID),' ') AS FCNUMENLACE

        FROM tbactas 
        INNER JOIN tbbienes AS BIENES ON (tbactas.FIACTAID = BIENES.FIACTAID) 
        INNER JOIN tbareas AS AREAS ON (tbactas.FIAREAID = AREAS.FIAREAID) 
        INNER JOIN tboficios AS OFICIOS ON (tbactas.FIOFICIOID = OFICIOS.FIOFICIOID)
        INNER JOIN tblevantamientos AS LEVANTAMIENTOS ON (OFICIOS.FIOFICIOID = LEVANTAMIENTOS.FIOFICIOID) 
        INNER JOIN tbempleados AS EMPLEADOS ON (AREAS.FIAREAID = EMPLEADOS.FIAREAID) GROUP BY tbactas.FIACTAID");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt->close();
        $stmt = null;
    }
}
