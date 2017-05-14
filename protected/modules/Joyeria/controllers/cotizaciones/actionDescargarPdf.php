<?php

class actionDescargarPdf extends CAction {

      public function run()
      {
            $model = CotCotizacion::model()->findByPk($_GET["id_cotizacion"]);
            $archivo= $model->rutaArchivo;            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($archivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            readfile($archivo);
            Yii::app()->end();
      }
}
