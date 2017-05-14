<div id="allDivApm">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'enableClientValidation'=>true,
    'htmlOptions'=>array('class'=>'well',
    'enctype' => 'multipart/form-data', 
    'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL, 
        ),

)); ?>

<legend>Agregar Producto</legend>
    <?php echo $form->textFieldControlGroup($modelLang,'name'); ?> 
    <?php echo $form->textFieldControlGroup($modelProducto,'quantity'); ?> 
    <?php echo $form->textFieldControlGroup($modelProducto,'price'); ?> 
    <?php echo $form->textFieldControlGroup($modelProducto,'reference'); ?> 
    
    <div class="row">
        <div class="pull-right">
            <?php
                echo TbHtml::ajaxSubmitButton('Guardar', 
                CHtml::normalizeUrl(array('/Joyeria/cotizaciones/agregarProductoManual', 'token'=> $_GET['token'])),
                array('type' => 'post', 'update' => '#allDivApm',), array('id' => uniqid(),));
            ?>

            <?php
                echo TbHtml::ajaxButton('Cancelar', '', array('beforeSend'=>'function() {  $.fancybox.close(); }',),
                array('id' => uniqid(),));
            ?>
        </div> 
    </div>
<?php $this->endWidget(); ?>
</div>