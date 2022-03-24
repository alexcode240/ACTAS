<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    /*=============================================
    MANTENER LA RUTA FIJA DEL SERVIDOR
    =============================================*/
    $server = Route::ctrRouteServer();

    /*=============================================
    MOSTRAR REQUEST
    =============================================*/

    $request = Route::ctrRequest();
    /*=============================================
    MANTENER LA RUTA FIJA DEL PROYECTO
    =============================================*/

    $url = Route::ctrRoute();
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actas System</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="views/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="views/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="views/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="views/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="views/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="views/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="views/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="views/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="views/dist/css/adminlte.min.css">
</head>

<!--<body class="hold-transition sidebar-mini">-->

<body class="hold-transition login-page sidebar-mini">
    <?php
    if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {



        echo '<div class="wrapper">';


        include "modules/header.php";
        include "modules/menu.php";

        /*=============================================
        CONTENIDO
        =============================================*/

        if (isset($_GET["ruta"])) {

            if (
                $_GET["ruta"] == "inicio" ||
                $_GET["ruta"] == "acta-form" ||
                $_GET["ruta"] == "logout"
            ) {

                include "modules/" . $_GET["ruta"] . ".php";
            } else {

                include "modules/404.php";
            }
        } else {

            include "modules/inicio.php";
        }

        include "modules/footer.php";

        echo '</div>';
    } else {

        include "modules/login.php";
    }

    ?>

    <!-- jQuery -->
    <script src="views/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="views/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="views/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="views/plugins/moment/moment.min.js"></script>

    <script src="views/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="views/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="views/dist/js/demo.js"></script>

    <script src="views/acta-form/acta-form.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {


            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
           



        })
    </script>
    <?php
    if (isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok") {

        echo "<script>$(document.body).removeClass('login-page');</script>";
    }
    ?>
</body>

</html>