<style>
.myCenter
{
    border: 1px solid #dadada;
    border-radius: 6px;
    padding-left: 5px;
    padding-right: 10px;
}
</style>
<div class="pull-right myCenter"> 
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL
    )); ?>
    <legend>Iniciar Sesión</legend>
    <?php echo $form->textFieldControlGroup($model, 'username', array('placeholder'=>'Usuario')); ?>
    <?php echo $form->passwordFieldControlGroup($model, 'password', array('placeholder' => 'Contraseña')); ?>
    <?php //echo $form->checkBoxControlGroup($model, 'rememberMe', array('disabled' => true)); ?>
    <?php echo TbHtml::formActions(array(
        TbHtml::submitButton('Aceptar', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)),
        TbHtml::resetButton('Cancelar'),
    )); ?>
    <?php $this->endWidget(); ?>
</div>