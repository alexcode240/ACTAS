<?php

class Connection
{

    static public function connect()
    {

        $link = new PDO(
            "mysql:host=localhost;dbname=bdactascir",
            "root",
            "",
            array(
                PDO::ATTR_PERSISTENT => true
            )
        );

        $link->exec("set names utf8");

        return $link;
    }
}
