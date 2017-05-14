<div id="attForm" class="well">
   	<center> 		
        
        <center> 
            <p><strong>¿Desea eliminar este registro?</strong></p>
        </center>

       <?php
             echo TbHtml::ajaxButton('Aceptar', 
            //url
            CHtml::normalizeUrl(array('/Joyeria/default/eliminar', 'id_categoria'=>$id_categoria,
            'val'=>'SI')),
            //ajaxOptions
            array(
                'type' => 'post',              
                'update' => '#attForm',
                ),
            //htmlOptions
            array(
                'id' => uniqid(),
                ));
        ?>

        <?php
             echo TbHtml::ajaxButton('Cancelar', 
            //ajaxOptions
            '',
            array(
    
                'beforeSend'=>'function() {  $.fancybox.close(); }',  
                ),
            //htmlOptions
            array(
                'id' => uniqid(),
                ));
        ?>
	</center>
</div>