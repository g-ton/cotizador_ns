<?php
//COTIZACIONES GENERAR PDF
class actionGenerarPdf extends CAction {

    public function run() 
    {
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        spl_autoload_register(array('YiiBase','autoload'));
 
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('J. Damián');
        $pdf->SetTitle('TCPDF Example 051');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // remove default footer
        $pdf->setPrintFooter(false);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set font
        //*$pdf->SetFont('helvetica', '', 8);

        // Tercera página add a page
        $pdf->AddPage();

        // -- set new background ---
        // get the current page break margin
        /*$bMargin = $pdf->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $pdf->getAutoPageBreak();
        // disable auto-page-break
        $pdf->SetAutoPageBreak(false, 0);
        // set bacground image
        // restore auto-page-break status
        $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $pdf->setPageMark();*/

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
            $pdf->Image($image_file, 5, 3, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        }

        $idCotizacionGral = Yii::app()->db->createCommand()
            ->select('id, id_original_cliente, nombre_cliente, fecha_cotizacion, fecha_validez, email, clave_cotizacion, cargo, observaciones')
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

        //$pdf->Cell(0, 5, "Vigencia: ".$idCotizacionGral['fecha_validez'], 0, 1, 'R', false, 0);
        $pdf->SetTextColor(51, 51, 51);
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Ln(10);

        $header = array('Cantidad', 'Producto', 'Precio Unitario', 'Precio Total');
        if($idCotizacionGral!= false)
        {
            $data = Yii::app()->db->createCommand()
                ->select('cantidad_tmp, precio_unitario, precio_modificado, precio_tmp, nombre')
                ->from('cot_cotizaciontmp')
                ->where('id_cotizacion=:id_cotizacion', array(':id_cotizacion'=>$idCotizacionGral['id']))
                ->queryAll();
        }

        // print colored table
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
        //Condición para saber si se debe mandar por email o imprimir
        if($_GET['email'])
        {
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
            Yii::app()->mailer->Send();
            Yii::app()->end();
        }

        else
            $pdf->Output($idCotizacionGral['clave_cotizacion'].'.pdf', 'D');
    }
}
