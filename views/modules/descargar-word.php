<?php
require_once "../../extensions/vendor/autoload.php";
require_once "../../controllers/actas.controller.php";
require_once "../../models/actas.model.php";
require_once "../../controllers/testigos.controller.php";
require_once "../../models/testigos.model.php";
require_once "../../controllers/users.controller.php";
require_once "../../models/users.model.php";

use PhpOffice\PhpWord\Style\Paper;

class WordController
{
    public $idActa;
    public $sindicaturaId;
    public $bienesSob;

    public function ctrGenerateWord()
    {
        $acta = new ActasController();
        $item = "FIACTAID";
        $respuesta = $acta->ctrShowActas($item, $this->idActa);

        $testigos = new TestigosController();
        $item = "FIACTAID";
        $respuestaTestigos = $testigos->ctrShowTestigos($item, $this->idActa);

        $users = new UsersController();
        $item = "FIEMPLEADOID";
        $sindicatura = $users->ctrShowUsers($item, $this->sindicaturaId);

        $stringNombreTestigos = "";
        $stringNumEmpleadoTestigos = "";
        $stringTestigos = "";

        if($respuestaTestigos != null) {
            $stringTestigos .= $respuestaTestigos[0]["FCNOMBRE"] . "                                                                  ". $respuestaTestigos[1]["FCNOMBRE"];

            
            for ($i = 0; $i < count($respuestaTestigos); $i++) {
                $stringNombreTestigos .= $respuestaTestigos[$i]["FCNOMBRE"] . " y ";
                $stringNumEmpleadoTestigos .= $respuestaTestigos[$i]["FCEMPLEADO"] . " y ";
            }
        }

        $stringNombreTestigos = substr($stringNombreTestigos, 0, -3);
        $stringNumEmpleadoTestigos = substr($stringNumEmpleadoTestigos, 0, -3);

        

       
        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $phpWord->addParagraphStyle('tStyle', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('tFont', array('name'=>'Arial','bold' => true, 'size' => 15, 'color' => 'ff0000'));

        $phpWord->addParagraphStyle('ptStyle', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('ptFont', array('name' => 'Arial', 'bold' => true, 'size' => 10, 'color' => 'black'));

        $phpWord->addParagraphStyle('pFirma', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('fFirma', array('name' => 'Tahoma', 'bold' => true, 'size' => 10, 'color' => 'black'));

        $phpWord->addParagraphStyle('pFirmaTitulo', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('fFirmaTitulo', array('name' => 'Tahoma', 'bold' => true, 'size' => 11, 'color' => 'black'));

        $phpWord->addParagraphStyle('pStyle', array('align' => 'lowKashida', 'marginLeft' => 600, 'marginRight' => 600,
            'marginTop' => 600, 'marginBottom' => 600, 'space' => array('line' => 1)));
        $phpWord->addFontStyle('pFont', array('name' => 'Tahoma', 'bold' => false, 'size' => 11, 'color' => 'black'));

        $phpWord->addParagraphStyle('dtStyle', array('align' => 'right', 'marginLeft' => 600, 'marginRight' => 600,
            'marginTop' => 600, 'marginBottom' => 600, 'space' => array('line' => 1)));
        $phpWord->addFontStyle('dtFont', array('name' => 'Tahoma', 'bold' => true, 'size' => 11, 'color' => 'black'));

        $phpWord->addParagraphStyle('dpStyle', array('align' => 'right', 'marginLeft' => 600, 'marginRight' => 600,
            'marginTop' => 600, 'marginBottom' => 600, 'space' => array('line' => 1)));
        $phpWord->addFontStyle('dpFont', array('name' => 'Tahoma', 'bold' => false, 'size' => 11, 'color' => 'black'));

        $phpWord->addParagraphStyle('itStyle', array(
            'align' => 'left', 'marginLeft' => 600, 'marginRight' => 600,
            'marginTop' => 600, 'marginBottom' => 600, 'space' => array('line' => 1)
        ));
        $phpWord->addFontStyle('itFont', array('name' => 'Tahoma', 'bold' => true, 'size' => 11, 'color' => 'black'));

        /*$phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel', 'levels' => array(
                    array('pStyle' => 'Heading1','format' => 'decimal', 'text' => '%1.')
                )
            )
        );*/
        $phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.', 'left' => 720, 'hanging' => 720, 'tabPos' => 720),
                )
                
            ),
            
                
        );
        //$phpWord->addNumberingStyle('multilevel', array('type' => 'multilevel', 'levels' => array(array('format' => 'decimal', 'text' => '%1.', 'left' => 720, 'hanging' => 720, 'tabPos' => 720), array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720))));
        //$predefinedMultilevel = array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED);

        $paper = new Paper();
        $paper->setSize('Letter');  // or 'Legal', 'A4' ...


        $section = $phpWord->addSection([
            'pageSizeW' => $paper->getWidth(),
            'pageSizeH' => $paper->getHeight(),
            'marginLeft' => '900',
            'marginRight' => '900'
        ]);
        

        $header = $section->createHeader();
        $header->addWatermark(
        '../../views/img/acta.png', [
            'marginTop' => -90,
            'marginLeft' => -50,
            'posHorizontal' => 'absolute',
            'posVertical' => 'absolute'
        ]);


        
        

        $section->addText('ACTA CIRCUNSTANCIADA','tFont','tStyle');

        //$section->addTextBreak();

        $section->addText($respuesta["FCFOLIO"],'ptFont','ptStyle');

        $section->addTextBreak();

        $fechaElaboracion = json_decode($respuesta["FCFECHAACTA"], true);

        $fechaFinElaboracion = json_decode($respuesta["FCFECHAFINACTA"], true);

        $section->addText('En el Municipio de Tlalnepantla de Baz, Estado de México, siendo las '.$fechaElaboracion["hora"].' horas con ' . $fechaElaboracion["minutos"] .' minutos, del día ' . $fechaElaboracion["dia"] .' de ' . $fechaElaboracion["mes"] .' de ' . $fechaElaboracion["anio"] . ', él (la) C. '.$respuesta["FCCONTRALOR"].', servidor público adscrito al Departamento de Auditoría Operacional, Administrativa y Legal, dependiente de la Subcontraloría de Fiscalización de la Contraloría Interna Municipal, quien actúa con fundamento en lo dispuesto en los artículos 174, 175, 176 fracción III, 177 fracciones I y XII, 178, 179 fracciones I, II, III, IV, IX y XII, 193 fracción I, 194 fracciones V y VI, 195 fracciones I, III, IV, VI y X y 196 del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México, publicado en la Gaceta Municipal No. 10, de fecha 22 de febrero de 2022 con la presencia de los (as) CC. '.$respuesta["FCPATRIMONIO"].' y '.$respuesta["FCJEFEPATRIMONIO"].', de la Subdirección de Patrimonio Municipal dependiente de la Secretaría del Ayuntamiento; '.$sindicatura["FCNOMBRE"].', y Elsa Patricia Maldonado Benítez, representantes de la Segunda Sindicatura; y '.$respuesta["FCENLACE"].', Enlace Administrativo de la (del) '.$respuesta["FCAREA"].', mismos que se identifican con credencial para votar con números de folio '.$respuesta["FCNUMCONTRALOR"].', '.$respuesta["FCNUMPATRIMONIO"].', '.$respuesta["FCNUMJEFEPATRIMONIO"].', '.$sindicatura["FCEMPLEADO"].' ,3213013148358 y '.$respuesta["FCNUMENLACE"].' respectivamente, expedidas por el Instituto Nacional Electoral, documentos en los que aparecen sus fotografías, nombres y firmas, los cuales se tuvieron a la vista, se examinaron y se devolvieron de conformidad a sus portadores por ser de uso oficial, luego de obtener copias simples, mismas que se anexan a la presente; se encuentran constituidos en '.$respuesta["FCDIRECCION"].', domicilio que ocupa la (el) '.$respuesta["FCAREA"].', con el objeto de levantar la presente Acta Circunstanciada, en la que se hacen constar los siguientes:','pFont','pStyle');
        
        //$section->addTextBreak();

        $section->addText('HECHOS','ptFont','ptStyle');

        //$section->addTextBreak();

        //$phpWord->addTitleStyle(1, array('name' => 'Tahoma', 'bold' => false, 'size' => 11, 'color' => 'black'), array('numStyle' => 'hNum', 'numLevel' => 0));

        $fechaOficio = json_decode($respuesta["FCFECHAOFICIO"], true);
        $fechaNotificacion = json_decode($respuesta["FCFECHANOTIFICACION"], true);

        $fechaLevantamiento = json_decode($respuesta["FCFECHALEVANTAMIENTO"], true);
        $fechaFinLevantamiento = json_decode($respuesta["FCFECHAFINLEVANTAMIENTO"], true);
        $hecho1 = "Los Servidores Públicos con adscripción al Órgano Interno de Control, a la Subdirección de Patrimonio Municipal, a la Segunda Sindicatura y a la (al) " . $respuesta["FCAREA"] . ", se constituyen el día, hora y lugar referido en el párrafo primero de la presente Acta Circunstanciada, esto en atención al oficio con número de folio " . $respuesta["FCOFICIO"] . ", de fecha " . $fechaOficio["dia"] . " de " . $fechaOficio["mes"] . " de " . $fechaOficio["anio"] . ", suscrito por él C.P. Ricardo Contreras Velázquez, Contralor Interno Municipal, el cual fue notificado el día " . $fechaNotificacion["dia"] . " de " . $fechaNotificacion["mes"] . " de " . $fechaNotificacion["anio"] . ", al (a la) C. " . $respuesta["FCENLACE"] . " en su carácter de Enlace Administrativo de la (del) " . $respuesta["FCAREA"] . " de Tlalnepantla de Baz, Estado de México, administración 2022-2024, a fin de comunicarle que el PRIMER LEVANTAMIENTO FÍSICO DE BIENES MUEBLES DE 2022, sería del " . $fechaLevantamiento["dia"] . " de " . $fechaLevantamiento["mes"] . " al " . $fechaFinLevantamiento["dia"] . " de " . $fechaFinLevantamiento["mes"] . " de " . $fechaFinLevantamiento["anio"] . ", a partir de las " . $fechaLevantamiento["hora"] . " horas, para verificar la existencia física de los bienes muebles en uso y custodia de la (del) ". $respuesta["FCAREA"] .", con base en el INVENTARIO DE BIENES MUEBLES E INMUEBLES conciliados con la tesorería municipal e integrados en el informe mensual municipal de DICIEMBRE de 2021, en relación al LISTADO DE BIENES MUEBLES DEL PRIMER LEVANTAMIENTO FÍSICO 2022, de la (del) " . $respuesta["FCAREA"] . ", expedido por la Subdirección de Patrimonio Municipal, dependiente de la Secretaría del Ayuntamiento.";

        //$section->addText(htmlspecialchars($hecho1, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');
        $section->addListItem($hecho1, 0, 'pFont', 'multilevel', 'pStyle');

        $section->addTextBreak();
        
        
        $section->addText("Folio: " . $respuesta["FCFOLIO"]."/01/04", 'ptFont', 'ptStyle');

        $section->addTextBreak();
        
       // $hecho2 = "2.	En uso de la palabra el C. ".$respuesta["FCCONTRALOR"].", representante de la Contraloría Interna Municipal, le solicita al C. ".$respuesta["FCENLACE"].", Enlace Administrativo del ".$respuesta["FCAREA"].", designe a dos testigos de asistencia; a lo que manifiesta que tiene a bien nombrar a los (as) CC. ".$stringNombreTestigos.", quienes se identifican con credencial para votar con números de FOLIO ".$stringNumEmpleadoTestigos." respectivamente, expedidas por el Instituto Nacional Electoral, Estado de México, documentos en los que aparecen sus fotografías, nombres y firmas, los cuales se tuvieron a la vista, se examinaron y se devolvieron de conformidad a sus portadores por ser de uso oficial, luego de obtener copias simples, mismas que se anexan en la presente Acta Circunstanciada.";
       $hecho2 = "En uso de la palabra él (la) C. ".$respuesta["FCCONTRALOR"].", representante de la Contraloría Interna Municipal, le solicita al (a la) C. ".$respuesta["FCENLACE"].", Enlace Administrativo de la (del) ".$respuesta["FCAREA"].", designe a dos testigos de asistencia; a lo que manifiesta que tiene a bien nombrar a los (as) CC. INGRESE NOMBRES DE LOS TESTIGOS, quienes se identifican con credencial para votar con números de folio INGRESE NUMEROS DE FOLIO DE LOS TESTIGOS respectivamente, expedidas por el Instituto Nacional Electoral, documentos en los que aparecen sus fotografías, nombres y firmas, los cuales se tuvieron a la vista, se examinaron y se devolvieron de conformidad a sus portadores por ser de uso oficial, luego de obtener copias simples, mismas que se anexan en la presente Acta Circunstanciada.";

        //$section->addText(htmlspecialchars($hecho2, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');
        $section->addListItem($hecho2, 0, 'pFont', 'multilevel', 'pStyle');

        $hecho3 = "En uso de la palabra él (la) C. ".$respuesta["FCPATRIMONIO"].", representante de la Subdirección de Patrimonio Municipal, señala: en el Primer Levantamiento Físico de Bienes Muebles, personal de la Subdirección de Patrimonio Municipal acudió al espacio físico, del ".$fechaLevantamiento["dia"]." de ".$fechaLevantamiento["mes"]." al ". $fechaFinLevantamiento["dia"] . " de " . $fechaFinLevantamiento["mes"] . " de " . $fechaFinLevantamiento["anio"] .", donde se encuentran los bienes muebles en uso y custodia de la (del) ".$respuesta["FCAREA"] .", para verificar la existencia física y datos de identificación de los mismos, con la participación del personal habilitado de la Segunda Sindicatura y de la Contraloría Interna Municipal, así como él (la) C. ".$respuesta["FCENLACE"].", Enlace Administrativo de la (del) ".$respuesta["FCAREA"].", situación que se acredita con la (s) Bitácora (s) de Trabajo emitidas por el representante del Órgano Interno de Control, anexa (s) en la presente Acta Circunstanciada.";

        //$section->addText(htmlspecialchars($hecho3, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');
        $section->addListItem($hecho3, 0, 'pFont', 'multilevel', 'pStyle');

        //$section->addTextBreak();

        $hecho3 = "Acto seguido, él (la) C. ".$respuesta["FCENLACE"].", Enlace Administrativo de la (del) ".$respuesta["FCAREA"].", manifiesta: el personal de la Subdirección de Patrimonio Municipal, como de la Segunda Sindicatura y de la Contraloría Interna Municipal, asistieron a la (al) ".$respuesta["FCAREA"].", del ".$fechaLevantamiento["dia"]." de ".$fechaLevantamiento["mes"]." al " . $fechaFinLevantamiento["dia"] . " de " . $fechaFinLevantamiento["mes"] . " de " . $fechaFinLevantamiento["anio"] . ", para la verificación física de los bienes muebles en uso y custodia de la dependencia en comento.";
        
        $section->addText(htmlspecialchars($hecho3, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');

        //$section->addTextBreak();

        $textoTotales = "En uso de la palabra, él (la) C. ".$respuesta["FCPATRIMONIO"].", representante de la Subdirección de Patrimonio Municipal, manifiesta que el PRIMER LEVANTAMIENTO FISICO DE BIENES MUEBLES DE 2022, de la (del) ".$respuesta["FCAREA"].", se realizó con el documento denominado: LISTADO DE BIENES MUEBLES DEL PRIMER LEVANTAMIENTO FÍSICO 2022, de la (del) ".$respuesta["FCAREA"].", emitido por la Subdirección de Patrimonio Municipal, mismo que se detalla en el “ANEXO A” y se integra de la forma siguiente:";

        $section->addText(htmlspecialchars($textoTotales, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');

        $styleCell = array('valign' => 'center');
        $styleFirstCell = array('valign' => 'center', 'bgColor' => '9c9c9c');
        $styleFirstSpan = array('valign' => 'center', 'bgColor' => '9c9c9c', 'gridSpan' => 3);
        $styleFirstCell2 = array('valign' => 'center', 'bgColor' => '9c9c9c', 'borderBottomColor' => '9c9c9c', 'borderBottomSize' => '5');
        
        $fontStyle = array('bold' => true, 'align' => 'center', 'size' => 11, 'name' => 'Tahoma');
        $cellFontStyle = array('color' => 'ff0000', 'bold' => true, 'align' => 'center', 'size' => 11, 'name' => 'Tahoma');

        $bmpActivoFijo = intval($respuesta["FIBMPACTIVOFIJO"]);
        $bmpBajoCosto = intval($respuesta["FIBMPBAJOCOSTO"]);
        $bmfActivoFijo = intval($respuesta["FIBMFACTIVOFIJO"]);
        $bmfBajoCosto = intval($respuesta["FIBMFBAJOCOSTO"]);

        $bmpTotal = $bmpActivoFijo + $bmpBajoCosto;
        $bmfTotal = $bmfActivoFijo + $bmfBajoCosto;

        $bmTotal = $bmpTotal + $bmfTotal;
        $bmActivoFijo = $bmpActivoFijo + $bmfActivoFijo;
        $bmBajoCosto = $bmpBajoCosto + $bmfBajoCosto;
        
        $table = $section->addTable(array('unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'width' => 100 * 50, 'borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 1, 'align' => 'center'));
        $table->addRow(-300);
        $table->addCell(1000, $styleFirstCell)->addText(htmlspecialchars('Total de Bienes Muebles'), $fontStyle,array('fontWeight' => 'bold','align' => 'center'));
        $table->addCell(1000, $styleFirstCell)->addText(htmlspecialchars('Bienes Muebles en Activo Fijo'), $fontStyle,array('fontWeight' => 'bold','align' => 'center'));
        $table->addCell(1000, $styleFirstCell)->addText(htmlspecialchars('Bienes Muebles de Bajo Costo'), $fontStyle,array('fontWeight' => 'bold','align' => 'center'));
        
        
        $table->addRow(-300);
        $table->addCell(1000,$styleCell)->addText(htmlspecialchars($bmTotal),$cellFontStyle, array('align' => 'center', 'fontWeight' => 'bold'));
        $table->addCell(1000,$styleCell)->addText(htmlspecialchars($bmActivoFijo),$cellFontStyle, array('align' => 'center', 'fontWeight' => 'bold'));
        $table->addCell(1000,$styleCell)->addText(htmlspecialchars($bmBajoCosto),$cellFontStyle, array('align' => 'center', 'fontWeight' => 'bold'));
        
        $textoPreTotales = "Posteriormente, en uso de la palabra él (la) C. ".$respuesta["FCCONTRALOR"].", representante del Órgano Interno de Control, manifiesta que una vez conciliada la información con el personal habilitado de la Subdirección de Patrimonio Municipal, de la Segunda Sindicatura y de la (del) ".$respuesta["FCAREA"].", se obtuvo como resultado del PRIMER LEVANTAMIENTO FÍSICO DE BIENES MUEBLES DE 2022, lo siguiente:";
        
        $section->addText(htmlspecialchars($textoPreTotales, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');
        if($this->bienesSob == "true"){

            $table2 = $section->addTable(array('unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'width' => 100 * 50, 'borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 1, 'align' => 'center'));
            $table2->addRow(-300);
            $table2->addCell(1002, $styleFirstCell2)->addText(htmlspecialchars('Bienes Muebles'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(1002, $styleFirstSpan)->addText(htmlspecialchars('Bienes Muebles Presentados'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(1002, $styleFirstSpan)->addText(htmlspecialchars('Bienes Muebles Faltantes'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));

            $table2->addRow(-300);
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Sobrantes'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Total'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Activo Fijo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Bajo Costo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Total'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Activo Fijo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Bajo Costo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));

            
            $table2->addRow(-300,array('exactHeight'=>false, 'height'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars('0'), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpTotal), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpActivoFijo), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpBajoCosto), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfTotal), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfActivoFijo), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfBajoCosto), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
        }else{
            $table2 = $section->addTable(array('unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'width' => 100 * 50, 'borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 1, 'align' => 'center'));
            $table2->addRow(-300);
            
            $table2->addCell(1002, $styleFirstSpan)->addText(htmlspecialchars('Bienes Muebles Presentados'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(1002, $styleFirstSpan)->addText(htmlspecialchars('Bienes Muebles Faltantes'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));

            $table2->addRow(-300);
            
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Total'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Activo Fijo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Bajo Costo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Total'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Activo Fijo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleFirstCell)->addText(htmlspecialchars('Bajo Costo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));


            $table2->addRow(-300, array('exactHeight' => false, 'height'));
            
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpTotal), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpActivoFijo), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmpBajoCosto), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfTotal), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfActivoFijo), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
            $table2->addCell(334, $styleCell)->addText(htmlspecialchars($bmfBajoCosto), $cellFontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
        }

        $section->addTextBreak();


        $section->addText("Folio: " . $respuesta["FCFOLIO"] . "/02/04", 'ptFont', 'ptStyle');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("Cabe señalar que del universo de los X bienes muebles X tienen la leyenda: “bien marcado como faltante en la cuenta pública 2015, se propone para baja conforme al artículo sexagésimo noveno y septuagésimo, sección quinta, de los bienes no localizados” de los cuales X fueron presentados durante el Levantamiento en comento y X no fueron localizados en las instalaciones de la " . $respuesta["FCAREA"] . " detallando sus datos de identificación en el ANEXO III de la presente Acta Circunstanciada.", 'pFont', 'pStyle');

        if($this->bienesSob == "true"){
            
            $sobrantesString = " y los sobrantes en el “ANEXO C”";
        }else{
            $sobrantesString = "";
        }

        $textoFinal1 = "En ese contexto, los bienes muebles faltantes se detallan en el “ANEXO B”".$sobrantesString." de la presente Acta Circunstanciada.";

        $section->addText(htmlspecialchars($textoFinal1, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');

        $textoFinal2  = "Con fundamento en lo dispuesto en los artículos 112 fracciones XV y XX de la Ley Orgánica Municipal del Estado de México; 1, 2 fracción III, 5 fracción I, 11 fracción I, 13 fracción I, 14 fracción II, 17, 18 fracción VI, 52, 67 y 68 de la Ley de Bienes del Estado de México y de sus Municipios; 174, 175, 176 fracción III, 177 fracciones I y XII, 178, 179 fracciones I, II, III, IV, IX y XII, 193 fracción I, 194 fracciones V y VI, 195 fracciones I, III, IV, VI y X y 196 del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México; así como, en los numerales Primero, Noveno fracciones V, VII, VIII, IX, XIII, XXI, XXX, XXXII, XXXIII, XL, XLII y XLV, Décimo fracción I, Vigésimo, Vigésimo Primero, Trigésimo Séptimo, Trigésimo Octavo, Trigésimo Noveno fracciones I, II, III, IV y V, y Cuadragésimo de los Lineamientos para el Registro y Control del Inventario y la Conciliación y Desincorporación de Bienes Muebles e Inmuebles para las Entidades Fiscalizables Municipales del Estado de México, publicados en la Gaceta del Gobierno del Estado de México, de fecha once de julio de dos mil trece y, demás relativos y aplicables, previa lectura de la presente Acta Circunstanciada y no habiendo más hechos que asentar, se da por concluida la presente, a las ". $fechaFinElaboracion["hora"]." horas con ". $fechaFinElaboracion["minutos"]." minutos, del día ". $fechaFinElaboracion["dia"]." de ". $fechaFinElaboracion["mes"]." de ". $fechaFinElaboracion["anio"].", elaborándose en dos tantos originales (uno para el expediente del Órgano Interno de Control y otro para entregar en Sesión Ordinaria al Presidente del Comité de Bienes Muebles e Inmuebles de Tlalnepantla de Baz, México, 2022-2024) y firmando para constancia en todas sus fojas y anexos, al margen y al calce, los que en ella intervinieron, para los efectos administrativos y legales a que haya lugar.";

        $section->addText(htmlspecialchars($textoFinal2, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');

       // $textoFinal3 = "para las Entidades Fiscalizables Municipales del Estado de México, publicados en la Gaceta del Gobierno del Estado de México, de fecha once de julio de dos mil trece y, demás relativos y aplicables, previa lectura de la presente Acta Circunstanciada y no habiendo más hechos que asentar, se da por concluida la presente, a las ". $fechaFinElaboracion["hora"]." horas con ". $fechaFinElaboracion["minutos"]." minutos, del día ". $fechaFinElaboracion["dia"]." de ". $fechaFinElaboracion["mes"]." de ". $fechaFinElaboracion["anio"].", elaborándose en dos tantos originales (uno para el expediente del Órgano Interno de Control y otro para entregar en Sesión Ordinaria al Presidente del Comité de Bienes Muebles e Inmuebles de Tlalnepantla de Baz, Estado de México, 2022-2024) y firmando para constancia en todas sus fojas y anexos, al margen y al calce, los que en ella intervinieron, para los efectos administrativos y legales a que haya lugar.";

        //$section->addText(htmlspecialchars($textoFinal3, ENT_COMPAT, 'UTF-8') , 'pFont', 'pStyle');

        $section->addTextBreak();

        $section->addText("CONTRALORÍA INTERNA MUNICIPAL,", 'fFirmaTitulo', 'pFirmaTitulo');

        $section->addTextBreak();

        $section->addText("_______________________________", 'fFirma', 'pFirma');

        $section->addText("C. ".$respuesta["FCCONTRALOR"], 'fFirma', 'pFirma');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("SUBDIRECCIÓN DE PATRIMONIO MUNICIPAL", 'fFirmaTitulo', 'pFirmaTitulo');
        
        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("_______________________________                                     _______________________________", 'fFirma', 'pFirma');
        $section->addText("C. ".$respuesta["FCPATRIMONIO"]. "                                                    C. Hugo Espinosa Nieto", 'fFirma', 'pFirma');

        $section->addTextBreak();
        $section->addTextBreak();
       
        $section->addText("Folio: " . $respuesta["FCFOLIO"] . "/03/04", 'ptFont', 'ptStyle');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("SEGUNDA SINDICATURA", 'fFirmaTitulo', 'pFirmaTitulo');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("_______________________________                                     _______________________________", 'fFirma', 'pFirma');
        $section->addText("C. ".$sindicatura["FCNOMBRE"]. "                                                C. Elsa Patricia Maldonado Benítez", 'fFirma', 'pFirma');

       
        //$section->addText("_______________________________", 'fFirma', 'pFirma');

        //$section->addText("C. " . $sindicatura["FCNOMBRE"], 'fFirma', 'pFirma');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText($respuesta["FCAREA"], 'fFirmaTitulo', 'pFirmaTitulo');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("_______________________________", 'fFirma', 'pFirma');

        $section->addText("C. " . $respuesta["FCENLACE"], 'fFirma', 'pFirma');

        $section->addText("Enlace Administrativo", 'fFirma', 'pFirma');

        $section->addText($respuesta["FCAREA"], 'fFirma', 'pFirma');

        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("TESTIGOS DE ASISTENCIA", 'fFirmaTitulo', 'pFirmaTitulo');

        $section->addTextBreak();
        $section->addTextBreak();

        //$section->addText("_______________________________                                     _______________________________", 'fFirma', 'pFirma');
       // $section->addText($stringTestigos, 'fFirma', 'pFirma');

        $section->addText("_______________________________                                     _______________________________", 'fFirma', 'pFirma');
        $section->addText("C. Escriba el nombre del testigo                                                                  C. Escriba el nombre del testigo", 'fFirma', 'pFirma');

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        $section->addText("Folio: " . $respuesta["FCFOLIO"]."/04/04", 'ptFont', 'ptStyle');

        $section->addTextBreak();
        $section->addTextBreak();

        $fechaInforme = json_decode($respuesta["FCFECHACREACIONINFORME"], true);
        $fechaDeActa = substr($respuesta["FDFECHACREACIONINFORME"], 0, 10);
        $fechaDeActa = explode("-", $fechaDeActa);
        $fechaDeActa = $fechaDeActa[2]." de ". $fechaInforme["mes"]." de ".$fechaDeActa[0];
        
        $textRun = $section->addTextRun('dtStyle');
        $textRun->addText("Fecha: ", 'dtFont', 'dtStyle');
        $textRun->addText($fechaDeActa , 'dpFont', 'dpStyle');

        $textRun = $section->addTextRun('dtStyle');
        $textRun->addText("No. de Oficio: ", 'dtFont', 'dtStyle');
        $textRun->addText($respuesta["FCOFICIOINFORME"], 'dpFont', 'dpStyle');

        $textRun = $section->addTextRun('dtStyle');
        $textRun->addText("Asunto: ", 'dtFont', 'dtStyle');
        $textRun->addText("Hallazgos del Primer Levantamiento", 'dpFont', 'dpStyle');

        $fechaDeActa = $respuesta["FDFECHAACTA"];
        $fechaDeActa = explode("-", $fechaDeActa);

        $section->addText("Físico de Bienes Muebles " . $fechaDeActa[0] . " de la",'dpFont', 'dpStyle');
        $section->addText($respuesta["FCAREA"],'dpFont', 'dpStyle');

        $section->addText($respuesta["FCJEFEDIRECCION"], 'itFont', 'itStyle');
        $section->addText($respuesta["FCCARGODIRECCION"], 'itFont', 'itStyle');
        $section->addText("PRESENTE", 'itFont', 'itStyle');

  

        $section->addText("Con fundamento en lo dispuesto en los artículos 1, 2 fracción III, 5 fracción I, 13 fracción I, 14 fracción II, 17, 18 fracción VI, 52, 67 y 68 de la Ley de Bienes del Estado de México y de sus Municipios; 112 fracciones XV y XX de la Ley Orgánica Municipal del Estado de México; 174, 175, 176 fracción III, 177 fracciones I y XII, 178, 179 fracciones I, II, III, IV, IX y XII, 193 fracción I, 194 fracciones V y VI, 195 fracciones I, III, IV, VI y X y 196 del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México, publicado en la Gaceta Municipal No. 10, de fecha 22 de febrero de 2022; así  en los numerales Primero, Noveno fracciones V, VII, VIII, IX, XIII, XXI, XXX, XXXII, XXXIII, XL, XLII y XLV, Decimo fracción I, Vigésimo, Vigésimo Primero, Trigésimo Séptimo, Trigésimo Octavo, Trigésimo Noveno fracciones I, II, III, IV y V y Cuadragésimo de los Lineamientos para el Registro y Control del Inventario y la Conciliación y Desincorporación de Bienes Muebles e Inmuebles para las Entidades Fiscalizables Municipales del Estado de México, publicados en la Gaceta del Gobierno del Estado de México, de fecha 11 de julio de 2013; en el Acta de la Primera Sesión Ordinaria del Comité de Bienes Muebles e Inmuebles de Tlalnepantla de Baz, México 2022-2024; en el oficio número ".$respuesta["FCOFICIO"]." , de fecha ".$fechaOficio["dia"]." de ".$fechaOficio["mes"]."  del año en curso, le notifico el Resultado del Primer Levantamiento Físico de Bienes Muebles 2022, realizado del ".$fechaLevantamiento["dia"]." al ".$fechaFinLevantamiento["dia"]." de ".$fechaLevantamiento["mes"]." de ".$fechaLevantamiento["anio"]." del presente año.", 'pFont', 'pStyle');
  

        $table3 = $section->addTable(array('unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'width' => 100 * 50, 'borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50, 'align' => 'center'));
        $table3->addRow(-300);
        $table3->addCell(1500, $styleFirstCell)->addText(htmlspecialchars('Hallazgo'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
        $table3->addCell(1000, $styleFirstCell)->addText(htmlspecialchars('Recomendación'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
        
       
        $table3->addRow(0);
        //Agregar textrun de un listado con un indice con numeros con negritas y despues texto sin negritas justificado


        $textRun = $table3->addCell(1000)->addTextRun(array('align' => 'lowKashida'));
        $textRun->addText("1)	", $fontStyle, array('fontWeight' => 'bold'));
        $textRun->addText("En el Primer Levantamiento Físico de Bienes Muebles de 2022, en uso y custodia de la Presidencia Municipal, se testificó la existencia física de " . $bmpTotal . " bienes muebles, de los cuales " . $bmpActivoFijo . "  son de activo fijo y " . $bmpBajoCosto . "  de bajo costo,de un universo de " . ($bmpTotal + $bmfTotal) . "  que se describen en el “LISTADO DE BIENES MUEBLES DEL PRIMER LEVANTAMIENTO FÍSICO 2022 CON CIFRAS AL 31 DE DICIEMBRE DE 2021, DE LA" . $respuesta["FCAREA"] . " ”, emitido por la Subdirección de Patrimonio Municipal de la Secretaría del Ayuntamiento; En ese contexto existen " . $bmfTotal . " bienes muebles no presentados, de los cuales " . $bmfActivoFijo . "  son de activo fijo y " . $bmfBajoCosto . "  de bajo costo. Por lo anterior X  tienen la leyenda “Bien marcado como faltante en la cuenta pública 2015, se propone para baja conforme al artículo Sexagésimo Noveno y Septuagésimo, Sección Quinta, de los bienes muebles no localizados”, mismos que se detallan en el anexo A.", 'pFont', 'pStyle');


        $textRun = $table3->addCell(1500)->addTextRun(array('align' => 'lowKashida'));
        $textRun->addText("Con fundamento en los artículos 129 párrafo primero y 130 de la ConstituciónPolítica del Estado Libre y Soberano de México; 11 fracción I de la Ley de Bienes del Estado de México y de sus Municipios; 91 fracción XI de la Ley Orgánica Municipal del Estado de México; Octogésimo Sexto de los Lineamientos para el Registro y Control del Inventario y la Conciliación y Desincorporación de Bienes Muebles e Inmuebles para las Entidades Fiscalizables Municipales del Estado de México, de fecha 11 de julio de 2013; y 14 fracciones I, III, VIII, IX, XIII, XVI, XVII, XVIII, XIX, XX Y XXIV del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México publicado en la Gaceta Municipal No. 10, de fecha 22 de febrero de 2022; se recomienda en el ámbito de su competencia de realizar la búsqueda de los ".$bmfTotal." bienes muebles, considerando la información vertida en el último Resguardo que permitirá conocer a los servidores públicos responsables de su conservación y custodia. 

Para los bienes muebles que se encuentran en el supuesto de bienes muebles No Localizados, el área administrativa y la Subdirección de Patrimonio Municipal, deberán de levantar el Acta Administrativa ante el Órgano Interno de Control, considerando que no pertenezcan al período constitucional de la administración pública municipal 2022-2024, es decir, de Bienes Muebles No Localizados  
", 'pFont', 'pStyle');



        if ($this->bienesSob == "true") {
            $table3->addRow(0);
            //Agregar textrun de un listado con un indice con numeros con negritas y despues texto sin negritas justificado
            $textRun = $table3->addCell(1000)->addTextRun(array('align' => 'lowKashida'));
            $textRun->addText("2)	", $fontStyle, array('fontWeight' => 'bold'));
            $textRun->addText("Existe además un total de X  bienes muebles sobrantes con etiqueta de inventario, pero no relacionadas en el “Listado de Bienes Muebles Primer Levantamiento Físico 2022, de la ".$respuesta["FCAREA"]." ”, mismos que se detallan en el anexo B.", 'pFont', 'pStyle');

            $textRun = $table3->addCell(1500)->addTextRun(array('align' => 'lowKashida'));
            $textRun->addText("Con fundamento en los artículos 129 párrafo primero y 130 de la Constitución Política del Estado Libre y Soberano de México; 11 fracción I de la Ley de Bienes del Estado de México y de sus Municipios; 91 fracción XI de la Ley Orgánica Municipal del Estado de México; Capítulos XV, XVI y XIX de los Lineamientos para el Registro y Control del Inventario y la Conciliación y Desincorporación de Bienes Muebles e Inmuebles para las Entidades Fiscalizables Municipales del Estado de México, de fecha 11 de julio de 2013; y 14 fracciones I, III, VIII, IX, XIII, XVI, XVII, XVIII, XIX, XX y XXIV del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México publicado en la Gaceta Municipal No. 10, de fecha 22 de febrero de 2022 se recomienda en el ámbito de su competencia documentar la legal procedencia de los X  bienes muebles que no se relacionan en el “Listado de Bienes Muebles del Primer Levantamiento Físico 2022, con cifras al 31 de Diciembre de 2021”.", 'pFont', 'pStyle');
        }
        
        $section->addTextBreak();

        $table4 = $section->addTable(array('unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT, 'width' => 100 * 50, 'borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50, 'align' => 'center'));
        $table4->addRow(-300);
        $table4->addCell(2500, $styleFirstCell)->addText(htmlspecialchars('Recomendaciones Generales'), $fontStyle, array('fontWeight' => 'bold', 'align' => 'center'));
        
        $table4->addRow(0);
        $textRun = $table4->addCell(2500)->addTextRun(array('align' => 'lowKashida'));
        $textRun->addText("a)	¿Deberá dar a conocer la obligación de los servidores públicos adscritos a la ".$respuesta["FCAREA"]." , respecto al cuidado de los bienes muebles en uso y custodia de los mismos, con apego a lo establecido en el artículo 88 fracción XI de la Ley del Trabajo de los Servidores Públicos del Estado y Municipios, que a la letra dice:", 'pFont', 'pStyle');
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        $textRun->addText("“XI. Tratar con cuidado y conservar en buen estado el equipo, mobiliario y útiles que se les proporcionen para el desempeño de su trabajo y no utilizarlos para objeto distinto al que están destinados e informar, invariablemente, a sus superiores inmediatos de los defectos y daños que aquéllos sufran tan pronto como los adviertan;”",array('italic' => true,'size' => 11),array('align' => 'center'));
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        $textRun->addText("b)	Mantener las medidas implementadas en el control interno de los bienes muebles (activo y bajo costo); además de llevar, el registro de los bienes muebles (gasto) no inventariables que aún cuentan con vida útil, así como de los bienes de propiedad de terceros, el cual deberá evidenciar cuando así lo requiera la Contraloría Interna Municipal.", 'pFont', 'pStyle');
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        $textRun->addText("c)	Para el registro de alta (adquisiciones por compra, donación, dación en pago) o baja (enajenación, robo o siniestro, obsolencia, donación, dación en pago, entre otros) de bienes muebles, se recomienda atender los requisitos en el ámbito de su competencia que refieren los capítulos XIX y XXI respectivamente, de los Lineamientos para el Registro y Control del Inventario y la Conciliación y Desincorporación de Bienes Muebles e Inmuebles para las Entidades Fiscalizables Municipales del Estado de México.", 'pFont', 'pStyle');

        
        $section->addTextBreak();
        $textRun = $section->addTextRun('pStyle');
        $textRun->addText("En ese contexto, se le otorga un término de ", 'pFont', 'pStyle');
        $textRun->addText("cinco días hábiles, ", 'dtFont', 'dtStyle');
        $textRun->addText("contados a partir del día siguiente al de la notificación del presente, a efecto de aclarar, justificar o solventar los hallazgos derivados del Primer Levantamiento Físico de Bienes Muebles de 2019, mediante documentación certificada generada en la dependencia a su cargo u obtenido de las autoridades competentes.", 'pFont', 'pStyle');
        $section->addText("Sin otro particular, le reitero a usted, mi más atenta y distinguida consideración.", 'pFont');
        $textRun->addTextBreak();
        $textRun->addTextBreak();
        
        $section->addText("A T E N T A M E N T E", 'fFirmaTitulo', 'pFirmaTitulo');
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addText("L.A.E. EDUARDO EFRAÍN BENHUMEA MACEDO", 'fFirmaTitulo', 'pFirmaTitulo');

        $section->addText("CONTRALOR INTERNO MUNICIPAL", 'fFirmaTitulo', 'pFirmaTitulo');
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        $textRun = $section->addTextRun('pStyle');
        $textRun->addText("C.c.p. Lic. Miguel Ángel Bravo Suberville, Secretario del Ayuntamiento.-Conocimiento.", array('font' => 'lowKashida','size'=>'9'), 'pStyle');
        $textRun->addTextBreak();
        $textRun->addText("C.c.p. C. ".$respuesta["FCPATRIMONIO"]." , Patrimonio Municipal de la ".$respuesta["FCAREA"]." .-Conocimiento.", array('font' => 'lowKashida','size'=>'9'), 'pStyle');
        $textRun->addTextBreak();
        $textRun->addText("C.c.p. C. Elsa Patricia Maldonado Benítez, representante de la Segunda Sindicatura.-Conocimiento. ", array('font' => 'lowKashida','size'=>'9'), 'pStyle');
        $textRun->addTextBreak();
        $textRun->addText("C.c.p. C. ".$respuesta["FCENLACE"]." , Enlace Administrativo de la ".$respuesta["FCAREA"]." .- Atención y Seguimiento.", array('font' => 'lowKashida','size'=>'9'), 'pStyle');
        $textRun->addTextBreak();
        $textRun->addText("Archivo/Minutario", array('font' => 'lowKashida','size'=>'9'), 'pStyle');
        $textRun->addTextBreak();
        $textRun->addText("EEBM/PRTC/MRG/Ehhb*", array('font' => 'lowKashida','size'=>'9'), 'pStyle');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $fileTemp = 'ACTA' . random_int(100, 999) . '.docx';

        try {


            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . urlencode($fileTemp) . '"');
            $objWriter->save('php://output');
        } catch (Exception $e) {

            exit($e->getMessage());
        }
        
        
    }
}

if(isset($_GET['idActa']) && isset($_GET['sindicaturaId']) && isset($_GET['bienesSob'])){
    $descargarWord = new WordController();
    $descargarWord->idActa = $_GET['idActa'];
    $descargarWord->sindicaturaId = $_GET['sindicaturaId'];
    $descargarWord->bienesSob = $_GET['bienesSob'];
    $descargarWord->ctrGenerateWord();
    
}
