<?php
$this->breadcrumbs=array(
	'Cotizaciones',
);
?>

  <?php 
    echo TbHtml::linkButton('Nueva Cotización', array(
      'color'=> TbHtml::BUTTON_COLOR_WARNING, 
      'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones', 'token'=>$token)),
      'style'=> 'float: left; margin-bottom: 10px;',
      'icon'=>"icon-mas",
      'class'=>"boton-primary-alt",
    ));
  ?>

  <!-- FILTERS (Datepicker) -->
  <?php 
    $this->widget('bootstrap.widgets.TbGridView', array(
       'id'=>'cotizacionesgral-grid',
       'dataProvider' => $modelCotizacion->search(),
       'type' => TbHtml::GRID_TYPE_CONDENSED,
       // 'type' => TbHtml::GRID_TYPE_STRIPED,
       'emptyText'=> 'Resultados no encontrados',
       'filter' => $modelCotizacion,
       'afterAjaxUpdate' => "function(id,data){
          $('.cotizaciones').fancybox({'scrolling':'false','titleShow':true, 
          'showCloseButton': true, 'hideOnOverlayClick': false,});
                    }",
       'columns' => array(
            array(
              'name'=>'fecha_cotizacion',
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
            array(
              'name'=>'nombre_cliente',
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
            array(
              'name'=> 'email',
              'htmlOptions'=>array('color' =>'width: 60px'),
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
            array(
              'name'=> 'ejecutivo',
              'visible'=> Yii::app()->request->cookies['tipodispositivo']->value== 1? false : true,
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
            array(
              'name'=> 'clave_cotizacion',
              'visible'=> Yii::app()->request->cookies['tipodispositivo']->value== 1? false : true,
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
            array(
              'header'=>'Opciones',
              'type'=>'raw',
              'value'=>'$data->getPdf()."&nbsp&nbsp".$data->getEditar()."&nbsp&nbsp".$data->getEmail()',
              'htmlOptions'=>array('style'=>'width:10%; font-size: 18px;'),
              'headerHtmlOptions' => array('class' => 'col-xl-2 col-sm-2 col-md-2 col-lg-2')
            ),
        ),
       'htmlOptions' => array('style' => 'padding-top: 10px; overflow-x: auto; width: 100%;')
    )); 
  ?>

  <?php
    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target' => '.cotizaciones',
        'config' => array(
            'scrolling' => 'false',
            'titleShow' => true,
            ),
        )
    );
  ?>

<script>
    $(document).ready(function(){
      $(".emailLink").click(function(event){
          event.preventDefault();
          var link= $(this).attr('href');
          $.ajax({
               url: link,
               type: 'POST',
               beforeSend: function(){
                  /*Muestra el loading image antes de enviar la petición ajax*/
                  $.blockUI({ message: '<strong><img src="../cotizador/images/cargando.png" /> Enviando...</strong>' });
               },       
               success: function(data) {
                  var data = $.parseJSON(data);
                  smoke.alert(data.mensaje, function(e){
                  }, {
                    ok: "Aceptar",
                    classname: "custom-class"
                  });
               },
               error: function() {
                  smoke.alert("Error en servidor", function(e){
                    }, {
                      ok: "Aceptar",
                      classname: "custom-class"
                  });
               },
               complete: function(){
                  /*Oculta el loading image al completar la petición, ya sea si fue success o error*/
                  $.unblockUI();
               }
          });
      });
    });
</script>


