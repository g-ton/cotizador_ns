<?php
class actionIndexClientes extends CAction {

    public function run() 
    {
        $modelCliente= new CotClientes('search');
        $modelCliente->id_usuario= Yii::app()->user->getId();
        $modelCliente->estatus= 1;
        if(isset($_GET['CotClientes']))
            $modelCliente->attributes= $_GET['CotClientes'];
 
        $this->controller->render('indexClientes',array('modelCliente'=> $modelCliente));
    }
}
