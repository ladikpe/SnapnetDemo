<?php 

namespace App\Actions;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;

class MsWordAction{
  

     function downloadWordFromText($text,$alias=''){
        // header("Content-type: application/vnd.ms-word");  
        // header("Content-Disposition: attachment;Filename=". $alias .".doc");  
        // header("Pragma: no-cache");  
        // header("Expires: 0"); 
        // echo '<h1>Heading...</h1>';   
        // echo $text;  
        // $this->downloadWord($text,$alias);
        // echo $_POST["description"];
        // return 'dd';
        // dd('ee');
         return response("<html><body>$text</body></html>")
            ->header('Content-Type', "text/html")
            ->header("Content-Disposition","attachment;Filename=report.doc");
     }

     private function downloadWord($text,$alias){

         $word = new PhpWord;
         $section = $word->addSection();
         Html::addHtml($section, trim($text), false, false);
         

        //  foreach ($textArr as $k=>$text){
            
        //  }


         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment;filename="' . $alias . '.docx"');
         $objWriter = IOFactory::createWriter($word, 'Word2007');
         $objWriter->save('php://output');         

     }
     public function arrayToCsv(array &$array)
     {
        
        if (count($array)==0) {
            return null;
        }
      
        ob_start();
        $df=fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($array)));
        foreach ($array as $row) {
            fputcsv($df, $row);
            
        }
        fclose($df);
        return ob_get_clean();
     }

     public function download_send_headers($filename)
     {
        $now=gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2020 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");


     }



}