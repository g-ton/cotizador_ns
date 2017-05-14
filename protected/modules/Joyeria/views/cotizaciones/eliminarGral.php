<div id="attForm" class="well">
    <center>        
        <center><p><strong>¿Desea eliminar esta cotización?</strong></p></center>
       <?php
            echo TbHtml::ajaxSubmitButton('Aceptar', 
            //url
            CHtml::normalizeUrl(array('/Joyeria/cotizaciones/eliminarGral', 'id_cotizacion'=>$id_cotizacion, 'val'=>'SI')),
            //ajaxOptions
            array('type' => 'post',              
                'update' => '#attForm',),
            //htmlOptions
            array('id' => uniqid(),));
        ?>

        <?php
            echo TbHtml::ajaxButton('Cancelar', 
            //ajaxOptions
            '',
            array('beforeSend'=>'function() {  $.fancybox.close(); }',  ),
            //htmlOptions
            array('id' => uniqid(),));
        ?>
    </center>
</div>