<style>
    /*Hubo problema con los select*/
     textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input {
        border-radius: 4px;
        color: #555555;
        display: inline-block;
        font-size: 14px;
        height: 20px;
        line-height: 20px;
        margin-bottom: 10px;
        padding: 4px 0px; 
        vertical-align: middle;
    }
    
    .errorCANCELADO{
        background-color: #ffc3c3;
    }
</style>
<?php
$this->breadcrumbs=array(
	'Categorías',
);
?>

<!-- FILTERS (Datepicker) -->
    <?php 
      echo TbHtml::linkButton('Agregar Categoría', array(
          'color'=> TbHtml::BUTTON_COLOR_PRIMARY, 
          'url' => CHtml::normalizeUrl(array('/Joyeria/default/nuevo')),
          'class'=>'fancyBox'
          ));  
    ?>

    <?php 
     echo TbHtml::linkButton('Exportar lista a Excel', array(
          'url' => CHtml::normalizeUrl(array('/Joyeria/default/exportarExcel')),
          'style'=> 'float: right;',
          ));
    ?>

    <?php 
      $this->widget('bootstrap.widgets.TbGridView', array(
         'id'=>'Categorias-grid',
         'dataProvider' => $model->search(),
         'type' => TbHtml::GRID_TYPE_CONDENSED,
         'emptyText'=> 'Resultados no encontrados',
         'filter' => $model,
         'afterAjaxUpdate' => "function(id,data){
            $('.fancyBox').fancybox({'scrolling':'false','titleShow':true, 
            'showCloseButton': true, 'hideOnOverlayClick': false,});
                      }",
         //'template' => "{items}",
         'columns' => array(
              'nombre_categoria',
              array(
                  'header'=>'Opciones',
                  'type'=>'raw',
                  'value'=>'$data->getEditar()."&nbsp&nbsp".$data->getEliminar()',
                  'htmlOptions'=>array('style'=>'min-width:40px;'),
              ),
          ),

         'htmlOptions' => array('style' => 'padding-top: 10px;')
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



