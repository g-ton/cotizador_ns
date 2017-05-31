<!-- Vista para el Login -->
<div class="form-centrado">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL
    )); ?>
    <legend>Iniciar Sesión</legend>

    <!-- Estos son los campos que conforman parte del formulario -->
    <?php echo $form->textFieldControlGroup($model, 'username', array('placeholder'=>'Usuario')); ?>
    <?php echo $form->passwordFieldControlGroup($model, 'password', array('placeholder' => 'Contraseña')); ?>

    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton('Aceptar', array('class' => 'boton-primary-alt')),
        TbHtml::resetButton('Cancelar', array('class' => 'boton-default-alt')),
    )); ?>
    <?php $this->endWidget(); ?>
</div>