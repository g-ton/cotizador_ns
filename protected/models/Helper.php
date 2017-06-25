<?php

class Helper{
	
	//Guarda la cotización en el sistema local (Punto de venta Nsstore)
	function guardarCotizacionLocal($modelCotizacion){
		$modelCotizacion->id_original_personal= Yii::app()->session['id_personal_sl'];
	    if(isset($modelCotizacion->id_original_cliente) ){
	        $idCliente= $modelCotizacion->id_original_cliente;
	        
	        //Cotización Pionera SL
	        $modelSlCot= SlCotizaciones::model()->find("cot_web=?", array($modelCotizacion->id));
	        
	        if($modelSlCot=== NULL){
	            if($idCliente!== NULL){
	                $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
	                $modelSlCotizaciones= new SlCotizaciones();
	                $modelSlCotizaciones->fecha= Date('Y-m-d');
	                $modelSlCotizaciones->hora=  Date('h:i:s');
	                $modelSlCotizaciones->id_cliente= $idCliente;
	                $modelSlCotizaciones->id_personal= $modelCotizacion->id_original_personal;
	                $modelSlCotizaciones->tc= $modelCambioDolar->importe_pesos;
	                $modelSlCotizaciones->iva= SlCotizaciones::IVA;
	                $modelSlCotizaciones->cot_web= $modelCotizacion->id;
	                if($modelSlCotizaciones->validate()){
	                    $modelSlCotizaciones->save();

	                    /*Guardar Cotización desc SL*/
	                    $productosCotizacion = Yii::app()->db->createCommand()
	                    ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
	                    ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
	                    $j= 1;
	                    foreach ($productosCotizacion as $iter => $productoCotizacion) {
	                        $this->guardarCotizacionDesc($modelSlCotizaciones->folio_cotizacion, $productoCotizacion, $modelCotizacion->id, $j);
	                        $j++;
	                    }
	                }
	            }
	        }

	        //Cotización Heredada SL
	        else{
	            if($idCliente!== NULL){
	                $modelCambioDolar = SlCambioDolar::model()->lastRecord()->find();
	                $modelSlCot->fecha= Date('Y-m-d');
	                $modelSlCot->hora=  Date('h:i:s');
	                $modelSlCot->id_cliente= $idCliente;
	                $modelSlCot->tc= $modelCambioDolar->importe_pesos;
	                if($modelSlCot->validate()){
	                    $modelSlCot->save();

	                    /*Guardar Cotización desc SL*/
	                    $productosCotizacion = Yii::app()->db->createCommand()
	                    ->select('cantidad_tmp, precio_unitario, id_original_producto, precio_prov, precio_modificado, selected_price')->from('cot_cotizaciontmp')
	                    ->where('id_cotizacion=:idc', array(':idc'=>$modelCotizacion->id))->queryAll(); 
	                    $j= 1;
	                    foreach ($productosCotizacion as $iter => $productoCotizacion) {
	                        $modelSlCotDesc= SlCotizacionesDesc::model()->find("cot_web=? AND id_producto=?", 
	                            array($modelCotizacion->id, $productoCotizacion['id_original_producto']));

	                        //Cotización Desc Pionera SL
	                        if($modelSlCotDesc=== NULL){
	                            $this->guardarCotizacionDesc($modelSlCot->folio_cotizacion, $productoCotizacion, $modelCotizacion->id, $j);
	                        }

	                        //Cotización Desc Heredada SL
	                        else{
	                            $this->guardarCotizacionDesc($modelSlCot->folio_cotizacion, $productoCotizacion, $modelCotizacion->id, $j, 1, $modelSlCotDesc);
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
	                    if(count($diferencias)> 0){
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

	//Guarda los productos de la cotización en el sistema local (Punto de venta Nsstore)
	function guardarCotizacionDesc($folio, $producto_cotizacion, $id_cotizacion, $iterador, $tipo_desc = null, $model_sl_cot_desc = null){

		if($tipo_desc== 1 && $model_sl_cot_desc!= null){
			$model_sl_cot_desc->partida= $iterador;
            $model_sl_cot_desc->cantidad= $producto_cotizacion['cantidad_tmp'];
            $model_sl_cot_desc->precio_prov= $producto_cotizacion['precio_prov'];
            if($producto_cotizacion['precio_modificado']!== NULL)
                $model_sl_cot_desc->precio_unitario= number_format($producto_cotizacion['precio_modificado'], 2, '.', '');
            else
                $model_sl_cot_desc->precio_unitario= number_format($producto_cotizacion['precio_unitario'], 2, '.', '');

            $productoPs = Yii::app()->db->createCommand()
            ->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
            ->where('reference=:rf', array(':rf'=> $producto_cotizacion['id_original_producto']))->queryRow(); 
           
            if($producto_cotizacion['selected_price']== $productoPs['precio_lista'])
                $model_sl_cot_desc->tipo_precio= 1;
            
            if($producto_cotizacion['selected_price']== $productoPs['precio_mm'])
                $model_sl_cot_desc->tipo_precio= 2;

            elseif($producto_cotizacion['selected_price']== $productoPs['precio_mayoreo'])
                $model_sl_cot_desc->tipo_precio= 3;

            //Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)

            $model_sl_cot_desc->save();
		} else{
			$modelSlCotizacionesDesc= new SlCotizacionesDesc();
			$modelSlCotizacionesDesc->folio_cotizacion= $folio;
			$modelSlCotizacionesDesc->partida= $iterador;
			$modelSlCotizacionesDesc->cantidad= $producto_cotizacion['cantidad_tmp'];
			$modelSlCotizacionesDesc->id_producto= $producto_cotizacion['id_original_producto'];
			$modelSlCotizacionesDesc->precio_prov= $producto_cotizacion['precio_prov'];
			if($producto_cotizacion['precio_modificado']!== NULL)
			    $modelSlCotizacionesDesc->precio_unitario= number_format($producto_cotizacion['precio_modificado'], 2, '.', '');
			else
			    $modelSlCotizacionesDesc->precio_unitario= number_format($producto_cotizacion['precio_unitario'], 2, '.', '');

			$productoPs = Yii::app()->db->createCommand()
			->select('precio_lista, precio_mm, precio_mayoreo')->from('ps_product')
			->where('reference=:rf', array(':rf'=> $producto_cotizacion['id_original_producto']))->queryRow(); 

			if($producto_cotizacion['selected_price']== $productoPs['precio_lista'])
			    $modelSlCotizacionesDesc->tipo_precio= 1;

			if($producto_cotizacion['selected_price']== $productoPs['precio_mm'])
			    $modelSlCotizacionesDesc->tipo_precio= 2;

			elseif($producto_cotizacion['selected_price']== $productoPs['precio_mayoreo'])
			    $modelSlCotizacionesDesc->tipo_precio= 3;

			//Si no se encuentra igualdad con los diferentes tipos de precio, se deja por default la opción 1 (Precio Lista)

			$modelSlCotizacionesDesc->cot_web= $id_cotizacion;
			$modelSlCotizacionesDesc->save(); 
		}
	}

	//Calcula los días de vigencia de la cotización tomando un rango de fecha
	function dias_vigencia($fecha_i, $fecha_f){
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); $dias = floor($dias);     
        return $dias;
    }

	//Generar y guardar PDF de la Cotización
	function generarPDF($token, $token_editar, $guardar_modelo = null, $por_email = null, $por_cotizacion = null, $model_cotizacion= null){
		$datos_pdf= array();
		$resultado= 0;
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
		    ->select('id, nombre_cliente, fecha_cotizacion, fecha_validez, email, clave_cotizacion, cargo, observaciones, id_original_cliente, tel1')
		    ->from('cot_cotizacion')
		    ->where('token = :token', array(':token'=>$token ? $token : $token_editar))
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
	
		if($idCotizacionGral['fecha_validez']!= '')
			$diasVigencia= $this->dias_vigencia($idCotizacionGral['fecha_cotizacion'], $idCotizacionGral['fecha_validez']);
		else
			$diasVigencia= 7;

		$pdf->writeHTMLCell(120, '', '', '', "<p><strong>Términos y Condiciones</strong><p>".nl2br($idCotizacionGral['observaciones'])." * Vigencia cotización ".$diasVigencia." días", 1, 1, 1, true, 'J', false);
		$pdf->SetAlpha(1);

		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->setPrintFooter();

		$pdf->Output($_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf', 'F');

		//Guardar cotización proveniente de la ventana de cotizacion (Creación / Actualización)
		if($guardar_modelo== 1 && isset($model_cotizacion)){	
			$model_cotizacion->rutaArchivo= $_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf';
			if($model_cotizacion->save())
				$resultado= 1;
			else
				$resultado= 0;
			
			return $resultado= 1;
		}

		//email
		elseif($por_email== 1){
            $pdf->Output($_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf', 'F');
            $archivo= $_SERVER['DOCUMENT_ROOT'].'cotizador/cotizacionesPdf/'.$idCotizacionGral['clave_cotizacion'].'.pdf';

            Yii::app()->mailer->Host = 'vps.nscomputadoras.com';
            Yii::app()->mailer->CharSet = "UTF-8";
            Yii::app()->mailer->IsSMTP();
            Yii::app()->mailer->SMTPAuth=true;
            Yii::app()->mailer->SMTPSecure = "ssl";
            Yii::app()->mailer->From = 'nsecommerce@nsstore.mx';
            Yii::app()->mailer->Port = 465;
            Yii::app()->mailer->Username = "nsecommerce@nsstore.mx";
            Yii::app()->mailer->Password = "R7OG-PqMfZfl";
            if($datosUsuario!= false)
                Yii::app()->mailer->FromName = $datosUsuario["razon_social"];
            else
                Yii::app()->mailer->FromName = "Cotización";
            Yii::app()->mailer->AddAddress($idCotizacionGral['email']);
            Yii::app()->mailer->Subject = 'Cotización';
            Yii::app()->mailer->AddAttachment($archivo, $idCotizacionGral['clave_cotizacion'].'.pdf');
            Yii::app()->mailer->Body = '<html xmlns="http://www.w3.org/1999/xhtml">
            <head>
             <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            </head>
            <body>
                <table width="100%" border="0" cellspacing="1" cellpadding="0" style="border-top-width:3px; border-top-style:solid; border-top-color:#a2c3e3;">
                 <tr>
                  <td align="left" valign="top" style="padding:10px;">
                   <p><font face="Verdana, Geneva, sans-serif" color="#336699" style="font-size:16px;"><strong>Estimado Cliente,</strong></font><br />    
                    <font face="Verdana, Geneva, sans-serif" style="font-size:12px"><br /><font color="#0a313f">Adjunto a este correo podrá encontrar la cotización que ha solicitado.</font></p>
                   <p><font face="Verdana, Geneva, sans-serif" color="#0a313f"  style="font-size:12px;">Muchas gracias por su preferencia.</font><br /></p></td>
                 </tr>
                 </table>
            </body>
            </html>';
            Yii::app()->mailer->IsHTML(true);  
            if(Yii::app()->mailer->Send())
            	$resultado= 1;
            else
            	$resultado= 0;
			
			return $resultado;
        } 
		
		//cotizacion
        elseif ($por_cotizacion== 1) {
        	$pdf->Output($idCotizacionGral['clave_cotizacion'].'.pdf', 'D');
        	return $resultado= 1;
        }
		
		return $resultado;
	}
}