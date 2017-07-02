<?php
class actionSeleccionProductos extends CAction {

    public function run() 
    {
        Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = false;
    
        if(isset($_POST['id_cotizacion']))
        {
            //Condición para cambiar cantidad de producto
            if(isset($_POST["cantidadModificada"]))
            {
                $modelCotTmp=  CotCotizaciontmp::model()->findByPk($_POST['id_cotizacion']);
                if($modelCotTmp->precio_modificado != NULL)
                    $precioMultiplicado= $modelCotTmp->precio_modificado * $_POST["cantidadModificada"];

                else
                    $precioMultiplicado= $modelCotTmp->precio_unitario * $_POST["cantidadModificada"];

                $modelCotTmp->cantidad_tmp= $_POST["cantidadModificada"];
                $modelCotTmp->precio_tmp= $precioMultiplicado;
                $modelCotTmp->save();
                Yii::app()->end();
            }

            //Condición para cambiar nombre del producto
            elseif(isset($_POST['nombreModificado'])) 
            {
                $modelCotTmp=  CotCotizaciontmp::model()->findByPk($_POST['id_cotizacion']);
                if($_POST["nombreModificado"]!= NULL)
                {
                    $modelCotTmp->nombre= strtoupper($_POST["nombreModificado"]);  
                    $modelCotTmp->save();
                    Yii::app()->end();
                }
            }

            //Condición para cambiar el precio
            else
            {
                // Por precio modificado
                if(isset($_POST['precioModificado']))
                {
                    $modelCotTmp=  CotCotizaciontmp::model()->findByPk($_POST['id_cotizacion']);
                    $precioModificadoSinIva= number_format($_POST["precioModificado"]/1.16, 4, '.', '');
                    $nuevoPrecioUnitario= $modelCotTmp->cantidad_tmp * $precioModificadoSinIva;
                    $modelCotTmp->precio_tmp= $nuevoPrecioUnitario;
                    $modelCotTmp->precio_modificado= $precioModificadoSinIva;
                    $modelCotTmp->porcentaje= NULL;
                    
                    if($_POST['precioSel']== 1)
                        $modelCotTmp->selected_price= $_POST['precioModificado'];

                    else
                        $modelCotTmp->selected_price= "";

                    $modelCotTmp->save();
                    Yii::app()->end();
                }

                // Por porcentaje
                else{
                    $modelCotTmp=  CotCotizaciontmp::model()->findByPk($_POST['id_cotizacion']);

                    $xinicial= $modelCotTmp->precio_unitario;
                    $n= $_POST['porcentajeModificado']; 

                    $precioModificadoSinIva= $xinicial + (($n/100) * $xinicial);
                    $precioModificadoSinIva= number_format($precioModificadoSinIva, 4, '.', '');
                    $precioPorCantidad= $modelCotTmp->cantidad_tmp * $precioModificadoSinIva;
                    $modelCotTmp->precio_tmp= $precioPorCantidad;
                    $modelCotTmp->precio_modificado= $precioModificadoSinIva;
                    $modelCotTmp->porcentaje= $n;
                    $modelCotTmp->save();
                    Yii::app()->end();
                }
            }
        }

        //Agregar nuevo producto a la cotización o porcentaje global
        else
        {
            // Porcentaje global
            if($_POST["porcentajeGlobal"]== 1)
            {
                for ($i=0; $i < sizeof($_POST["arrayIdCotizaciones"]); $i++) { 
                    $modelCotTmp=  CotCotizaciontmp::model()->findByPk($_POST["arrayIdCotizaciones"][$i]);

                    $xinicial= $modelCotTmp->precio_unitario;
                    $n= $_POST["cantidadPorcentaje"]; 

                    $precioModificadoSinIva= $xinicial + (($n/100) * $xinicial);
                    $precioModificadoSinIva= number_format($precioModificadoSinIva, 4, '.', '');
                    $precioPorCantidad= $modelCotTmp->cantidad_tmp * $precioModificadoSinIva;
                    $modelCotTmp->precio_tmp= $precioPorCantidad;
                    $modelCotTmp->precio_modificado= $precioModificadoSinIva;
                    $modelCotTmp->porcentaje= $n;
                    $modelCotTmp->save();
                }
                Yii::app()->end(); 
            }

            // Agregar nuevo producto
            else
            {
                $id_producto= $_GET['id_producto']; 
                $precio= $_GET['precio'];
                $cantidad= $_GET['cantidad'];

                $cotizacionId = Yii::app()->db->createCommand()
                    ->select('id')->from('cot_cotizacion')
                    ->where('token = :token', array(':token'=>$_GET['token']))->queryRow();

                if(isset($id_producto))
                {    
                    $modelCotTmp =  new CotCotizaciontmp;  
                    $producto = Yii::app()->db->createCommand()
                        ->select('precio_prov, reference')->from('ps_product')
                        ->where('id_product = :idp', array(':idp'=>$id_producto))->queryRow();

                    $modelCotTmp->id_producto= $id_producto;
                    $modelCotTmp->cantidad_tmp= $cantidad; 
                    $modelCotTmp->id_cotizacion= $cotizacionId["id"]; 

                    if(Yii::app()->session['rol_usuario']== 'admin'){
                        if($cantidad > 1)         
                            $modelCotTmp->precio_tmp= $producto['precio_prov'] * $cantidad; 
                        else
                            $modelCotTmp->precio_tmp= $producto['precio_prov'];
                        $modelCotTmp->precio_unitario= $producto['precio_prov'];
                    }

                    else
                    {
                        if($cantidad > 1)         
                            $modelCotTmp->precio_tmp= $precio * $cantidad; 
                        else
                            $modelCotTmp->precio_tmp= $precio;
                        $modelCotTmp->precio_unitario= $precio;
                        $modelCotTmp->selected_price= $precio*1.16;
                    }

                    $modelCotTmp->nombre= $modelCotTmp->product->lang->name;
                    $modelCotTmp->id_original_producto= $producto['reference'];
                    $modelCotTmp->precio_prov= $producto['precio_prov'];
                    if($modelCotTmp->validate())
                        $modelCotTmp->save();
                    else
                    {
                        echo "<pre>";
                        print_r($modelCotTmp->getErrors());
                        echo "</pre>"; 
                        exit;
                    }
                    Yii::app()->end();
                }
            }
        }
    }
}
