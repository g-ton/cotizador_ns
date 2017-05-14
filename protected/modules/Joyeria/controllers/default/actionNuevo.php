<?php
// ActionNuevo CATEGORÍAS
class actionNuevo extends CAction {

    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $id_categoria= $_GET['id_categoria']; 
        
        if($id_categoria!=NULL)                              
            $model =  Categorias::model()->findByPk($id_categoria);
         
        else
            $model = new Categorias;
   

            if(isset($_POST['Categorias']))
            {               
                $model->attributes = $_POST['Categorias'];
                
                if($model->save())
                {
                    echo '<script>';
                    echo '$.fn.yiiGridView.update("Categorias-grid");';
                    echo "$.fancybox.close();";
                    echo '</script>';
                    Yii::app()->end();
                }
            }
       
        $this->controller->renderPartial("nuevo", array('model' => $model, 
            'id_categoria' => $id_categoria), false, true);
        Yii::app()->end();
    }

}
