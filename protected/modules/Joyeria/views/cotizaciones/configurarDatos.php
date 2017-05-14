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
      margin-bottom: 5px;
    }
    .ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-draggable .ui-resizable
    {
      background: green;
    }
</style>
<?php $this->breadcrumbs=array('Cotización'); ?>

<!-- Formulario Cotización -->
<div id="allDiv">
  <?php if(Yii::app()->user->hasFlash('contact')){?>
    <div class="flash-success">
      <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>
  <?php } ?>

  <?php $form = $this->beginWidget('CActiveForm', array(
  'enableClientValidation'=>true,
  'htmlOptions'=>array(
  'enctype' => 'multipart/form-data', 
  'style' => 'font-size: 12px; ',),
  )); ?>

    <legend style="font-size: 14px; text-align: left;">Datos de Contacto</legend> 
    <div class="row">
      <div class="span3">
         <?php echo $form->labelEx($model,'logo', array('title'=>"Observaciones y/o condiciones para la cotización")); ?>
         <?$this->widget('ext.EFineUploader.EFineUploader',
           array(
             'id'=>'FineUploader1',
             'config'=>array(
                 'autoUpload'=>true,
                 'request'=>array(
                    'endpoint'=> CController::createUrl("/Joyeria/cotizaciones/obtenerImagen"),
                    'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                  ),
                 'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                 'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                 'callbacks'=>array(
                    'onComplete'=>"js:function(id, name, response){ 
                        var rutaImagen1= './temp/thumbs/'+response.filename;
                        document.getElementById('imagen1').src=rutaImagen1;
                        document.getElementById('imagen1In').value=rutaImagen1;
                     }",
                  ),
                 'validation'=>array(
                     'allowedExtensions'=>array('png'),
                     'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes (1mb)
                     'minSizeLimit'=>1*1024,// minimum file size in bytes (1kb)
                  ),          
                  'messages'=>array(
                     'typeError'=>"{file} tiene un formato inválido. Formatos válidos: {extensions}.",
                     'sizeError'=>"Tamaño excedido {file}, el límite permitido es {sizeLimit}.",
                  ),
              )
            ));
          ?>
          <img id="imagen1" src=<?php echo $imagen1; ?> class="imgProducto">
          <input type="hidden" id="imagen1In" name="hiddenImg1" value=<?php echo $input1; ?> >
        </div>  
      <div class="span3">
          <?php echo $form->labelEx($model,'departamento', array('title'=>'Persona a la que se le enviará la cotización')); ?>
          <?php echo $form->textField($model,'departamento'); ?>
          <?php echo $form->error($model,'departamento'); ?>
      </div>
      <div class="span3">
          <?php echo $form->labelEx($model,'telefono', array('title'=>'Puesto de la persona')); ?>
          <?php echo $form->textField($model,'telefono'); ?>
          <?php echo $form->error($model,'telefono'); ?>
      </div>
      <div class="span3">
          <?php echo $form->labelEx($model,'email'); ?>
          <?php echo $form->textField($model,'email'); ?>
          <?php echo $form->error($model,'email'); ?>
      </div>
    </div>
    <div class="row">
      <div class="span4">
          <?php echo $form->labelEx($model,'pagina_web'); ?>
          <?php echo $form->textField($model,'pagina_web', array('style'=>'width: 150px;')); ?>
          <?php echo $form->error($model,'pagina_web'); ?>
      </div>
    </div>
    <legend style="font-size: 14px; text-align: left;">Datos Bancarios</legend> 
    <div class="row">
        <div class="span3">
            <?php echo $form->labelEx($model,'razon_social'); ?>
            <?php echo $form->textField($model,'razon_social'); ?>
            <?php echo $form->error($model,'razon_social'); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model,'banco', array('title'=>'Nombre de la empresa a la que va dirigida la cotización')); ?>
            <?php echo $form->textField($model,'banco'); ?>
            <?php echo $form->error($model,'banco'); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model,'num_cuenta'); ?>
            <?php echo $form->textField($model,'num_cuenta'); ?>
            <?php echo $form->error($model,'num_cuenta'); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model,'clabe', array('title'=>'Persona que hace la cotización o venta')); ?>
            <?php echo $form->textField($model,'clabe'); ?>
            <?php echo $form->error($model,'clabe'); ?>
        </div>
    </div>
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($model,'inf_extra', array('title'=>"Observaciones y/o condiciones para la cotización")); ?>
            <?php echo $form->textArea($model,'inf_extra',  array('maxlength' => 300, 'rows' => 1, 'cols' => 50)); ?>
            <?php echo $form->error($model,'inf_extra'); ?>
        </div> 
    </div>

    <div class="row">
        <div style="text-align: center;" >
            <?php echo CHtml::submitButton('Guardar', array('class'=>'miBotonSuccess', 'name' => 'button1', 'title'=>'Se debe guardar primero para poder Imprimir o Enviar por mail la cotización')); ?>
            <?php
                echo CHtml::link('Cancelar', array('superIndex'), array('confirm' => '¿Desea cancelar este registro?',
                  'style' => 'margin-left:20px;', 'class' => 'btn'));
            ?>
        </div> 
    </div>
  <?php $this->endWidget(); ?>
</div>





