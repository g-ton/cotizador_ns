<?php
//COTIZACIONES
class actionEliminar extends CAction {

    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $id_cotizacion= $_GET['id_cotizacion']; 
        $val= $_GET['val'];  
  
        if($val=='SI')
        {   
            $sql= "DELETE FROM cot_cotizaciontmp WHERE id=" .$id_cotizacion;
            Yii::app()->db->createCommand($sql)->execute();

            echo '<script>';
            echo '$.fn.yiiGridView.update("Cotizaciones-grid");';
            echo "$.fancybox.close();";
            echo '</script>';
            Yii::app()->end();   
        }

        $this->controller->renderPartial("eliminar", array('id_cotizacion' => $id_cotizacion), false, true);
        Yii::app()->end();
    }
}
