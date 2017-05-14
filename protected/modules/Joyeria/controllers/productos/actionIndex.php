<?php

class actionIndex extends CAction {

    public function run() 
    {
        $model=new Productos('search');
        $model->unsetAttributes();  
        if(isset($_GET['Productos']))
            $model->attributes=$_GET['Productos'];

        $modelCategorias= Categorias::model()->findAll();
        $listCategorias = CHtml::listData($modelCategorias, 'id', 'nombre_categoria');

        $this->controller->render('index',array(
            'model'=>$model, 'listCategorias'=>$listCategorias
        ));
    }

}
