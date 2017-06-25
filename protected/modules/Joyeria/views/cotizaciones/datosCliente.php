<link rel="stylesheet" href="./css/chosen.css" />
<script src="./js/chosen.jquery.js" type="text/javascript"></script>
<script>
    $(function () {
        $(".chzn-select").chosen();
    });
</script>

<!-- Formulario Agregar Cliente -->
<div id="datos_cliente_div">
  <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
      'enableClientValidation'=>true,
      'htmlOptions'=>array(
      'enctype' => 'multipart/form-data', 
      'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
          ),

  )); ?>

  <div class="row">
    <div class="span4">
          <?php echo CHtml::label('Historial de Clientes', 'labelCliente', 
          array('style'=>'display: block; margin-right: 5px;', 'title'=>'Clientes registrados apartir de cotizaciones anteriores')); ?>
          <?php echo CHtml::dropDownList('cot_cliente','cliente', 
            CHtml::listData(CotClientes::model()->findAll('id_usuario=:us AND estatus=:es',array(':us'=>Yii::app()->user->getId(), ':es'=>1)), 'id_cliente', 'concatened'), 
            array('class'=>'chzn-select','empty'=>'--Seleccionar Cliente--', 'title'=>'Seleccione un cliente para obtener sus datos automáticamente',
              'ajax' => array(
                'type'=>'POST',
                'dataType'=>'json',
                'url'=>CController::createUrl('clientesCotizacion'), 
                'update'=>'#comentari',
                'success'=>'function(data){
                  $("#CotCotizacion_nombre_cliente").val(data.nombre_cliente);
                  $("#CotCotizacion_cargo").val(data.cargo);
                  $("#CotCotizacion_tel1").val(data.tel1);
                  $("#CotCotizacion_tel2").val(data.tel2);
                  $("#CotCotizacion_email").val(data.email);
                  $("#CotCotizacion_empresa").val(data.empresa);
                  $("#CotCotizacion_id_original_cliente").val(data.id_original_cliente);
                }', 
              )
            )); ?>

        </div>
    <div class="span4">
        <?php echo $form->labelEx($modelCotizacion,'nombre_cliente', array('title'=>'Persona a la que se le enviará la cotización')); ?>
        <?php echo $form->textField($modelCotizacion,'nombre_cliente', array('readonly'=>false)); ?>
        <?php echo $form->error($modelCotizacion,'nombre_cliente'); ?>
    </div>
    <div class="span4">
        <?php echo $form->labelEx($modelCotizacion,'ejecutivo', array('title'=>'Persona que hace la cotización o venta')); ?>
        <?php echo $form->textField($modelCotizacion,'ejecutivo'); ?>
        <?php echo $form->error($modelCotizacion,'ejecutivo'); ?>
    </div>
  </div>

  <div class="row">
    <div class="span2">
        <?php echo $form->hiddenField($modelCotizacion,'cargo'); ?>
    </div>
    <div class="span4">
        <?php echo $form->hiddenField($modelCotizacion,'tel1'); ?>
    </div>
    <div class="span2">
        <?php echo $form->hiddenField($modelCotizacion,'tel2', array('style'=>'width: 150px;')); ?>
    </div>
  </div> 
  
  <div class="row">
    <div class="span4">
        <?php echo $form->labelEx($modelCotizacion,'observaciones', array('title'=>"Observaciones y/o condiciones para la cotización")); ?>
        <?php echo $form->textArea($modelCotizacion,'observaciones',  array('maxlength' => 300, 'rows' => 5, 'cols' => 150)); ?>
        <?php echo $form->error($modelCotizacion,'observaciones'); ?>
    </div> 
    <div class="span4">
       <?php echo CHtml::label('Validez', 'diasValidez', array('title'=>'Validez en tiempo de la cotización')); ?>
       <input name="diasValidez" type="number" id="diasValidez" min="0" max="100" style="width: 70px;" value=<?php echo $validez; ?> > Días 
    </div>
  </div>
  
  <div class="row">
    <div class="span4">
        <?php echo $form->hiddenField($modelCotizacion,'email'); ?>
    </div>
    <div class="span4">
        <?php echo $form->hiddenField($modelCotizacion,'empresa'); ?>
    </div>
    <div class="span4">
        <?php echo $form->hiddenField($modelCotizacion,'fecha_cotizacion'); ?>
    </div>
  </div>

  <?php echo $form->hiddenField($modelCotizacion,'id_original_cliente'); ?>
  <?php 
    echo TbHtml::ajaxSubmitButton('Guardar', 
    CHtml::normalizeUrl(array('/Joyeria/cotizaciones/datosCliente', 'token'=> $token)),
    array('type' => 'post', 'update'=>'#datos_cliente_div'), array('id' => uniqid(), 'class'=> 'btn boton-primary-alt', 'style'=>'margin-right: 10px;' ));

    echo TbHtml::ajaxButton('Cancelar', '', array('beforeSend'=>'function() {  $.fancybox.close(); }'),
    array('id' => uniqid(), 'class'=> 'btn boton-default-alt') );
  ?>
  <?php $this->endWidget(); ?>
</div>  

