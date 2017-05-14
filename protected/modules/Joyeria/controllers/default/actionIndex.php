<?php

class actionIndex extends CAction {

    public function run() 
    {
        $model=new Categorias('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Categorias']))
            $model->attributes=$_GET['Categorias'];
 
        $this->controller->render('index',array(
            'model'=>$model
        ));
    }

}