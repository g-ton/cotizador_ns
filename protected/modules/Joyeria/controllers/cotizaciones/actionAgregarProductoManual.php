<?php
class actionAgregarProductoManual extends CAction {
    public function run() 
    {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;

        $modelProducto = new PsProduct;
        $modelProducto->quantity= 1;
        $modelLang = new PsProductLang;

        if(isset($_POST['PsProduct'], $_POST['PsProductLang']))
        {   
            $modelProducto->attributes = $_POST['PsProduct'];
            $modelProducto->id_supplier= 1;
            $modelProducto->id_manufacturer= 1;
            $modelProducto->id_category_default= 233;
            $modelProducto->id_tax_rules_group= 1;
            $modelProducto->date_add= date("Y-m-d");
            $modelProducto->date_upd= date("Y-m-d");
            $modelProducto->available_date= date("Y-m-d");
            $modelProducto->price= number_format($_POST["PsProduct"]["price"]/1.16, 4, '.', '');
            $modelProducto->ean13= "customprod";

            //Campos adicionales
            $modelProducto->cod_fabricante= "";
            $modelProducto->precio_lista= 0.0;
            $modelProducto->precio_mm= 0.0;
            $modelProducto->precio_mayoreo= 0.0;
            $modelProducto->precio_prov= 0.0;

            $modelLang->attributes = $_POST['PsProductLang'];
            
            if($modelProducto->validate())
            {
                $modelProducto->save();

                $modelLang->id_product= $modelProducto->id_product;
                $modelLang->id_lang= 1;
                $modelLang->link_rewrite= $_POST['PsProductLang']['name'];

                if($modelLang->validate())
                {
                    $modelLang->save();

                    $cotizacionId = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from('cot_cotizacion')
                    ->where('token = :token', array(':token'=>$_GET['token']))
                    ->queryRow();

                    if($modelProducto->id_product)
                    {    
                        $modelCotTmp =  new CotCotizaciontmp;    
                        $modelCotTmp->id_producto= $modelProducto->id_product;
                        $modelCotTmp->nombre= strtoupper($modelLang->name);
                        $modelCotTmp->cantidad_tmp= $modelProducto->quantity; 
                        $modelCotTmp->id_cotizacion= $cotizacionId["id"]; 
                        $modelCotTmp->producto_propio= 1; 
                        if($modelProducto->quantity > 1)         
                            $modelCotTmp->precio_tmp= $modelProducto->price * $modelProducto->quantity; 
                        else
                            $modelCotTmp->precio_tmp= $modelProducto->price;

                        $modelCotTmp->precio_unitario= $modelProducto->price;
                        $modelCotTmp->save();
                    }

                    echo '<script>'; 
                    echo '$.fn.yiiGridView.update("Cotizaciones-grid");';
                    echo "$.fancybox.close();";
                    echo '</script>';
                    Yii::app()->end();
                }
            }
        }
     
        $this->controller->renderPartial("agregarProductoManual",array('modelProducto'=> $modelProducto, 'modelLang'=> $modelLang, 
            'token'=> $_GET['token']), false, true);
        Yii::app()->end();
    }
}
?>
