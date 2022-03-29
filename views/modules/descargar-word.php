<?php
require_once "../../extensions/vendor/autoload.php";
require_once "../../controllers/actas.controller.php";
require_once "../../models/actas.model.php";

use PhpOffice\PhpWord\Style\Paper;

class WordController
{
    public $idActa;

    public function ctrGenerateWord()
    {
        $acta = new ActasController();
        $item = "FIACTAID";
        $respuesta = $acta->ctrShowActas($item, $this->idActa);

       
        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $phpWord->addParagraphStyle('tStyle', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('tFont', array('name'=>'Arial','bold' => true, 'size' => 15, 'color' => 'ff0000'));

        $phpWord->addParagraphStyle('ptStyle', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('ptFont', array('name' => 'Arial', 'bold' => true, 'size' => 10, 'color' => 'black'));

        $phpWord->addParagraphStyle('pStyle', array('align' => 'lowKashida', 'marginLeft' => 600, 'marginRight' => 600,
            'marginTop' => 600, 'marginBottom' => 600, 'space' => array('line' => 1)));
        $phpWord->addFontStyle('pFont', array('name' => 'Tahoma', 'bold' => false, 'size' => 11, 'color' => 'black'));


        $phpWord->addNumberingStyle(
            'hNum',
            array(
                'type' => 'multilevel', 'levels' => array(
                    array('pStyle' => 'Heading1', 'format' => 'decimal', 'text' => '%1.', 'size' => 12)
                )
            )
        );

        $paper = new Paper();
        $paper->setSize('Letter');  // or 'Legal', 'A4' ...


        $section = $phpWord->addSection([
            'pageSizeW' => $paper->getWidth(),
            'pageSizeH' => $paper->getHeight(),
            'marginLeft' => '1200',
            'marginRight' => '1200'
        ]);
        

        $header = $section->createHeader();
        $header->addWatermark(
        '../../views/img/acta.png', [
            'marginTop' => -40,
            'marginLeft' => -70,
            'posHorizontal' => 'absolute',
            'posVertical' => 'absolute'
        ]);


        $text = "\n\n";
        $textlines = explode("\n", $text);

        $textrun = $section->addTextRun();
        $textrun->addText(array_shift($textlines));
        foreach ($textlines as $line) {
            $textrun->addTextBreak();
            $textrun->addText($line);
        }
        

        $section->addText('ACTA CIRCUNSTANCIADA','tFont','tStyle');

        //$section->addTextBreak();

        $section->addText($respuesta["FCFOLIO"],'ptFont','ptStyle');

        $section->addTextBreak();

        $fechaElaboracion = json_decode($respuesta["FCFECHAACTA"], true);

        $section->addText('En el Municipio de Tlalnepantla de Baz, Estado de México, siendo las '.$fechaElaboracion["hora"].' horas con ' . $fechaElaboracion["minutos"] .' minutos, del día ' . $fechaElaboracion["dia"] .' de ' . $fechaElaboracion["mes"] .' de ' . $fechaElaboracion["anio"] . ', el C. '.$respuesta["FCCONTRALOR"].', servidor público adscrito al Departamento de Auditoría Operacional, Administrativa y Legal, dependiente de la Subcontraloría de Fiscalización de la Contraloría Interna Municipal, quien actúa con fundamento en lo dispuesto en los artículos 174, 175, 176 fracción III, 177 fracciones I y XII, 178, 179 fracciones I, II, III, IV, IX y XII, 193 fracción I, 194 fracciones V y VI, 195 fracciones I, III, IV, VI y X y 196 del Reglamento Interno de la Administración Pública Municipal de Tlalnepantla de Baz, Estado de México, publicado en la Gaceta Municipal No. 10, de fecha 22 de febrero de 2022 con la presencia de los (as) CC. '.$respuesta["FCPATRIMONIO"].' y '.$respuesta["FCJEFEPATRIMONIO"].', de la Subdirección de Patrimonio Municipal adscrita a la Secretaría del Ayuntamiento; '.$respuesta["FCSSINDICATURA"].', representante de la Segunda Sindicatura; y '.$respuesta["FCENLACE"].', Enlace Administrativo del '.$respuesta["FCAREA"].', mismos que se identifican con credenciales de empleados números '.$respuesta["FCNUMCONTRALOR"].', '.$respuesta["FCNUMPATRIMONIO"].', '.$respuesta["FCNUMJEFEPATRIMONIO"].', '.$respuesta["FCNUMSSINDICATURA"].' y '.$respuesta["FCNUMENLACE"].' respectivamente, expedidas por el H. Ayuntamiento de Tlalnepantla de Baz, Estado de México, documentos en los que aparecen sus fotografías, nombres y firmas, los cuales se tuvieron a la vista, se examinaron y se devolvieron de conformidad a sus portadores por ser de uso oficial, luego de obtener copias simples, mismas que se anexan a la presente; se encuentran constituidos en '.$respuesta["FCDIRECCION"].', domicilio que ocupa el '.$respuesta["FCAREA"].', con el objeto de levantar la presente Acta Circunstanciada, en la que se hacen constar los siguientes:','pFont','pStyle');
        
        $section->addTextBreak();

        $section->addText('HECHOS','ptFont','ptStyle');

        $section->addTextBreak();

        $phpWord->addTitleStyle(1, array('size' => 11), array('numStyle' => 'hNum', 'numLevel' => 0));

        $section->addTitle('Los Servidores Públicos con adscripción al Órgano Interno de Control, a la Subdirección de Patrimonio Municipal, a la Segunda Sindicatura y al ', 1);
        
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

if(isset($_GET['idActa'])){
    $descargarWord = new WordController();
    $descargarWord->idActa = $_GET['idActa'];
    $descargarWord->ctrGenerateWord();
    
}
