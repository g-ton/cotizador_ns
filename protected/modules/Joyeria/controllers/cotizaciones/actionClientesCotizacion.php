<?php
class actionClientesCotizacion extends CAction {

    public function run() 
    {
    	//Envío de formulario para agregar y/o editar Cliente
    	if(isset($_GET['id']))
    	{
    		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
    		//Edición Inicio
    		if(isset($_GET['idCliente'])){
    			$idCliente= $_GET['idCliente'];
    			$modelCliente=  CotClientes::model()->findByPk($_GET['idCliente']);
    		}

    		//Creación Inicio
    		else{
    			$idCliente= '';
    			$modelCliente = new CotClientes;
    		}

    		// Condición para validación de modelo tanto en modo edición como nueva creación
	        if(isset($_POST['CotClientes']))
	        {
	        	// Validación nueva creación
	            if(!isset($_GET['idCliente']))
	            {
	                $modelCliente->attributes = $_POST['CotClientes'];
	                $modelCliente->empresa = preg_replace('([^A-Za-zñÑáéíóúÁÉÍÓÚ0-9\s])', '', $_POST['CotClientes']['empresa']);
	                $modelCliente->id_usuario = Yii::app()->user->getId();
	             
	                if($modelCliente->validate())
	                {
	                	if($modelCliente->save())
	                    {
	                    	//Se guarda el cliente en el sistema local para el rol Admin o Vendedor
	                    	if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
        					{
        						//Clientes en Sistema Local
        						$modelClienteSL = new Clientes;
        						$modelClienteSL->id_personal = Yii::app()->session['id_personal_sl'];
        						$modelClienteSL->fecha_alta = Date("Y-m-d");
        						$modelClienteSL->nombre = $modelCliente->empresa;
        						$modelClienteSL->telefono = $modelCliente->tel1;
        						$modelClienteSL->mail_fact = $modelCliente->email;
        						$modelClienteSL->mail = $modelCliente->email;
        						$modelClienteSL->contacto = $modelCliente->nombre_cliente;
        						$modelClienteSL->id_cliente_web = $modelCliente->id_cliente;
        						if($modelClienteSL->validate()){
        							$modelClienteSL->save();
        							$modelCliente->id_original_cliente= $modelClienteSL->id_cliente;
	        						$modelCliente->save();
        						}
        					}

	                    	echo '<script>'; 
		                    echo '$.fn.yiiGridView.update("clientes-grid");';
		                    echo "$.fancybox.close();";
		                    echo '</script>';
		                    Yii::app()->end();
	                    }
	                }
	            }

	            // Validación edición
	            else
	            {
	            	$modelCliente=  CotClientes::model()->findByPk($_GET['idCliente']);
	            	$modelCliente->attributes = $_POST['CotClientes'];
	            	$modelCliente->empresa = preg_replace('([^A-Za-zñÑáéíóúÁÉÍÓÚ0-9\s])', '', $_POST['CotClientes']['empresa']);
	             
	                if($modelCliente->validate())
	                {
	                	if($modelCliente->save())
	                    {
	                    	//Se guarda el cliente en el sistema local para el rol Admin o Vendedor
	                    	if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
        					{
        						//Clientes en Sistema Local
        						$modelClienteSL=  Clientes::model()->find('id_cliente_web=?',array($_GET['idCliente']));
        						if($modelClienteSL!= NULL)
        						{
	        						$modelClienteSL->id_personal = Yii::app()->session['id_personal_sl'];
	        						$modelClienteSL->fecha_alta = Date("Y-m-d");
	        						$modelClienteSL->nombre = $modelCliente->empresa;
	        						$modelClienteSL->telefono = $modelCliente->tel1;
	        						$modelClienteSL->mail_fact = $modelCliente->email;
	        						$modelClienteSL->mail = $modelCliente->email;
	        						$modelClienteSL->contacto = $modelCliente->nombre_cliente;
	        						$modelClienteSL->id_cliente_web = $modelCliente->id_cliente;
	        						if($modelClienteSL->validate())
	        							$modelClienteSL->save();
        						}
        					}

	                    	echo '<script>'; 
		                    echo '$.fn.yiiGridView.update("clientes-grid");';
		                    echo "$.fancybox.close();";
		                    echo '</script>';
		                    Yii::app()->end();
		                }
		            }     
	            }
	        }
    		$this->controller->renderPartial('agregarCliente',
    			array('modelCliente'=>$modelCliente, 'idCliente'=>$idCliente), false, true);
        	Yii::app()->end();
    	}

    	//Envío de formato json para ser consumido por DropdownList
    	else{
	        $resultado = Yii::app()->db->createCommand()
	            ->select()->from('cot_clientes')
	            ->where('id_cliente=:idcl', array(':idcl'=>$_POST["cot_cliente"]))->queryRow();
	        
	        echo CJSON::encode($resultado);
	        Yii::app()->end();
    	}
    }

}