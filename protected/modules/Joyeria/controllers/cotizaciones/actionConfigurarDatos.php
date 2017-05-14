<?php
class actionConfigurarDatos extends CAction {
    public function run() 
    {
    	// Valores por default para los campos hidden e imagen
        $input1= "vacio1";
        $imagen1= "./images/sinImagen.jpg";

        if(Yii::app()->session['rol_usuario']== 'admin')
        {
           $configuracionExistente = Yii::app()->db->createCommand()
                ->select('*')->from('cot_configuracion')
                ->where('conf_general = :cong', array(':cong'=>1))
                ->queryRow();
        }

        else
        {
            $configuracionExistente = Yii::app()->db->createCommand()
                ->select('*')->from('cot_configuracion')
                ->where('id_usuario = :us', array(':us'=>Yii::app()->user->getId()))
                ->queryRow();
        }

        // Condición para edición de datos
        if($configuracionExistente!= false)
        {  
            $modelCotConfiguracion = new CotConfiguracion;
            $modelCotConfiguracion->id_usuario= $configuracionExistente['id_usuario'];
            $modelCotConfiguracion->departamento= $configuracionExistente['departamento'];
            $modelCotConfiguracion->telefono= $configuracionExistente['telefono'];
            $modelCotConfiguracion->email= $configuracionExistente['email'];
            $modelCotConfiguracion->pagina_web= $configuracionExistente['pagina_web'];
            $modelCotConfiguracion->razon_social= $configuracionExistente['razon_social'];
            $modelCotConfiguracion->banco= $configuracionExistente['banco'];
            $modelCotConfiguracion->num_cuenta= $configuracionExistente['num_cuenta'];
            $modelCotConfiguracion->clabe= $configuracionExistente['clabe'];
            $modelCotConfiguracion->inf_extra= $configuracionExistente['inf_extra'];
            $modelCotConfiguracion->logo= $configuracionExistente['logo'];
            $input1= $configuracionExistente['logo'];
            $imagen1= $configuracionExistente['logo'];
        }

        // Condición para creación de nueva configuración
        else
        	$modelCotConfiguracion = new CotConfiguracion;

        // Condición para validación de modelo tanto en modo edición como nueva creación
        if(isset($_POST['CotConfiguracion']))
        {   
            // Validación nueva creación
            if($configuracionExistente== false)
            {
                $modelCotConfiguracion->attributes = $_POST['CotConfiguracion'];
                $modelCotConfiguracion->logo = $_POST['hiddenImg1'];
                $modelCotConfiguracion->id_usuario = Yii::app()->user->getId();
                //Uso de roles, si es admin se crea una configuración general
                if(Yii::app()->session['rol_usuario']== 'admin')
                   $modelCotConfiguracion->conf_general= 1; 
             
                if($modelCotConfiguracion->validate())
                {
                	if($modelCotConfiguracion->save())
                    {
                    	$imagen1= $_POST['hiddenImg1'];
                    	Yii::app()->user->setFlash('contact','Configuración guardada con éxito!');
                    	$this->controller->render('configurarDatos',array('model'=>$modelCotConfiguracion,
                    		'imagen1' => $imagen1));
                        Yii::app()->end();
                    }
                }
            }

            // Validación edición
            else
            {
                if(Yii::app()->session['rol_usuario']== 'admin')
                    $modelCotConfiguracion= CotConfiguracion::model()->find('conf_general=1');

                else
                    $modelCotConfiguracion=  CotConfiguracion::model()->findByPk($configuracionExistente['id_usuario']);
                
                $modelCotConfiguracion->attributes = $_POST['CotConfiguracion'];
                $modelCotConfiguracion->logo = $_POST['hiddenImg1'];
                $modelCotConfiguracion->id_usuario = $configuracionExistente['id_usuario'];
                if($modelCotConfiguracion->validate())
                {
                    if($modelCotConfiguracion->save())
                    {
                        $imagen1= $_POST['hiddenImg1'];
                        Yii::app()->user->setFlash('contact','Configuración editada con éxito!');
                        $this->controller->render('configurarDatos',array('model'=>$modelCotConfiguracion,
                            'imagen1' => $imagen1));
                        Yii::app()->end();
                    }
                }
            }
        }

        $this->controller->render("configurarDatos", 
        	array('model'=> $modelCotConfiguracion,'imagen1' => $imagen1, 'input1' => $input1));
        Yii::app()->end();
    }
}
?>
