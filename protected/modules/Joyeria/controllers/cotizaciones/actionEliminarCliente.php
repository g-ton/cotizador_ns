<?php
class actionEliminarCliente extends CAction {
    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        $idCliente= $_GET['idCliente'];
        $val= $_GET['val']; 

        if($val== "SI"){
            $model = CotClientes::model()->findByPk($idCliente);
            $model->estatus= 0;
            $model->save(false);
            echo '<script>';
            echo '$.fn.yiiGridView.update("clientes-grid");';
            echo '$.fancybox.close();';
            echo '</script>';
            Yii::app()->end();
        }

        $this->controller->renderPartial("eliminarCliente",array('idCliente'=>$idCliente), false, true);
    }
}
?>
