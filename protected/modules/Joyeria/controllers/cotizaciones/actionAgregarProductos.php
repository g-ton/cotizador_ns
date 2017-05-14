<?php
//COTIZACIONES AGREGAR PRODUCTOS
class actionAgregarProductos extends CAction {

    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.fancybox-1.3.4.pack.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;

  //      Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = false;
        //Yii::app()->clientScript->scriptMap['jquery.fancybox-1.3.4.pack.js'] = false;
        //Yii::app()->clientScript->scriptMap['jquery.fancybox-1.3.4.pack.js'] = false;
        //Yii::app()->clientScript->scriptMap['select2.js'] = false;

        $modelProductos=new Productos('search');
        $modelProductos->unsetAttributes();  
        if(isset($_GET['Productos']))
            $modelProductos->attributes=$_GET['Productos'];

        $modelCategorias= Categorias::model()->findAll();
        $listCategorias = CHtml::listData($modelCategorias, 'id', 'nombre_categoria');

        $this->controller->renderPartial('agregarProductos',array(
            'modelProductos'=>$modelProductos, 'listCategorias'=>$listCategorias), false, true);
    }

}