<div id="allDiv">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'enableClientValidation'=>true,
    'htmlOptions'=>array('class'=>'well',
    'enctype' => 'multipart/form-data', 
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
        ),

)); ?>

<legend><?php $id_categoria!=NULL ?  $printVal="Editar Categoría" :  $printVal="Agregar Categoría"; echo $printVal;?></legend>

    <?php echo $form->textFieldControlGroup($model,'nombre_categoria'); ?> 

    <div class="row">
        <div class="pull-right">
            <?php
                 echo TbHtml::ajaxSubmitButton('Guardar', 
                //url
                CHtml::normalizeUrl(array('/Joyeria/default/nuevo')),
                //ajaxOptions
                array(
                    'type' => 'post',              
                    'update' => '#allDiv',
                    ),
                //htmlOptions
                array(
                    'id' => uniqid(),
                    ));
            ?>

            <?php
                echo TbHtml::ajaxButton('Cancelar', 
                //url
                '',
                //ajaxOptions
                array(
                    'beforeSend'=>'function() {  $.fancybox.close(); }',  
                    ),
                //htmlOptions
                array(
                    'id' => uniqid(),
                    ));
            ?>
        </div> 
    </div>


<?php $this->endWidget(); ?>
</div>