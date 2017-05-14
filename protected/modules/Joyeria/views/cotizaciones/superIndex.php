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
      'icon'=>"icon-plus",
    ));
  ?>

  <!-- FILTERS (Datepicker) -->
  <?php 
    $this->widget('bootstrap.widgets.TbGridView', array(
       'id'=>'cotizacionesgral-grid',
       'dataProvider' => $modelCotizacion->search(),
       'type' => TbHtml::GRID_TYPE_CONDENSED,
       'emptyText'=> 'Resultados no encontrados',
       'filter' => $modelCotizacion,
       'afterAjaxUpdate' => "function(id,data){
          $('.cotizaciones').fancybox({'scrolling':'false','titleShow':true, 
          'showCloseButton': true, 'hideOnOverlayClick': false,});
                    }",
       'columns' => array(
            'fecha_cotizacion',
            'nombre_cliente',
            array(
              'name'=> 'email',
              'htmlOptions'=>array('color' =>'width: 60px'),
            ),
            array(
              'name'=> 'ejecutivo',
              'visible'=> Yii::app()->request->cookies['tipodispositivo']->value== 1? false : true,
            ),
            array(
              'name'=> 'clave_cotizacion',
              'visible'=> Yii::app()->request->cookies['tipodispositivo']->value== 1? false : true,
            ),
            array(
              'header'=>'Opciones',
              'type'=>'raw',
              'value'=>'$data->getPdf()."&nbsp&nbsp".$data->getEditar()."&nbsp&nbsp".$data->getEmail()',
              'htmlOptions'=>array('style'=>'width:10%; font-size: 18px;'),
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
                  if(data!= ''){
                    smoke.alert("Error al enviar correo", function(e){
                    }, {
                      ok: "Aceptar",
                      classname: "custom-class"
                    });
                  }

                  else{
                    smoke.alert("Correo Enviado!", function(e){
                    }, {
                      ok: "Aceptar",
                      classname: "custom-class"
                    });
                  }
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


