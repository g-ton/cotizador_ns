<style>
    /* Propia Clase = PC*/
    /* PC */
    .errorMessage{
        color: red;
        font-size: 0.9em;
        margin-top: -7px;
    }

    /* PC */
    .error{
        color: red;
    }

    .imgProducto{
      height: 120px; 
      width: 120px;
    }
</style>
<?php
$this->breadcrumbs=array(
	'Agregar Productos',);
?>

<?php 
    $ajaxSubmitButtonID= "idBien";
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'Productos-grid',
        'dataProvider'=>$modelProductos->search(),
        'type' => TbHtml::GRID_TYPE_CONDENSED,
        'emptyText'=> 'Resultados no encontrados',
        'filter'=>$modelProductos,
        'afterAjaxUpdate' => "function(id,data){
            jQuery('#Productos_id_categoria').select2();
            $('a[rel=myrel]').fancybox();
                }",
        'columns'=>array(
            array(
                'name'=>'clave',
                'htmlOptions' => array(
                    'style' => 'width: 10%;', 
                )   
            ),
            array(
                'name'=>'nombre',
                'htmlOptions' => array(
                    'style' => 'width: 20%;', 
                )   
            ),
      
            array(
                'name'=>'precio',
                'htmlOptions' => array(
                    'style' => 'width: 10%;',    
                ),
            ),
            'descripcion',
            array(
                'header'=>'Categoría',
                'value'=>'$data->idCategoria->nombre_categoria',
                'filter' => $this->widget('ext.select2.ESelect2', array(
                    'model' => $modelProductos,
                    'attribute' => 'id_categoria',
                    'data' => $listCategorias,
                    'options'  => array(                                     
                            'allowClear'=>true,                                    
                            'placeholder'=>'Todos',),
                     'htmlOptions' => array(
                                'style' => 'width: 100%; min-width: 60%;',    
                            ),        
                        ), true),
            ),
/*            array(
                'header'=>'Opciones',
                'type'=>'raw',
                'value'=>'$data->getAgregarProducto()',
                'htmlOptions'=>array('style'=>'width:5%;'),
            ),*/
            array(
            'class'=>'CButtonColumn',
            'template'=>'{email}{down}',
            'buttons'=>array(
                'email' => array(
                    'label'=>'Send an e-mail to this user',
                    'imageUrl'=>Yii::app()->request->baseUrl.'/images/email.png',
                    'url'=>'Yii::app()->createUrl("users/email", array("id"=>$data->nombre))',
                ),
                'down' => array(

                    'label'=>'[-]',
                    'click'=>"function(){
                        $.ajax({
                            type: 'POST',
                            url:$(this).attr('href'),
                            success: function() { 
                                $.fn.yiiGridView.update('Cotizaciones-grid');
                                $('body').undelegate('#".$ajaxSubmitButtonID."','click'); }
                        })
                        return false;
                    }",
                    'url'=>'Yii::app()->createUrl("/Joyeria/productos/seleccionProductos", array("id_producto"=>$data->id, "precio"=>$data->precio))',
                    'options'=>array(
                        'live'  => false,
                        'class' => $ajaxSubmitButtonID,
                    ),
                ),
            ),
            ),
        ),
        'htmlOptions' => array('style' => 'padding-top: 20px;')
    )); 
?>

  <?php
/*    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target' => '.fancyBox',
        'config' => array(
            'scrolling' => 'false',
            'titleShow' => true,
        ),));*/

    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target'=>'a[rel="myrel"]',
        'config'=>array(
        'scrolling' => 'yes',
    'titleShow' => true,
                ),
        )
);
  ?>
<!-- 
<script type="text/javascript">
$("#myScript").click(function() {


    var href = $("#myScript").attr('href');
    alert(href);

    $.ajax({
        type: 'GET',
        data:  'id_producto=1&precio=666',
        url: '<?php //echo Yii::app()->createUrl("/Joyeria/productos/seleccionProductos"); ?>',
        //Yii::app()->createUrl('/Joyeria/productos/seleccionProductos'
        success:function(data){
                alert(data); 
        },
    });
});
</script> -->