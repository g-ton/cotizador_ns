<style>
    /*Hubo problema con los select*/
   /*  textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
        border-radius: 4px;
        color: #555555;
        display: inline-block;
        font-size: 14px;
        height: 20px;
        line-height: 20px;
        margin-bottom: 10px;
        padding: 4px 0px; 
        vertical-align: middle;
    }*/
    
    .errorCANCELADO{
        background-color: #ffc3c3;
    }
</style>
<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Productos',
);
?>

<!-- FILTERS (Datepicker) -->

<?php 
  echo TbHtml::linkButton('Agregar Producto', array( 
      'color'=> TbHtml::BUTTON_COLOR_PRIMARY, 
      'url' => CHtml::normalizeUrl(array('/Joyeria/productos/nuevo')),
      ));  
?>

<?php 
 echo TbHtml::linkButton('Exportar lista a Excel', array(
      'url' => CHtml::normalizeUrl(array('/Joyeria/productos/exportarExcel')),
      'style'=> 'float: right;',
      ));
?>


<?php 
$this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'Productos-grid',
	'dataProvider'=>$model->search(),
    'type' => TbHtml::GRID_TYPE_CONDENSED,
    'emptyText'=> 'Resultados no encontrados',
    //'summaryText' => 'Aretha',
	'filter'=>$model,
    'afterAjaxUpdate' => "function(id,data){
        $('.fancyBox').fancybox({'scrolling':'false','titleShow':true, 
        'showCloseButton': true, 'hideOnOverlayClick': false,});
        jQuery('#Productos_id_categoria').select2();
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
                'model' => $model,
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
        array(
            'header'=>'Opciones',
            'type'=>'raw',
            'value'=>'$data->getEditar()."&nbsp&nbsp".$data->getEliminar()',
            'htmlOptions'=>array('style'=>'width:5%;'),
        ),
        
	),
	'htmlOptions' => array('style' => 'padding-top: 20px;')
)); 
?>

<?php
$this->widget('application.extensions.fancybox.EFancyBox', array(
    'target' => '.fancyBox',
    'config' => array(
        'scrolling' => 'false',
        'titleShow' => true,
    ),
        )
);
?>


