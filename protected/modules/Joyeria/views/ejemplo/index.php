<style>
.myCenter
{
    border: 1px solid #dadada;
    border-radius: 6px;
    padding-left: 5px;
    padding-right: 10px;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
}
</style>
<link rel="stylesheet" href="./css/chosen.css" />
<script src="./js/chosen.jquery.js" type="text/javascript"></script>

<script>
    $(function () {
        $(".chzn-select").chosen();
    });
</script>


<!-- FILTERS (Datepicker) -->



<br />
<br />
<br />
<div class="myCenter">
    <strong>Instrucciones: </strong> <small>Para fines ilustrativos ingresar en el campo de "Metros Cuadrados" solo d&iacute;gitos del 0 al 100.</small>
</div>

 <div class="myCenter well"> 
    <legend>Cotizador</legend>
    <?php
    echo CHtml::form('','POST',array(
            'id'=>'email-form',
            //'style' => 'border: 1px solid red;'
        ));

       

                
    ?>
        <div class="row">
            <div class="span2">
                <?php echo CHtml::label('Tipo de Avalúo: ', false); ?>
            </div>
            <div class="span3">    
                <?php  echo CHtml::dropDownList('valorInfonavit','',$arrayInfonavit, array('class'=>'chzn-select')); ?>
            </div>
        </div>
        <br />

        <div class="row">
            <div class="span2">
                <?php echo CHtml::label('Metros Cuadrados: ', false); ?>
            </div>
            <div class="span3">    
                <?php  echo CHtml::textField('metrosCuadrados'); ?>
            </div>
        </div>
      <?php
              echo TbHtml::submitButton('Cotizar', array( 
                'color'=> TbHtml::BUTTON_COLOR_PRIMARY, 
              ));  
        echo CHtml::endForm();
        ?>
 </div>
 <div id="allDiv">
    <?php
        if($precio!=NULL)
        {
    ?>
            <div class="myCenter">
                <center><h4>Costo del Servicio</h4></center>
                <small>Precio + IVA: </small> <strong><?php echo $precio; ?></strong>
                <br />

                <small>Observaciones: Incluye dictamen t&eacute;cnico  m&aacute;s vi&aacute;ticos dependiendo del municipio.</small>

            </div>
    <?php
        }
    ?>

 </div>


