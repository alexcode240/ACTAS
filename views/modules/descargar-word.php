<?php
require_once "../../extensions/vendor/autoload.php";

use PhpOffice\PhpWord\Style\Paper;

class WordController
{

    static public function ctrGenerateWord()
    {

       
        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $phpWord->addParagraphStyle('tStyle', array('align' => 'center', 'spaceAfter' => 100));
        $phpWord->addFontStyle('tFont', array('name'=>'Arial','bold' => true, 'size' => 15, 'color' => 'ff0000'));

        $paper = new Paper();
        $paper->setSize('Letter');  // or 'Legal', 'A4' ...


        $section = $phpWord->addSection([
            'pageSizeW' => $paper->getWidth(),
            'pageSizeH' => $paper->getHeight(),
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

$descargarWord = new WordController();
$descargarWord -> ctrGenerateWord();