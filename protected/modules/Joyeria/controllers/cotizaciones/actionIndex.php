<?php
//COTIZACIONES
class actionIndex extends CAction {

    public function run() 
    {
        $baseUrl= Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/js/smoke.js');
        $cs->registerCssFile($baseUrl.'/css/smoke.css');
        $cs->registerScriptFile($baseUrl.'/js/jBlockUi.js');
        //Crear cotización
        if(isset($_GET['token'])) {
            $tokenExistente = Yii::app()->db->createCommand()
                ->select('token')
                ->from('cot_cotizacion')
                ->where('token = :token', array(':token'=>$_GET['token']))
                ->queryRow();

            if($tokenExistente== false){
                //Se crea una cotización con estructura cero
                $modelCotizacion=new CotCotizacion();
                $modelCotizacion->fecha_cotizacion= date("Y-m-d");
                $modelCotizacion->token= $_GET['token'];
                $modelCotizacion->id_usuario= Yii::app()->user->getId();
                $modelCotizacion->observaciones= 'a) Cotización moneda Nacional b) Tiempo de entrega c) Precios pueden variar sin previo aviso';
                $modelCotizacion->nombre_cliente= '';
                $modelCotizacion->tel1= '';
                $modelCotizacion->email= '';
                $modelCotizacion->empresa= '';
                $modelCotizacion->ejecutivo= '';
                $modelCotizacion->clave_cotizacion= "";
                $modelCotizacion->save(false);
                
                $modelCotizacion->clave_cotizacion= "C-".$modelCotizacion->id;
                $modelCotizacion->save(false);

                $modelCotTmp=new CotCotizaciontmp('search');
                $modelCotTmp->id_cotizacion= $modelCotizacion->id;
                if(isset($_GET['CotCotizaciontmp']))
                $modelCotTmp->attributes=$_GET['CotCotizaciontmp'];

                $modelProductos=new PsProduct('search');
                $modelProductos->unsetAttributes();  
                $modelProductos->active= 1;

                if(isset($_GET['PsProduct']))
                    $modelProductos->attributes=$_GET['PsProduct'];
            } else{
                $modelCotizacion= CotCotizacion::model()->find("token=?", array($_GET['token']));

                $modelCotTmp=new CotCotizaciontmp('search');
                $modelCotTmp->id_cotizacion= $modelCotizacion->id;
                if(isset($_GET['CotCotizaciontmp']))
                    $modelCotTmp->attributes=$_GET['CotCotizaciontmp'];

                $modelProductos=new PsProduct('search');
                $modelProductos->unsetAttributes();  

                if(isset($_GET['PsProduct']))
                    $modelProductos->attributes=$_GET['PsProduct'];

                if(isset($_GET['guardar'])){
                    if($modelCotizacion->validate()){
                        if($modelCotizacion->save()){ 
                            
                            $helper= new Helper();
                            /*Guardar Cotización en SL - start*/
                            //Condición para sólo guardar la cot en SL si el rol es Admin o Vendedor
                            if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor'){
                                $helper->guardarCotizacionLocal($modelCotizacion);
                            }  
                            /*Guardar Cotización en SL - end*/

                            if(isset($_GET['token']) ){
                                $resultado_pdf= $helper->generarPDF($_GET['token'], null, 1, null, null, $modelCotizacion);
                            }

                            if($resultado_pdf)
                                $mensaje= 'Cotización guardada con éxito!';
                            else
                                $mensaje= 'Cotización guardada pero el PDF no pudo ser generado';

                            $resultado= array('error'=> 0, 'mensaje'=> $mensaje);

                            echo CJSON::encode($resultado);
                            Yii::app()->end();         
                        }  
                    } else{
                        $resultado= array('error'=> 1, 'mensaje'=> 'Los Datos del Cliente no han sido capturados y son requeridos');

                        echo CJSON::encode($resultado);
                        Yii::app()->end();
                    }
                }
            }

            $modelCotizacion->ejecutivo= $modelCotizacion->idUsuario->nombre_personal;
            $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos));
            Yii::app()->end();
        }

        //Editar Cotización
        if(isset($_GET['id'])){
            $modelCotizacion= CotCotizacion::model()->findByPk($_GET['id']);   

            $modelCotTmp=new CotCotizaciontmp('search');
            $modelCotTmp->id_cotizacion= $modelCotizacion->id;
            if(isset($_GET['CotCotizaciontmp']))
                $modelCotTmp->attributes= $_GET['CotCotizaciontmp'];

            $modelProductos=new PsProduct('search');
            $modelProductos->unsetAttributes();  
            $diasVigencia= $this->controller->dias_vigencia($modelCotizacion->fecha_cotizacion, $modelCotizacion->fecha_validez);

            if(isset($_POST['CotCotizacion'])){ //--- va guiardar
                $modelCotizacion->attributes = $_POST['CotCotizacion'];
           
                if($modelCotizacion->validate()){
                    if($modelCotizacion->save() ){

                        $helper= new Helper();
                        /*Guardar Cotización en SL - start*/
                        //Condición para sólo guardar la cot en SL si el rol es Admin o Vendedor
                        if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor'){
                            $helper->guardarCotizacionLocal($modelCotizacion);
                        }  
                        /*Guardar Cotización en SL - end*/

                        $resultado_pdf= 0;
                        if(isset($_GET['tokenEdt']) ){
                            $resultado_pdf= $helper->generarPDF(null, $_GET['tokenEdt'], 1, null, null, $modelCotizacion);
                        }

                        if($resultado_pdf)
                            $mensaje= 'Cotización guardada con éxito!';
                        else
                            $mensaje= 'Cotización guardada pero el PDF no pudo ser generado';

                        $resultado= array('error'=> 0, 'mensaje'=> $mensaje);
                        echo CJSON::encode($resultado);
                        Yii::app()->end();  
                    }       
                } else{
                    $resultado= array('error'=> 1, 'mensaje'=> 'Los Datos del Cliente no son válidos, verifique');

                    echo CJSON::encode($resultado);
                    Yii::app()->end();
                }
            }
            
            $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'validez'=> $diasVigencia));
            Yii::app()->end();
        }
    }
}