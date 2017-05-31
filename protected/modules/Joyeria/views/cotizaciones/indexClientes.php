<?php
$this->breadcrumbs=array(
	'Clientes',
);
?>

  <?php 
    echo TbHtml::linkButton('Agregar Cliente', array(
      'color'=> TbHtml::BUTTON_COLOR_WARNING, 
      'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/clientesCotizacion', 'id'=>1)),
      'style'=> 'float: left; margin-bottom: 10px;',
      'icon'=>"icon-plus",
      'class'=>'clientes boton-primary-alt'
    ));
  ?>

  <?php 
    $this->widget('bootstrap.widgets.TbGridView', array(
       'id'=>'clientes-grid',
       'dataProvider' => $modelCliente->search(),
       'type' => TbHtml::GRID_TYPE_CONDENSED,
       'emptyText'=> 'Resultados no encontrados',
       'filter' => $modelCliente,
       'afterAjaxUpdate' => "function(id,data){
          $('.clientes').fancybox({'titleShow':true, 
          'showCloseButton': true, 'hideOnOverlayClick': false});
                    }",
       'columns' => array(
            'nombre_cliente',
            'empresa',
            'email',
            array(
              'header'=>'Opciones',
              'type'=>'raw',
              'value'=>'$data->getEditar()."&nbsp&nbsp".$data->getEliminar()',
              'htmlOptions'=>array('style'=>'width:5%; font-size: 18px;'),
            ),
        ),

       'htmlOptions' => array('style' => 'padding-top: 10px; overflow-x: auto; width: 100%;')
    )); 
  ?>

  <?php
    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target' => '.clientes',
        'config' => array(
            'titleShow' => true,
            ),
        )
    );
  ?>



