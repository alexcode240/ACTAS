<?php

class UsersController
{

    /*=============================================
	INGRESO DE USUARIO
	=============================================*/

    static public function ctrLogin()
    {

        if (isset($_POST["ingUsuario"])) {


            if (
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingUsuario"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {

                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');


              
                $tabla = "tbempleados";

                $item = "FCNOMBRE";
                $valor = $_POST["ingUsuario"];

                $respuesta = ModelUsers::mdlShowUsers($tabla, $item, $valor);

                $respuesta['FCNOMBRE'] ??= '';
                $respuesta['FCPASSWORD'] ??= '';

                if ($respuesta["FCNOMBRE"] == $_POST["ingUsuario"] && $respuesta["FCPASSWORD"] == $encriptar) {
                    
                    $_SESSION["iniciarSesion"] = "ok";

                    echo '<script>

								window.location = "inicio";

							</script>';

                } else {

                    echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
                }
            } else {

                echo '<br><div class="alert alert-danger">Error al ingresar, vuelve a intentarlo</div>';
            }
        }
    }


}
