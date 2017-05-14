<?php

class actionEliminar extends CAction {

    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $id_categoria= $_GET['id_categoria']; 
        $val= $_GET['val'];  
  
        if($val=='SI')
        {    
            $modelProductos= Productos::model()->findAll('id_categoria=?', array($id_categoria));
        
            foreach ($modelProductos as $key) 
            {
                $idProducto= $key->id;

                $modelImagenes= Imagenes::model()->findAll('id_producto=?', array($idProducto));
                $tamImagenesArray= sizeof($modelImagenes);
            
                for ($i=0; $i < $tamImagenesArray ; $i++) 
                { 
                    $rutaImagen= $modelImagenes[$i]->ruta;
                    $porciones= explode("/", $rutaImagen);
                    if (file_exists("./temp/".$porciones[3])) 
                        unlink("./temp/".$porciones[3]);

                    if (file_exists("./temp/thumbs/".$porciones[3])) 
                            unlink("./temp/thumbs/".$porciones[3]);
                }
            }

            $sql= "DELETE FROM categorias WHERE id=" .$id_categoria;
            Yii::app()->db->createCommand($sql)->execute();
        
            echo '<script>';
            echo '$.fn.yiiGridView.update("Categorias-grid");';
            echo "$.fancybox.close();";
            echo '</script>';
            Yii::app()->end();   
        }

        $this->controller->renderPartial("eliminar", array('id_categoria' => $id_categoria), false, true);
        Yii::app()->end();
    }

}
