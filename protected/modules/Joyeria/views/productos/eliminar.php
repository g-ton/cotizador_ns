<div id="attForm" class="well">
   	<center> 		
        
        <center> 
            <p><strong>¿Desea eliminar este registro?</strong></p>
        </center>

         <?php
             echo TbHtml::ajaxButton('Aceptar', 
            //url
            CHtml::normalizeUrl(array('/Joyeria/productos/eliminar', 'id_producto'=>$id_producto,
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