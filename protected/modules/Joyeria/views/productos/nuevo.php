<link rel="stylesheet" href="./css/chosen.css" />
<script src="./js/chosen.jquery.js" type="text/javascript"></script>

<script>
    $(function () {
        $(".chzn-select").chosen();
    });
</script>
<style>
    /* Propia Clase = PC*/

    /* PC */
    .errorMessage
    {
        color: red;
        font-size: 0.9em;
        margin-top: -7px;
    }

    /* PC */
    .error
    {
        color: red;
    }

    .imgProducto
    {
      height: 120px; 
      width: 120px;
    }
</style>

<div id="allDiv">
<?php $form = $this->beginWidget('CActiveForm', array(
    'enableClientValidation'=>true,
    'htmlOptions'=>array(
    'enctype' => 'multipart/form-data', 
    'style' => 'font-size: 12px; ', 
        ),

)); ?>
<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<legend><?php $id_producto!=NULL ?  $printVal="Editar Producto" :  $printVal="Agregar Producto"; echo $printVal;?></legend>

<center>
    <div class="row">
        <div class="span4">
            <?php echo $form->labelEx($model,'id_categoria'); ?>
            <?php echo $form->dropDownList($model, 'id_categoria', $listCategorias, 
                    array('prompt'=>'--Seleccione una Categoría--', 'class'=>'chzn-select',
                        )); 
            ?>
            <?php echo $form->error($model,'id_categoria'); ?>
        </div>
         <div class="span4">
            <?php echo $form->labelEx($model,'clave'); ?>
            <?php echo $form->textField($model,'clave'); ?>
            <?php echo $form->error($model,'clave'); ?>
        </div>
         <div class="span4">
            <?php echo $form->labelEx($model,'nombre'); ?>
            <?php echo $form->textField($model,'nombre'); ?>
            <?php echo $form->error($model,'nombre'); ?>
        </div>

    </div> 

    <br />

    <div class="row">
        <div class="span4 offset2">
            <?php echo $form->labelEx($model,'descripcion'); ?>
            <?php echo $form->textField($model,'descripcion'); ?>
            <?php echo $form->error($model,'descripcion'); ?>
        </div>
        <div class="span4">
            <?php echo $form->labelEx($model,'precio'); ?>
            <?php echo $form->textField($model,'precio'); ?>
            <?php echo $form->error($model,'precio'); ?>
        </div>
        <div class="offset2"></div>
    </div>

    <br />

    <div class="row">
        <div class="span3">
           <?$this->widget('ext.EFineUploader.EFineUploader',
             array(
                   'id'=>'FineUploader1',
                   'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=> CController::createUrl("/Joyeria/productos/obtenerImagen"),
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
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>5 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>2*1024,// minimum file size in bytes
                        ),
                  
                        'messages'=>array(
                                     'typeError'=>"{file} tiene un formato inválido. Formatos válidos: {extensions}.",
                                     //'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                     //'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                     //'emptyError'=>"{file} is empty, please select files again without it.",
                                     //'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                        ),
                      )
                  ));
            ?>
            <img id="imagen1" src=<?php echo $imagen1; ?> class="imgProducto">
            <input type="hidden" id="imagen1In" name="hiddenImg1" value=<?php echo $input1; ?> >
        </div> 

        <div class="span3">
           <?$this->widget('ext.EFineUploader.EFineUploader',
             array(
                   'id'=>'FineUploader2',
                   'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=> CController::createUrl("/Joyeria/productos/obtenerImagen"),
                          'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                       ),
                       'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                       'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                       'callbacks'=>array(
                          'onComplete'=>"js:function(id, name, response){ 
                              var rutaImagen2= './temp/thumbs/'+response.filename;
                              document.getElementById('imagen2').src=rutaImagen2;
                              document.getElementById('imagen2In').value=rutaImagen2;
                           }",
                        ),
                       'validation'=>array(
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>5 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>2*1024,// minimum file size in bytes
                        ),

                        'messages'=>array(
                                     'typeError'=>"{file} tiene un formato inválido. Formatos válidos: {extensions}.",
                                     //'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                     //'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                     //'emptyError'=>"{file} is empty, please select files again without it.",
                                     //'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                        ),
                      )
                  ));
            ?>
            <img id="imagen2" src=<?php echo $imagen2; ?> class="imgProducto">
            <input type="hidden" id="imagen2In" name="hiddenImg2" value=<?php echo $input2; ?> >
        </div> 

        <div class="span3">
            <?$this->widget('ext.EFineUploader.EFineUploader',
             array(
                   'id'=>'FineUploader3',
                   'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=> CController::createUrl("/Joyeria/productos/obtenerImagen"),
                          'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                       ),
                       'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                       'chunking'=>array('enable'=>true,'partSize'=>100),
                       'callbacks'=>array(
                                        //'onError'=>"js:function(id, name, errorReason){ }",
                          'onComplete'=>"js:function(id, name, response){ 
                              var rutaImagen3= './temp/thumbs/'+response.filename;
                              document.getElementById('imagen3').src=rutaImagen3;
                              document.getElementById('imagen3In').value=rutaImagen3;
                           }",
                        ),
                       'validation'=>array(
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>5 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>2*1024,// minimum file size in bytes
                        ),

                       'messages'=>array(
                                     'typeError'=>"{file} tiene un formato inválido. Formatos válidos: {extensions}.",
                                     //'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                     //'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                     //'emptyError'=>"{file} is empty, please select files again without it.",
                                     //'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                        ),
                      )
                  ));
            ?>
            <img id="imagen3" src=<?php echo $imagen3; ?> class="imgProducto">
            <input type="hidden" id="imagen3In" name="hiddenImg3" value=<?php echo $input3; ?> >
        </div>
        
        <div class="span3">
            <?$this->widget('ext.EFineUploader.EFineUploader',
             array(
                   'id'=>'FineUploader4',
                   'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=> CController::createUrl("/Joyeria/productos/obtenerImagen"),
                          'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                       ),
                       'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                       'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                       'callbacks'=>array(
                          'onComplete'=>"js:function(id, name, response){ 
                              var rutaImagen4= './temp/thumbs/'+response.filename;
                              document.getElementById('imagen4').src=rutaImagen4;
                              document.getElementById('imagen4In').value=rutaImagen4;
                           }",
                        ),
                       'validation'=>array(
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>5 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>2*1024,// minimum file size in bytes
                        ),
                       'messages'=>array(
                                     'typeError'=>"{file} tiene un formato inválido. Formatos válidos: {extensions}.",
                                     //'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                     //'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                     //'emptyError'=>"{file} is empty, please select files again without it.",
                                     //'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                    ),
                      )
                  ));
            ?>
            <img id="imagen4" src=<?php echo $imagen4; ?> class="imgProducto">
            <input type="hidden" id="imagen4In" name="hiddenImg4" value=<?php echo $input4; ?> >
        </div>
    </div> 
    
    <br />
    <div class="row">
        <div class="pull-center" >
            <?php
              echo TbHtml::submitButton('Guardar', array( 
                'color'=> TbHtml::BUTTON_COLOR_PRIMARY, 
              ));  
            ?>

            <?php            
              echo TbHtml::link('Cancelar', array('index'), array('confirm' => '¿Desea cancelar este registro?',
                         'style' => 'margin-left:20px;', 'class' => 'btn'));  
            ?>
        </div> 
    </div>
</center>

<?php $this->endWidget(); ?>
</div>
