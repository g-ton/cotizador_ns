<?php
class actionDatosCliente extends CAction {

    public function run() 
    {
    	//Envío de formulario para agregar y/o editar Cliente desde ventana modal
    	if(isset($_GET['token'])){
    		Yii::app()->clientScript->scriptMap['jquery.js'] = false;

    		$modelCotizacion= CotCotizacion::model()->find("token=?", array($_GET['token']));

    		if(isset($_POST['CotCotizacion'])){
    			$modelCotizacion->attributes = $_POST['CotCotizacion'];
                $modelCotizacion->activo= 1;
            	$modelCotizacion->id_original_cliente= $_POST['CotCotizacion']['id_original_cliente'];
                
                $fecha = date('Y-m-j');
                if($_POST['diasValidez']== '')
                    $_POST['diasValidez']= 7;
                $nuevafecha = strtotime ($_POST['diasValidez'].' day', strtotime($fecha)) ;
                $modelCotizacion->fecha_validez = date ( 'Y-m-j' , $nuevafecha );

                if($modelCotizacion->validate()){
                    if($modelCotizacion->save()){
                        echo '<script>'; 
	                    echo "$.fancybox.close();";
	                    echo '</script>';
	                    Yii::app()->end();
                    }
                }
    		}
        
    		$this->controller->renderPartial('datosCliente', 
    			array('modelCotizacion'=>$modelCotizacion, 'token'=>$_GET['token'], 'validez'=> 7), false, true);
        	Yii::app()->end();
    	}
    }

}