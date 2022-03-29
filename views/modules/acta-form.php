<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Crear Acta Circunstancial</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Crear Acta Circunstancial</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">


            <div class="row">

                <!-- /.col (left) -->
                <div class="col-md-12">
                    <div class="card card-primary formulario">
                        <div class="card-header">
                            <h3 class="card-title">Formulario de Actas circunstanciales</h3>
                        </div>
                        <form id="actaCircunstancial" role="form" method="post">
                            <div class="card-body">
                                <div class="form-group col-6">
                                    <label>¿A qué área pertenece el Acta?</label>
                                    <div class="input-group" id="area">
                                        <select class="form-control selectorArea" name="area" style="width: 100%;" required>
                                            <option value="" selected>Seleccione un área</option>
                                            <?php

                                            $item = null;
                                            $valor = null;

                                            $areas = AreasController::ctrShowAreas($item, $valor);

                                            foreach ($areas as $key => $value) {
                                                $numArea = "";

                                                if(strlen($value["FINUMAREA"]) == 1){
                                                    $numArea = "0".$value["FINUMAREA"];
                                                } else {
                                                    $numArea = $value["FINUMAREA"];
                                                }

                                                echo '<option value="' . $value["FIAREAID"] . '">' . $value["FCAREA"] . '-'.$numArea.' </option>';
                                            }

                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Fecha de elaboración del Acta</label>
                                    <div class="input-group date" id="fechaElaboracion" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input fechaElaboracion" name="fechaElaboracion" data-target="#fechaElaboracion" />
                                        <div class="input-group-append" data-target="#fechaElaboracion" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Número de oficio</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control folio" id="folio" name="folio">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-bars"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Fecha de elaboración del oficio</label>
                                    <div class="input-group date" id="fechaElaboracionOficio" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input fechaElaboracionOficio" name="fechaElaboracionOficio" data-target="#fechaElaboracionOficio" />
                                        <div class="input-group-append" data-target="#fechaElaboracionOficio" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Fecha de notificación del oficio</label>
                                    <div class="input-group date" id="fechaNotificacionOficio" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input fechaNotificacionOficio" name="fechaNotificacionOficio" data-target="#fechaNotificacionOficio" />
                                        <div class="input-group-append" data-target="#fechaNotificacionOficio" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Fecha de inicio del levantamiento</label>
                                    <div class="input-group date" id="fechaInicioLevantamiento" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input fechaInicioLevantamiento" name="fechaInicioLevantamiento" data-target="#fechaInicioLevantamiento" />
                                        <div class="input-group-append" data-target="#fechaInicioLevantamiento" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Fecha fin del levantamiento</label>
                                    <div class="input-group date" id="fechaFinLevantamiento" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input fechaFinLevantamiento" name="fechaFinLevantamiento" data-target="#fechaFinLevantamiento" />
                                        <div class="input-group-append" data-target="#fechaFinLevantamiento" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label>Bienes Muebles Presentados (Activo Fijo)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control folio" id="BMPActivoFijo" name="BMPActivoFijo">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-hashtag"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Bienes Muebles Presentados (Bajo Costo)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control folio" id="BMPBajoCosto" name="BMPBajoCosto">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-hashtag"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Bienes Muebles Faltantes (Activo Fijo)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control folio" id="BMFActivoFijo" name="BMFActivoFijo">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-hashtag"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Bienes Muebles Faltantes (Bajo Costo)</label>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control folio" id="BMFBajoCosto" name="BMFBajoCosto">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-hashtag"></i></div>
                                        </div>
                                    </div>
                                </div>


                                <a id="descargarWord" href="" style="display:none">Descargar Acta</a>
                                <button type="button" id="generarActa" class="btn btn-primary float-right">Generar Acta</button>
                                <!-- Date -->
                                <!--<div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>-->
                                <!-- Date and time -->
                                <!--<div class="form-group">
                                <label>Date and time:</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" />
                                    <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>-->
                                <!-- /.form group -->


                            </div>
                            <?php

                            //$crearActa = new WordController();
                            //$crearActa->ctrGenerateWord();
                            ?>
                        </form>
                        <div class="card-footer">
                            Llene los campos para generar el acta circunstancial.
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col (right) -->
            </div>


        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->