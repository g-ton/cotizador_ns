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
        if(isset($_GET['token'])) 
        {
            $tokenExistente = Yii::app()->db->createCommand()
                ->select('token')
                ->from('cot_cotizacion')
                ->where('token = :token', array(':token'=>$_GET['token']))
                ->queryRow();

            if($tokenExistente== false)
            {
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
            }

            else
            {
                $modelCotizacion= CotCotizacion::model()->find("token=?", array($_GET['token']));


                $modelCotTmp=new CotCotizaciontmp('search');
                $modelCotTmp->id_cotizacion= $modelCotizacion->id;
                if(isset($_GET['CotCotizaciontmp']))
                    $modelCotTmp->attributes=$_GET['CotCotizaciontmp'];

                $modelProductos=new PsProduct('search');
                $modelProductos->unsetAttributes();  

                if(isset($_GET['PsProduct']))
                    $modelProductos->attributes=$_GET['PsProduct'];

                if(isset($_POST['CotCotizacion']))
                {

                    $modelCotizacion->attributes = $_POST['CotCotizacion'];

                    if($modelCotizacion->validate()){
                        if($modelCotizacion->save()){ 
                            /*Guardar Cotización en SL - start*/
                            //Condición para sólo guardar la cot en SL si el rol es Admin o Vendedor
                            if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
                            {
                                $modelCotizacion->id_original_personal= Yii::app()->session['id_personal_sl'];
                                if(isset($_POST['CotCotizacion']['id_original_cliente']))
                                {
                                    $idCliente= $_POST['CotCotizacion']['id_original_cliente'];
                                    
                                    //Cotización Pionera SL
                                    $modelSlCot= SlCotizaciones::model()->find("cot_web=?", array($modelCotizacion->id));
                                    if($modelSlCot=== NULL)
                                    {
                                        if($idCliente!== NULL)
                                        {
                                            $modelCotizacion->id_original_cliente= $idCliente;
                                            $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
                                            $modelSlCotizaciones= new SlCotizaciones();
                                            $modelSlCotizaciones->fecha= Date('Y-m-d');
                                            $modelSlCotizaciones->hora=  Date('h:i:s');
                                            $modelSlCotizaciones->id_cliente= $idCliente;
                                            $modelSlCotizaciones->id_personal= $modelCotizacion->id_original_personal;
                                            $modelSlCotizaciones->tc= $modelCambioDolar->importe_pesos;
                                            $modelSlCotizaciones->iva= 16.00;
                                            $modelSlCotizaciones->cot_web= $modelCotizacion->id;
                                            if($modelSlCotizaciones->validate())
                                            {
                                                $modelSlCotizaciones->save();

                                                /*Guardar Cotización desc SL*/
                                                $productosCotizacion = Yii::app()->db->createCommand()
                                                ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
                                                ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
                                                $j= 1;
                                                foreach ($productosCotizacion as $iter => $productoCotizacion) 
                                                {
                                                    $modelSlCotizacionesDesc= new SlCotizacionesDesc();
                                                    $modelSlCotizacionesDesc->folio_cotizacion= $modelSlCotizaciones->folio_cotizacion;
                                                    $modelSlCotizacionesDesc->partida= $j;
                                                    $modelSlCotizacionesDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                                    $modelSlCotizacionesDesc->id_producto= $productoCotizacion['id_original_producto'];
                                                    $modelSlCotizacionesDesc->precio_prov= $productoCotizacion['precio_prov'];
                                                    if($productoCotizacion['precio_modificado']!== NULL)
                                                        $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                                    else
                                                    $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                                    $productoPs = Yii::app()->db->createCommand()
                                                    ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                                    ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                                   
                                                    if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                        $modelSlCotizacionesDesc->tipo_precio= 1;
                                                    
                                                    if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                        $modelSlCotizacionesDesc->tipo_precio= 2;
                                        
                                                    elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                        $modelSlCotizacionesDesc->tipo_precio= 3;

                                                    //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
             
                                                    $modelSlCotizacionesDesc->cot_web= $modelCotizacion->id;
                                                    $modelSlCotizacionesDesc->save();
                                                    $j++;
                                                }
                                            }
                                        }
                                    }

                                    //Cotización Heredada SL
                                    else
                                    {
                                        if($idCliente!== NULL)
                                        {
                                            $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
                                            $modelSlCot->fecha= Date('Y-m-d');
                                            $modelSlCot->hora=  Date('h:i:s');
                                            $modelSlCot->id_cliente= $idCliente;
                                            $modelSlCot->tc= $modelCambioDolar->importe_pesos;
                                            if($modelSlCot->validate())
                                            {
                                                $modelSlCot->save();

                                                /*Guardar Cotización desc SL*/
                                                $productosCotizacion = Yii::app()->db->createCommand()
                                                ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
                                                ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
                                                $j= 1;
                                                foreach ($productosCotizacion as $iter => $productoCotizacion) 
                                                {
                                                    $modelSlCotDesc= SlCotizacionesDesc::model()->find("cot_web=? AND id_producto=?", 
                                                        array($modelCotizacion->id, $productoCotizacion['id_original_producto']));

                                                    //Cotización Desc Pionera SL
                                                    if($modelSlCotDesc=== NULL)
                                                    {
                                                       
                                                        $modelSlCotizacionesDesc= new SlCotizacionesDesc();
                                                        $modelSlCotizacionesDesc->folio_cotizacion= $modelSlCot->folio_cotizacion;
                                                        $modelSlCotizacionesDesc->partida= $j;
                                                        $modelSlCotizacionesDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                                        $modelSlCotizacionesDesc->id_producto= $productoCotizacion['id_original_producto'];
                                                        $modelSlCotizacionesDesc->precio_prov= $productoCotizacion['precio_prov'];
                                                        if($productoCotizacion['precio_modificado']!== NULL)
                                                            $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                                        else
                                                            $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                                        $productoPs = Yii::app()->db->createCommand()
                                                        ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                                        ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                                       
                                                        if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                            $modelSlCotizacionesDesc->tipo_precio= 1;
                                                        
                                                        if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                            $modelSlCotizacionesDesc->tipo_precio= 2;
                                            
                                                        elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                            $modelSlCotizacionesDesc->tipo_precio= 3;

                                                        //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
                 
                                                        $modelSlCotizacionesDesc->cot_web= $modelCotizacion->id;
                                                        $modelSlCotizacionesDesc->save(); 
                                                    }

                                                    //Cotización Desc Heredada SL
                                                    else
                                                    {
                                                       
                                                        $modelSlCotDesc->partida= $j;
                                                        $modelSlCotDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                                        $modelSlCotDesc->precio_prov= $productoCotizacion['precio_prov'];
                                                        if($productoCotizacion['precio_modificado']!== NULL)
                                                            $modelSlCotDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                                        else
                                                            $modelSlCotDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                                        $productoPs = Yii::app()->db->createCommand()
                                                        ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                                        ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                                       
                                                        if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                            $modelSlCotDesc->tipo_precio= 1;
                                                        
                                                        if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                            $modelSlCotDesc->tipo_precio= 2;
                                            
                                                        elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                            $modelSlCotDesc->tipo_precio= 3;

                                                        //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
                 
                                                        $modelSlCotDesc->save();
                                                    }
                                                    $j++;
                                                }

                                                /*Borrado de productos en SL - start*/
                                                //Se borran productos de la cotización en sistema local si en el cotizador fueron eliminados
                                                $arrayComparativoCotDesc= array();
                                                $arrayComparativoProdCot= array();
                                                $arrayComparativoCotDescAux = Yii::app()->db1->createCommand()
                                                        ->select('id_producto')->from('cotizaciones_desc')
                                                        ->where('cot_web=:cb', array(':cb'=> $modelCotizacion->id))->queryAll(); 
                                                foreach ($arrayComparativoCotDescAux as $value) {
                                                    $arrayComparativoCotDesc[] = $value['id_producto'];
                                                }
                                                foreach ($productosCotizacion as $value) {
                                                    $arrayComparativoProdCot[] = $value['id_original_producto'];
                                                }

                                                $diferencias = array_diff($arrayComparativoCotDesc, $arrayComparativoProdCot);
                                                if(count($diferencias)> 0)
                                                {
                                                    foreach ($diferencias as $key => $diferencia) {
                                                        $sql= "DELETE FROM cotizaciones_desc WHERE cot_web=" .$modelCotizacion->id. " AND id_producto=" ."'".$diferencia."'";
                                                        Yii::app()->db1->createCommand($sql)->execute();
                                                    }
                                                }
                                                /*Borrado de productos en SL - end*/
                                            }
                                        }
                                    }
                                }

                            }  
                            /*Guardar Cotización en SL - end*/

                            $modelCotizacion->activo= 1;
                            $fecha = date('Y-m-j');
                            if($_POST['diasValidez']== '')
                                $_POST['diasValidez']= 7;
                            $nuevafecha = strtotime ($_POST['diasValidez'].' day', strtotime($fecha)) ;
                            $modelCotizacion->fecha_validez = date ( 'Y-m-j' , $nuevafecha );
                            $modelCotizacion->save();

                            if($_POST["button1"]== "Guardar")
                            {
                                //Generar y guardar PDF de la Cotización
                                $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                                spl_autoload_register(array('YiiBase','autoload'));

                                $pdf->SetCreator(PDF_CREATOR);
                                $pdf->SetAuthor('J Damián');
                                $pdf->SetTitle('TCPDF Example 051');
                                $pdf->SetSubject('TCPDF Tutorial');
                                $pdf->SetKeywords('Cotización, PDF, Nsstore');

                                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                                $pdf->SetHeaderMargin(0);
                                $pdf->SetFooterMargin(0);

                                $pdf->setPrintFooter(false);
                                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                                $pdf->AddPage();

                                // Si la configuración del usuario existe se coloca el logo de su empresa
                                if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
                                {
                                    $datosUsuario = Yii::app()->db->createCommand()
                                        ->select('logo, razon_social')->from('cot_configuracion')
                                        ->where('conf_general = :cong', array(':cong'=>1))->queryRow();  
                                }

                                else
                                {
                                    $datosUsuario = Yii::app()->db->createCommand()
                                        ->select('logo, razon_social')->from('cot_configuracion')
                                        ->where('id_usuario = :us', array(':us'=>Yii::app()->user->getId()))
                                        ->queryRow();
                                }

                                if($datosUsuario!= false){
                                    $image_file = $datosUsuario['logo'];
                                    // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
                                    $pdf->Image($image_file, 5, 8, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                                }

                                $idCotizacionGral = Yii::app()->db->createCommand()
                                    ->select('id, nombre_cliente, fecha_cotizacion, fecha_validez, email, clave_cotizacion, cargo, observaciones')
                                    ->from('cot_cotizacion')
                                    ->where('token = :token', array(':token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt']))
                                    ->queryRow();

                                $pdf->SetTextColor(64, 64, 64);
                                $pdf->SetFont('helvetica', 'B', 13);
                                $pdf->Cell(0, 0, "Cotización", 0, 1, 'R', false, '', 0);
                                
                                $pdf->SetTextColor(153, 153, 153);
                                $pdf->SetFont('helvetica', 'B', 10);
                                $pdf->Cell(0, 5, $idCotizacionGral['fecha_cotizacion'], 0, 1, 'R', false, '', 0);
                                
                                $pdf->SetTextColor(51, 51, 51);
                                $pdf->Cell(0, 5, "FOLIO: ".$idCotizacionGral['clave_cotizacion'], 0, 1, 'R', false, '', 0);
                                
                                $pdf->Ln(8);

                                $pdf->SetFont('helvetica', '', 7);
                                $htmlAttributes= '<hr />';
                                $pdf->writeHTML($htmlAttributes, true, false, true, false, '');

                                $htmlAttributes1= '<table style="width:100%">
                                    <tr>
                                        <td><b>FECHA:</b> '.$idCotizacionGral['fecha_cotizacion'].'</td>
                                        <td><b>CLAVE:</b> '.$idCotizacionGral['id_original_cliente'].'</td>
                                        <td><b>CLIENTE:</b> '.$idCotizacionGral['nombre_cliente'].'</td>
                                    </tr>
                                    <tr>
                                        <td><b>TELÉFONO:</b> '.$idCotizacionGral['tel1'].'</td>
                                        <td><b>E-MAIL:</b> '.$idCotizacionGral['email'].'</td>
                                        <td><b>CARGO:</b> '.$idCotizacionGral['cargo'].'</td>
                                    </tr>
                                </table>';
                                $pdf->writeHTML($htmlAttributes1, true, false, true, false, '');
                                
                                $pdf->SetTextColor(51, 51, 51);
                                $pdf->SetFont('helvetica', '', 7);
                                $pdf->Ln(10);

                                $header = array("Producto", 'Cantidad', 'Precio Unitario', 'Precio Total');
                                if($idCotizacionGral!= false)
                                {
                                    $data = Yii::app()->db->createCommand()
                                        ->select('cantidad_tmp, precio_unitario, precio_modificado, precio_tmp, nombre')
                                        ->from('cot_cotizaciontmp')
                                        ->where('id_cotizacion=:id_cotizacion', array(':id_cotizacion'=>$idCotizacionGral['id']))
                                        ->queryAll();
                                }

                                $pdf->ColoredTable($header, $data);

                                $pdf->Ln(10);
                                //Observaciones
                                $pdf->SetFont('helvetica', '', 7);
                                $pdf->SetAlpha(0.5);
                                $pdf->SetFillColor(246, 246, 246);
                                $pdf->SetDrawColor(215, 217, 219);
                                $diasVigencia= $this->controller->dias_vigencia($idCotizacionGral['fecha_cotizacion'], $idCotizacionGral['fecha_validez']);
                                $pdf->writeHTMLCell(120, '', '', '', "<p><strong>Términos y Condiciones</strong><p>".nl2br($idCotizacionGral['observaciones'])." * Vigencia cotización ".$diasVigencia." días", 1, 1, 1, true, 'J', false);
                                $pdf->SetAlpha(1);

                                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                                $pdf->setPrintFooter();

                                $pdf->Output($_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf', 'F');
                                $modelCotizacion->rutaArchivo= $_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf';
                                $modelCotizacion->save();
                                //------------
                            }
                            Yii::app()->user->setFlash('contact','Cotización guardada con éxito!');
                            $validez= $_POST['diasValidez'];
                            $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                                'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'mostrarBtn'=>1, 'validez'=> $validez));
                            Yii::app()->end();         
                        }  
                    }

                    else
                    {
                        if( isset($_POST['diasValidez']) )
                            $validez= $_POST['diasValidez'];
                        else
                            $validez= 7;

                        $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                            'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'validez'=> $validez));
                        Yii::app()->end();
                    }
                }
            }
            $validez= 7;
            $modelCotizacion->ejecutivo= $modelCotizacion->idUsuario->nombre_personal;
            $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'validez'=> $validez));
            Yii::app()->end();
        }

        //Editar Cotización
        if(isset($_GET['id']))
        {
            $modelCotizacion= CotCotizacion::model()->findByPk($_GET['id']);   

            $modelCotTmp=new CotCotizaciontmp('search');
            $modelCotTmp->id_cotizacion= $modelCotizacion->id;
            if(isset($_GET['CotCotizaciontmp']))
                $modelCotTmp->attributes= $_GET['CotCotizaciontmp'];

            $modelProductos=new PsProduct('search');
            $modelProductos->unsetAttributes();  
            $diasVigencia= $this->controller->dias_vigencia($modelCotizacion->fecha_cotizacion, $modelCotizacion->fecha_validez);

            if(isset($_POST['CotCotizacion']))
            {
                $modelCotizacion->attributes = $_POST['CotCotizacion'];
           
                if($modelCotizacion->validate())
                {
                    $modelCotizacion->activo= 1;
                    $fecha = date('Y-m-j');
                    if($_POST['diasValidez']== '')
                        $_POST['diasValidez']= 7;
                    $nuevafecha = strtotime ($_POST['diasValidez'].' day', strtotime($fecha)) ;
                    $modelCotizacion->fecha_validez = date ('Y-m-j' , $nuevafecha);
                    $modelCotizacion->save();

                    /*Guardar Cotización en SL - start*/
                    //Condición para sólo guardar la cot en SL si el rol es Admin o Vendedor
                    if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
                    {
                        $modelCotizacion->id_original_personal= Yii::app()->session['id_personal_sl'];
                        if(isset($_POST['CotCotizacion']['id_original_cliente']))
                        {
                            $idCliente= $_POST['CotCotizacion']['id_original_cliente'];
                            
                            //Cotización Pionera SL
                            $modelSlCot= SlCotizaciones::model()->find("cot_web=?", array($modelCotizacion->id));
                            if($modelSlCot=== NULL)
                            {
                                if($idCliente!== NULL)
                                {
                                    $modelCotizacion->id_original_cliente= $idCliente;
                                    $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
                                    $modelSlCotizaciones= new SlCotizaciones();
                                    $modelSlCotizaciones->fecha= Date('Y-m-d');
                                    $modelSlCotizaciones->hora=  Date('h:i:s');
                                    $modelSlCotizaciones->id_cliente= $idCliente;
                                    $modelSlCotizaciones->id_personal= $modelCotizacion->id_original_personal;
                                    $modelSlCotizaciones->tc= $modelCambioDolar->importe_pesos;
                                    $modelSlCotizaciones->iva= 16.00;
                                    $modelSlCotizaciones->cot_web= $modelCotizacion->id;
                                    if($modelSlCotizaciones->validate())
                                    {
                                        $modelSlCotizaciones->save();

                                        /*Guardar Cotización desc SL*/
                                        $productosCotizacion = Yii::app()->db->createCommand()
                                        ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
                                        ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
                                        $j= 1;
                                        foreach ($productosCotizacion as $iter => $productoCotizacion) 
                                        {
                                            $modelSlCotizacionesDesc= new SlCotizacionesDesc();
                                            $modelSlCotizacionesDesc->folio_cotizacion= $modelSlCotizaciones->folio_cotizacion;
                                            $modelSlCotizacionesDesc->partida= $j;
                                            $modelSlCotizacionesDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                            $modelSlCotizacionesDesc->id_producto= $productoCotizacion['id_original_producto'];
                                            $modelSlCotizacionesDesc->precio_prov= $productoCotizacion['precio_prov'];
                                            if($productoCotizacion['precio_modificado']!== NULL)
                                                $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                            else
                                                $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                            $productoPs = Yii::app()->db->createCommand()
                                            ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                            ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                           
                                            if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                $modelSlCotizacionesDesc->tipo_precio= 1;
                                            
                                            if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                $modelSlCotizacionesDesc->tipo_precio= 2;
                                
                                            elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                $modelSlCotizacionesDesc->tipo_precio= 3;

                                            //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
     
                                            $modelSlCotizacionesDesc->cot_web= $modelCotizacion->id;
                                            $modelSlCotizacionesDesc->save();
                                            $j++;
                                        }
                                    }
                                }
                            }

                            //Cotización Heredada SL
                            else
                            {
                                if($idCliente!== NULL)
                                {
                                    $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
                                    $modelSlCot->fecha= Date('Y-m-d');
                                    $modelSlCot->hora=  Date('h:i:s');
                                    $modelSlCot->id_cliente= $idCliente;
                                    $modelSlCot->tc= $modelCambioDolar->importe_pesos;
                                    if($modelSlCot->validate())
                                    {
                                        $modelSlCot->save();

                                        /*Guardar Cotización desc SL*/
                                        $productosCotizacion = Yii::app()->db->createCommand()
                                        ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
                                        ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
                                        $j= 1;
                                        foreach ($productosCotizacion as $iter => $productoCotizacion) 
                                        {
                                            $modelSlCotDesc= SlCotizacionesDesc::model()->find("cot_web=? AND id_producto=?", 
                                                array($modelCotizacion->id, $productoCotizacion['id_original_producto']));

                                            //Cotización Desc Pionera SL
                                            if($modelSlCotDesc=== NULL)
                                            {
                                                $modelSlCotizacionesDesc= new SlCotizacionesDesc();
                                                $modelSlCotizacionesDesc->folio_cotizacion= $modelSlCot->folio_cotizacion;
                                                $modelSlCotizacionesDesc->partida= $j;
                                                $modelSlCotizacionesDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                                $modelSlCotizacionesDesc->id_producto= $productoCotizacion['id_original_producto'];
                                                $modelSlCotizacionesDesc->precio_prov= $productoCotizacion['precio_prov'];
                                                if($productoCotizacion['precio_modificado']!== NULL)
                                                    $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                                else
                                                    $modelSlCotizacionesDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                                $productoPs = Yii::app()->db->createCommand()
                                                ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                                ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                               
                                                if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                    $modelSlCotizacionesDesc->tipo_precio= 1;
                                                
                                                if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                    $modelSlCotizacionesDesc->tipo_precio= 2;
                                    
                                                elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                    $modelSlCotizacionesDesc->tipo_precio= 3;

                                                //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
         
                                                $modelSlCotizacionesDesc->cot_web= $modelCotizacion->id;
                                                $modelSlCotizacionesDesc->save();
                                            }

                                            //Cotización Desc Heredada SL
                                            else
                                            {
                                                $modelSlCotDesc->partida= $j;
                                                $modelSlCotDesc->cantidad= $productoCotizacion['cantidad_tmp'];
                                                $modelSlCotDesc->precio_prov= $productoCotizacion['precio_prov'];
                                                if($productoCotizacion['precio_modificado']!== NULL)
                                                    $modelSlCotDesc->precio_unitario= number_format($productoCotizacion['precio_modificado'], 2, '.', '');
                                                else
                                                    $modelSlCotDesc->precio_unitario= number_format($productoCotizacion['precio_unitario'], 2, '.', '');

                                                $productoPs = Yii::app()->db->createCommand()
                                                ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
                                                ->where('reference=:rf', array(':rf'=> $productoCotizacion['id_original_producto']))->queryRow(); 
                                               
                                                if($productoCotizacion['selected_price']== $productoPs['precio_lista'])
                                                    $modelSlCotDesc->tipo_precio= 1;
                                                
                                                if($productoCotizacion['selected_price']== $productoPs['precio_mm'])
                                                    $modelSlCotDesc->tipo_precio= 2;
                                    
                                                elseif($productoCotizacion['selected_price']== $productoPs['precio_mayoreo'])
                                                    $modelSlCotDesc->tipo_precio= 3;

                                                //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)
         
                                                $modelSlCotDesc->save();
                                            }
                                            $j++;
                                        }

                                        /*Borrado de productos en SL - start*/
                                        //Se borran productos de la cotización en sistema local si en el cotizador fueron eliminados
                                        $arrayComparativoCotDesc= array();
                                        $arrayComparativoProdCot= array();
                                        $arrayComparativoCotDescAux = Yii::app()->db1->createCommand()
                                                ->select('id_producto')->from('cotizaciones_desc')
                                                ->where('cot_web=:cb', array(':cb'=> $modelCotizacion->id))->queryAll(); 
                                        foreach ($arrayComparativoCotDescAux as $value) {
                                            $arrayComparativoCotDesc[] = $value['id_producto'];
                                        }
                                        foreach ($productosCotizacion as $value) {
                                            $arrayComparativoProdCot[] = $value['id_original_producto'];
                                        }

                                        $diferencias = array_diff($arrayComparativoCotDesc, $arrayComparativoProdCot);
                                        if(count($diferencias)> 0)
                                        {
                                            foreach ($diferencias as $key => $diferencia) {
                                                $sql= "DELETE FROM cotizaciones_desc WHERE cot_web=" .$modelCotizacion->id. " AND id_producto=" ."'".$diferencia."'";
                                                Yii::app()->db1->createCommand($sql)->execute();
                                            }
                                        }
                                        /*Borrado de productos en SL - end*/
                                    }
                                }
                            }
                        }
                    }  
                    /*Guardar Cotización en SL - end*/

                    if($_POST["button1"]== "Guardar")
                    {
                        //Generar y guardar PDF de la Cotización
                        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                        spl_autoload_register(array('YiiBase','autoload'));

                        $pdf->SetCreator(PDF_CREATOR);
                        $pdf->SetAuthor('Nicola Asuni');
                        $pdf->SetTitle('TCPDF Example 051');
                        $pdf->SetSubject('TCPDF Tutorial');
                        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
                        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                        $pdf->SetHeaderMargin(0);
                        $pdf->SetFooterMargin(0);

                        $pdf->setPrintFooter(false);
                        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                        $pdf->SetFont('helvetica', '', 8);
                        $pdf->AddPage();

                        // Si la configuración del usuario existe se coloca el logo de su empresa
                        $datosUsuario = Yii::app()->db->createCommand()
                            ->select('logo')->from('cot_configuracion')
                            ->where('id_usuario = :us', array(':us'=>Yii::app()->user->getId()))
                            ->queryRow();
                        if($datosUsuario!= false){
                            $image_file = $datosUsuario['logo'];
                            // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)
                            $pdf->Image($image_file, 5, 8, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                        }

                        $idCotizacionGral = Yii::app()->db->createCommand()
                            ->select('id, nombre_cliente, fecha_cotizacion, fecha_validez, email, clave_cotizacion, cargo, observaciones')
                            ->from('cot_cotizacion')
                            ->where('token = :token', array(':token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt']))
                            ->queryRow();

                         $pdf->SetTextColor(64, 64, 64);
                        $pdf->SetFont('helvetica', 'B', 13);
                        $pdf->Cell(0, 0, "Cotización", 0, 1, 'R', false, '', 0);
                        
                        $pdf->SetTextColor(153, 153, 153);
                        $pdf->SetFont('helvetica', 'B', 10);
                        $pdf->Cell(0, 5, $idCotizacionGral['fecha_cotizacion'], 0, 1, 'R', false, '', 0);
                        
                        $pdf->SetTextColor(51, 51, 51);
                        $pdf->Cell(0, 5, "FOLIO: ".$idCotizacionGral['clave_cotizacion'], 0, 1, 'R', false, '', 0);
                        
                        $pdf->Ln(8);

                        $pdf->SetFont('helvetica', '', 7);
                        $htmlAttributes= '<hr />';
                        $pdf->writeHTML($htmlAttributes, true, false, true, false, '');

                        $htmlAttributes1= '<table style="width:100%">
                            <tr>
                                <td><b>FECHA:</b> '.$idCotizacionGral['fecha_cotizacion'].'</td>
                                <td><b>CLAVE:</b> '.$idCotizacionGral['id_original_cliente'].'</td>
                                <td><b>CLIENTE:</b> '.$idCotizacionGral['nombre_cliente'].'</td>
                            </tr>
                            <tr>
                                <td><b>TELÉFONO:</b> '.$idCotizacionGral['tel1'].'</td>
                                <td><b>E-MAIL:</b> '.$idCotizacionGral['email'].'</td>
                                <td><b>CARGO:</b> '.$idCotizacionGral['cargo'].'</td>
                            </tr>
                        </table>';
                        $pdf->writeHTML($htmlAttributes1, true, false, true, false, '');

                        $pdf->SetTextColor(51, 51, 51);
                        $pdf->SetFont('helvetica', '', 7);
                        $pdf->Ln(10);

                        $header = array("Producto", 'Cantidad', 'Precio Unitario', 'Precio Total');
                        if($idCotizacionGral!= false)
                        {
                            $data = Yii::app()->db->createCommand()
                                ->select('cantidad_tmp, precio_unitario, precio_modificado, precio_tmp, nombre')
                                ->from('cot_cotizaciontmp')
                                ->where('id_cotizacion=:id_cotizacion', array(':id_cotizacion'=>$idCotizacionGral['id']))
                                ->queryAll();
                        }

                        $pdf->ColoredTable($header, $data);

                        $pdf->Ln(10);
                        //Observaciones
                        $pdf->SetFont('helvetica', '', 7);
                        $pdf->SetAlpha(0.5);
                        $pdf->SetFillColor(246, 246, 246);
                        $pdf->SetDrawColor(215, 217, 219);
                        $diasVigencia= $this->controller->dias_vigencia($idCotizacionGral['fecha_cotizacion'], $idCotizacionGral['fecha_validez']);
                        $pdf->writeHTMLCell(120, '', '', '', "<p><strong>Términos y Condiciones</strong><p>".nl2br($idCotizacionGral['observaciones'])." * Vigencia cotización ".$diasVigencia." días", 1, 1, 1, true, 'J', false);
                        $pdf->SetAlpha(1);

                        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                        $pdf->setPrintFooter();

                        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf', 'F');
                        $modelCotizacion->rutaArchivo= $_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf';
                        $modelCotizacion->save();
                    }
                    Yii::app()->user->setFlash('contact','Cotización editada con éxito!');
                    $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                        'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'mostrarBtn'=>1, 'validez'=> $diasVigencia));
                    Yii::app()->end();           
                }
            }
            
            $this->controller->render('index',array('modelCotizacion'=>$modelCotizacion, 
                'modelCotTmp'=>$modelCotTmp, 'modelProductos'=>$modelProductos, 'validez'=> $diasVigencia));
            Yii::app()->end();
        }
    }
}