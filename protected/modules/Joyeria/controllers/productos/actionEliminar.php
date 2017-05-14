<?php

class actionEliminar extends CAction {

    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $id_producto= $_GET['id_producto']; 
        $val= $_GET['val'];  
  
        if($val=='SI')
        {    
            $model =  Productos::model()->findByPk($id_producto);                 
            $model->estatus    = 'INACTIVO';

            // Se buscan las imágenes del producto para ser eliminadas
            $modelImagenes =  Imagenes::model()->findAll('id_producto=?', array($id_producto));
            $tamImagenesArray= sizeof($modelImagenes);
            
            for ($i=0; $i < $tamImagenesArray ; $i++) 
            { 
                $rutaImagen= $modelImagenes[$i]->ruta;
                $porciones= explode("/", $rutaImagen);
                unlink("./temp/".$porciones[3]);
                unlink("./temp/thumbs/".$porciones[3]);
            }

            if($model->save())
            {
                echo '<script>';
                echo '$.fn.yiiGridView.update("Productos-grid");';
                echo "$.fancybox.close();";
                echo '</script>';
                Yii::app()->end();   
            }
        }

        $this->controller->renderPartial("eliminar", array('id_producto' => $id_producto), false, true);
        Yii::app()->end();
    }

}
