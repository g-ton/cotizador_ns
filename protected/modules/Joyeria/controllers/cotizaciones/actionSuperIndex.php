<?php
//COTIZACIONES GENERAL
class actionSuperIndex extends CAction {

    public function run() 
    {
        $baseUrl= Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/js/jBlockUi.js');
        $cs->registerScriptFile($baseUrl.'/js/smoke.js');
        $cs->registerCssFile($baseUrl.'/css/smoke.css');
        
        $modelCotizacion=new CotCotizacion('search');
        $modelCotizacion->id_usuario= Yii::app()->user->getId();
        $modelCotizacion->activo= 1;
        if(isset($_GET['CotCotizacion']))
            $modelCotizacion->attributes=$_GET['CotCotizacion'];
        //Se genera un número aleatorio para crear la cotización
        $token= mt_rand().date("Ymd");
 
        $this->controller->render('superIndex',array('modelCotizacion'=>$modelCotizacion, 'token'=>$token));
    }
}
