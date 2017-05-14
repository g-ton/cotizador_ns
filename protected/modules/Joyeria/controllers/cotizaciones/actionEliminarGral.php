<?php
class actionEliminarGral extends CAction {
    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $id_cotizacion= $_GET['id_cotizacion'];
        $val= $_GET['val']; 

        if($val== "SI"){
            $model = CotCotizacion::model()->findByPk($id_cotizacion);
            $model->activo= 0;
            $model->save(false);
            echo '<script>';
            echo '$.fn.yiiGridView.update("cotizacionesgral-grid");';
            echo '$.fancybox.close();';
            echo '</script>';
            Yii::app()->end();
        }

        $this->controller->renderPartial("eliminarGral",array('id_cotizacion'=>$id_cotizacion), false, true);
    }
}
?>
