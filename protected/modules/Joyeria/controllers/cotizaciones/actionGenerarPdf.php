<?php
//COTIZACIONES GENERAR PDF
class actionGenerarPdf extends CAction {

    public function run() 
    {
        if($_GET['email']){
            $helper= new Helper();
            $resultado= $helper->generarPDF($_GET['token'], $_GET['tokenEdt'], null, 1);

            if($resultado)
                $mensaje= 'Correo Enviado!';
            else
                $mensaje= 'Error al enviar Correo, intente más tarde';

            $resultado= array('mensaje'=> $mensaje);

            echo CJSON::encode($resultado);
            Yii::app()->end();
        } else{
            $helper= new Helper();
            $helper->generarPDF($_GET['token'], $_GET['tokenEdt'], null, null, 1);
        }

    }
}
