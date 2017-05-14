<?php
/**
 * @abstract This Component Class is created to access TCPDF plugin for generating reports.
 * @example You can refer http://www.tcpdf.org/examples/example_011.phps for more details for this example.
 * @todo you can extend tcpdf class method according to your need here. You can refer http://www.tcpdf.org/examples.php section for 
 *       More working examples.
 * @version 1.0.0
 */
Yii::import('ext.tcpdf.*');
class MYPDF extends TCPDF {
 
    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
 
    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        //Colorea el header
        //$this->SetFillColor(51, 102, 153);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(51, 51, 51);
        //Colorea los bordes internos y externos de la tabla
        $this->SetDrawColor(64, 64, 64);
        $this->SetLineWidth(0.2);
        $this->SetFont('', 'B');
        // Header
        $w = array(15, 105, 30, 30);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('');
        // Data
        $fill = 0;
        $i=0;
        $arrayIva= array();
        foreach($data as $row) {
            //Se acorta el nombre del producto
            $arrayIva[$i]= $row["precio_tmp"];
            $nombreRecortado= substr($row["nombre"], 0, 54);  
            $this->Cell($w[0], 6, $row[cantidad_tmp],     'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $nombreRecortado."...", 'LR', 0, 'L', $fill);
            if($row["precio_modificado"]!= NULL)
                $this->Cell($w[2], 6, number_format($row["precio_modificado"], 2, '.', ''), 'LR', 0, 'R', $fill);

            else
                $this->Cell($w[2], 6, number_format($row[precio_unitario], 2, '.', ''), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[precio_tmp], 2, '.', ''), 'LR', 0, 'R', $fill);
            $this->Ln();

            $fill=!$fill;
            if($i== 20)
                $this->AddPage();

            $i++;
        }
        $costoTotal= array_sum($arrayIva);
        $costoTotalIva= $costoTotal * 1.16; 
        $iva= $costoTotalIva - $costoTotal;

        $this->SetFont('helvetica', '', '10');
        $this->Cell($w[0], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, "SUBTOTAL", 'LR', 0, 'R', $fill);
        $this->Cell($w[3], 6, number_format($costoTotal, 2, '.', ''), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill=!$fill;
       
        $this->Cell($w[0], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, "IVA", 'LR', 0, 'R', $fill);
        $this->Cell($w[3], 6, number_format($iva, 2, '.', ''), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill=!$fill;

        $this->Cell($w[0], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[1], 6, "", 'LR', 0, 'L', $fill);
        $this->Cell($w[2], 6, "TOTAL", 'LR', 0, 'R', $fill);
        $this->Cell($w[3], 6, number_format($costoTotalIva, 2, '.', ''), 'LR', 0, 'R', $fill);
        $this->Ln();
        $fill=!$fill;

        $this->Cell(array_sum($w), 0, '', 'T');
    }

    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        //-$img_file = K_PATH_IMAGES.'avitec_fondo.jpg';
        //-$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }

    protected $last_page_flag = false;

    public function Close() {
        $this->last_page_flag = true;
        parent::Close();
    }

    public function Footer() {
        if ($this->last_page_flag) {

            if(Yii::app()->session['rol_usuario']== 'admin' || Yii::app()->session['rol_usuario']== 'vendedor')
            {
                $datosUsuario = Yii::app()->db->createCommand()
                    ->select()->from('cot_configuracion')
                    ->where('conf_general = :cong', array(':cong'=>1))->queryRow();
            }

            else
            {
                $datosUsuario = Yii::app()->db->createCommand()
                    ->select()->from('cot_configuracion')
                    ->where('id_usuario = :us', array(':us'=>Yii::app()->user->getId()))
                    ->queryRow();
            }

            // Si la configuración del usuario existe se pintan los datos en el footer
            if($datosUsuario!= false)
            {
                $this->SetY(-40);
                // Set font
                $this->SetFont('helvetica', 'I', 8);
                $this->SetAlpha(0.5);
                $this->SetFillColor(246, 246, 246);
                $this->SetDrawColor(215, 217, 219);
                $idCotizacionGral= "Célula";
                $htmlL= "<p><strong>Datos de Contacto:</strong><p>"
                .nl2br($datosUsuario['departamento'])."<br />"
                .nl2br($datosUsuario['telefono'])."<br />"
                .nl2br($datosUsuario['email'])."<br />"
                .nl2br($datosUsuario['pagina_web']);

                $htmlR= "<p><strong>Datos Bancarios:</strong><p>"
                .nl2br($datosUsuario['razon_social'])."<br />"
                .nl2br($datosUsuario['banco'])."<br />"
                ."Cuenta: ".nl2br($datosUsuario['num_cuenta'])."<br />"
                ."CLABE: ".nl2br($datosUsuario['clabe'])."<br />"
                .nl2br($datosUsuario['inf_extra']);

                $this->writeHTMLCell(80, 30, '', '', $htmlL, 1, 0, 1, true, 'J', false);
                $this->writeHTMLCell(80, 30, '', '', $htmlR, 1, 1, 1, true, 'J', false);
                $this->SetAlpha(1);
                $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }

            else{
                $this->SetY(-15);
                $this->Cell(0, 0, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
            }
            // Page number
        } 
    }
}
?>