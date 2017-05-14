<!-- Formulario Agregar Cliente -->
<div id="allDiv">
  <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
      'enableClientValidation'=>true,
      'htmlOptions'=>array(
      'enctype' => 'multipart/form-data', 
      'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
          ),

  )); ?>

  <?php echo $form->textFieldControlGroup($modelCliente,'nombre_cliente'); ?> 
  <?php echo $form->textFieldControlGroup($modelCliente,'cargo'); ?> 
  <?php echo $form->textFieldControlGroup($modelCliente,'tel1'); ?> 
  <?php echo $form->textFieldControlGroup($modelCliente,'tel2'); ?>
  <?php echo $form->textFieldControlGroup($modelCliente,'email'); ?>
  <?php echo $form->textFieldControlGroup($modelCliente,'empresa'); ?>
  <div class="row">
      <div class="pull-right">
          <?php
            if($idCliente== '')
            {
              echo TbHtml::ajaxSubmitButton('Guardar', 
              CHtml::normalizeUrl(array('/Joyeria/cotizaciones/clientesCotizacion', 'id'=> 1)),
              array('type' => 'post', 'update' => '#allDiv',), array('id' => uniqid() ));
            }

            else{
              echo TbHtml::ajaxSubmitButton('Guardar', 
              CHtml::normalizeUrl(array('/Joyeria/cotizaciones/clientesCotizacion', 'id'=> 1, 'idCliente'=> $idCliente)),
              array('type' => 'post', 'update' => '#allDiv',), array('id' => uniqid() ));
            }
          ?>

          <?php
              echo TbHtml::ajaxButton('Cancelar', '', array('beforeSend'=>'function() {  $.fancybox.close(); }',),
              array('id' => uniqid(),));
          ?>
      </div> 
  </div>

  <?php $this->endWidget(); ?>
</div>  

