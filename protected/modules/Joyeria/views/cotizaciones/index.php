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
    .errorMessage{
        color: red;
        font-size: 0.9em;
        margin-top: -7px;
    }

    /* PC */
    .error{color: red;}

    .imgProducto{
      height: 120px; 
      width: 120px;
    }
    .ui-dialog .ui-widget .ui-widget-content .ui-corner-all .ui-draggable .ui-resizable
    {
      background: green;
    }

    #agregarProducto{float: none;}
    @media only screen and (min-width: 768px){
      .ui-dialog{
        width: 768px !important;   
      }
     #agregarProducto{float: right;}
    }
    @media only screen and (min-width: 992px){
      .ui-dialog{
        width: 800px !important;   
      }
      #agregarProducto{float: right;}
    }
    @media only screen and (min-width: 1200px){
      .ui-dialog{
        width: 800px !important;   
      }
      #agregarProducto{float: right;}
    }
</style>
<?php
$this->breadcrumbs=array(
  'Cotización',
);
?>

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
    'style' => 'font-size: 12px; margin-bottom: 5px;',),
    )); ?>

    <?php
      echo TbHtml::linkButton('Crear Otra Cotización', array(
        'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/superIndex')),
        'style' => "margin-bottom: 10px",
        'class' => "boton-primary-alt",
        ));
    ?>
    <center style="z-indez: -1;">
      <div class="row">
        <div class="span3">
          <?php echo CHtml::label('Historial de Clientes', 'labelCliente', 
          array('style'=>'display: block; margin-right: 5px;', 'title'=>'Clientes registrados apartir de cotizaciones anteriores')); ?>
          <?php echo CHtml::dropDownList('cot_cliente','cliente', 
            CHtml::listData(CotClientes::model()->findAll('id_usuario=:us AND estatus=:es',array(':us'=>Yii::app()->user->getId(), ':es'=>1)), 'id_cliente', 'concatened'), 
            array('class'=>'chzn-select','empty'=>'--Seleccionar Cliente--', 'title'=>'Seleccione un cliente para obtener sus datos automáticamente',
              'ajax' => array(
                'type'=>'POST',
                'dataType'=>'json',
                'url'=>CController::createUrl('clientesCotizacion'), 
                'update'=>'#comentari',
                'success'=>'function(data){
                  $("#CotCotizacion_nombre_cliente").val(data.nombre_cliente);
                  $("#CotCotizacion_cargo").val(data.cargo);
                  $("#CotCotizacion_tel1").val(data.tel1);
                  $("#CotCotizacion_tel2").val(data.tel2);
                  $("#CotCotizacion_email").val(data.email);
                  $("#CotCotizacion_empresa").val(data.empresa);
                  $("#CotCotizacion_id_original_cliente").val(data.id_original_cliente);
                }', 
              )
            )); ?>

        </div>
        <div class="span3">
            <?php echo $form->labelEx($modelCotizacion,'nombre_cliente', array('title'=>'Persona a la que se le enviará la cotización')); ?>
            <?php echo $form->textField($modelCotizacion,'nombre_cliente', array('readonly'=>true)); ?>
            <?php echo $form->error($modelCotizacion,'nombre_cliente'); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($modelCotizacion,'ejecutivo', array('title'=>'Persona que hace la cotización o venta')); ?>
            <?php echo $form->textField($modelCotizacion,'ejecutivo'); ?>
            <?php echo $form->error($modelCotizacion,'ejecutivo'); ?>
        </div>
    </div>

      <div class="row">
        <div class="span2">
            <?php echo $form->hiddenField($modelCotizacion,'cargo'); ?>
        </div>
        <div class="span4">
            <?php echo $form->hiddenField($modelCotizacion,'tel1'); ?>
        </div>
        <div class="span2">
            <?php echo $form->hiddenField($modelCotizacion,'tel2', array('style'=>'width: 150px;')); ?>
        </div>
      </div> 

      <div class="row">
          <div class="span4">
              <?php echo $form->hiddenField($modelCotizacion,'email'); ?>
          </div>
          <div class="span4">
              <?php echo $form->hiddenField($modelCotizacion,'empresa'); ?>
          </div>
          <div class="span4">
              <?php echo $form->hiddenField($modelCotizacion,'fecha_cotizacion'); ?>
          </div>
      </div>

      <div class="row">
          <div class="span3">
              <?php echo $form->labelEx($modelCotizacion,'observaciones', array('title'=>"Observaciones y/o condiciones para la cotización")); ?>
              <?php echo $form->textArea($modelCotizacion,'observaciones',  array('maxlength' => 300, 'rows' => 5, 'cols' => 150)); ?>
              <?php echo $form->error($modelCotizacion,'observaciones'); ?>
          </div> 
          <div class="span3">
             <?php echo CHtml::label('Validez', 'diasValidez', array('title'=>'Validez en tiempo de la cotización')); ?>
             <input name="diasValidez" type="number" id="diasValidez" min="0" max="100" style="width: 70px;" value=<?php echo $validez; ?> > Días 
          </div>
      </div>
      <?php echo $form->hiddenField($modelCotizacion,'id_original_cliente'); ?>
    </center>
    <?php echo CHtml::submitButton('Guardar', array('class'=>'miBotonSuccess boton-default-alt', 'name' => 'button1', 'title'=>'Se debe guardar primero para poder Imprimir o Enviar por mail la cotización')); ?>
    <?php $this->endWidget(); ?>

  <div style="margin-bottom: 15px;">
      <?php 
        if($mostrarBtn== 1)
        {
         echo TbHtml::linkButton('Imprimir', array(
              'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/generarPdf', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'])),
              'icon'=>"icon-printer",
              'style'=> 'margin-right: 10px;',
              'class'=> 'boton-primary-alt',
              ));

          echo TbHtml::ajaxSubmitButton('Enviar a Email', CHtml::normalizeUrl(array('/Joyeria/cotizaciones/generarPdf', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'], 'email'=>1)),
          array(
              'type' => 'post',      
              'beforeSend' => 'function() { $.blockUI({ message: "<strong><img src=\'../cotizador/images/cargando.png\' /> Enviando...</strong>" }); }',         
              'success'=>'function() { 
                $.unblockUI( {onUnblock: function() { 
                    smoke.alert("Correo Enviado!", function(e){
                    }, {
                      ok: "Aceptar",
                      classname: "custom-class"
                    });
                  }
                }); 
              }',         
          ));
        }       
      ?>
  </div>
</div><!-- Termina Form -->

<div class="row">
  <div class="span4">
    <!-- Agregar porcentaje global a los productos -->
    <?php if(Yii::app()->session['rol_usuario']=='usecommerce' || Yii::app()->session['rol_usuario']=='admin'){ ?>
      <span>Aumentar precio a todos los productos</span>
      <input type="number" id="porcentajeGlobal" min="0" max="100">% 
      <button id="btnPorcentajeGlobal" type="button">Aplicar</button>
    <?php } ?>
  </div>
</div>

<div class="row">
<div class="offset3"></div>
<div class="offset4 span3">
  <?php 
    //Botón para agregar producto manualmente
    echo TbHtml::linkButton('Agregar Producto Manualmente', array(
    'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/agregarProductoManual', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'])),
    'class'=>'fancyBox',
    'icon'=>"icon-plus",
    'style'=>"margin-bottom: 10px;",
    ));  
  ?>
  </div>

  <div class="span3">
  <?php 
    //Botón para lanzar CgridView en Dialog
    echo TbHtml::linkButton('Agregar Productos', array(
      'id'=>"agregarProducto",
      'icon'=>"icon-plus",
      'title'=>"Agregar productos a la cotización",
      'class'=>"boton-primary-alt",
    ));  
  ?>
  </div>
</div>

<div>
  <?php 
      $this->widget('bootstrap.widgets.TbGridView', array(
         'id'=>'Cotizaciones-grid',
         'dataProvider' => $modelCotTmp->search(),
         'type' => TbHtml::GRID_TYPE_CONDENSED,
         'emptyText'=> 'Resultados no encontrados',
         'filter' => $modelCotTmp,
         'ajaxUpdate'=> true,
         'afterAjaxUpdate' => "function(id,data){
            $('.fancyBox').fancybox({'scrolling':'false','titleShow':true, 
            'showCloseButton': true, 'hideOnOverlayClick': false,});
                      }",
         'columns' => array(
              array(
                'name'=>'nombre',
                'value'=>'CHTML::textField($modelCotTmp, $data->nombre, array("title"=>$data->nombre, "id"=> $data->id."producto", \'style\'=> \'width: 180px;\', "onchange"=>"js: $(function(){    
                          var des= $data->id;
                          var textfieldvalue = \'#\'+$data->id+\'producto\';
                          var textfieldvalue = $(textfieldvalue).val();

                          $.ajax({
                              context: this,
                              type: \'POST\',
                              data: { \'nombreModificado\': textfieldvalue, \'id_cotizacion\': des},
                              url: \'index.php?r=Joyeria/productos/seleccionProductos\',
                              complete: function() { $.fn.yiiGridView.update(\'Cotizaciones-grid\'); }
                          })  
                          return false;
                           });",
                  ));',
                'type'=>'raw',
                'filter'=>false
              ),
              array(
                'name'=> 'sku_producto',
                'value'=> '$data->product->reference',
                'htmlOptions' => array('style' => 'width: 10px;')
                ),
              array(
                'header'=>'Cantidad',
                'value'=>'CHTML::textField($modelCotTmp, $data->cantidad_tmp, array("id"=> $data->id."cantidad", \'style\'=> \'width: 30px;\', "onchange"=>"js: $(function(){    
                          var des= $data->id;
                          var textfieldvalue = \'#\'+$data->id+\'cantidad\';
                          var textfieldvalue = $(textfieldvalue).val();

                          $.ajax({
                              context: this,
                              type: \'POST\',
                              data: { \'cantidadModificada\': textfieldvalue, \'id_cotizacion\': des},
                              url: \'index.php?r=Joyeria/productos/seleccionProductos\',
                              complete: function() { $.fn.yiiGridView.update(\'Cotizaciones-grid\'); }
                          })  
                          return false;
                           });",
                  )).CHtml::hiddenField($modelCotTmp, $data->id, array("class"=>"idCotOculto"));',
                'type'=>'raw',
                'htmlOptions'=>array('title'=> 'Cantidad de productos a la cotización',
                  'class'=>'cantidadConId'),
              ),
              array(
                'type'=> 'raw',
                'header'=> 'Tipo de Precio',
                'value'=> 'CHtml::dropDownList($data->product->id_product, $data->selected_price,
                  array("empty"=>"---", $data->product->precio_lista=> $data->product->precio_lista." Lista", $data->product->precio_mm=> $data->product->precio_mm." Mm", $data->product->precio_mayoreo=> $data->product->precio_mayoreo." Mayoreo"),
                  array("id"=>"tp".$data->product->id_product, "disabled"=> $data->producto_propio== 1? "disabled" : "", "onchange"=>"js: $(function(){ 
                    var des= $data->id;
                    var dt= {$data["product"]["id_product"]};
                    var dt= \'tp\'+dt;
                    var e = document.getElementById(dt);    
                    var dropdownvalue = e.options[e.selectedIndex].value;
                    if(dropdownvalue!= \'empty\'){
                      $.ajax({
                          context: this,
                          type: \'POST\',
                          data: { \'precioModificado\': dropdownvalue, \'id_cotizacion\': des, \'precioSel\': 1},
                          url: \'index.php?r=Joyeria/productos/seleccionProductos\',
                          complete: function() { 
                            $.fn.yiiGridView.update(\'Cotizaciones-grid\'); 
                          }
                      }) 
                    }
                  });")
                  );',
                'visible' => Yii::app()->session['rol_usuario']=='usecommerce' || (Yii::app()->request->cookies['tipodispositivo']->value==1 && Yii::app()->session['rol_usuario']!='vendedor')? false : true
              ),
              array(
                'name'=> 'precio_unitario',
                'value'=>function($data){
                        return number_format($data->precio_unitario*1.16, 2, '.', '');
                },
                'filter'=>false,
                // Si el rol es admin o usecommerce se muestra la columna
                'visible' => Yii::app()->session['rol_usuario']=='usecommerce' || Yii::app()->session['rol_usuario']=='admin'? true : false,
                'htmlOptions'=>array('class'=>'precioUnitario', 'id'=>'$data->id'.$data->id, 'style' => 'width: 100px;',
                  'title'=> 'Precio Unitario Original')
              ),
              array(
                'header'=>'Precio Unitario Modificado',
                'value'=>'CHTML::textField($modelCotTmp, number_format($data->precio_modificado*1.16, 2, ".", ""), array("id"=> $data->id, \'style\'=> \'width: 70px;\', "onchange"=>"js: $(function(){    
                          var id= $data->id;
                          var textfieldvalue = \'#\'+id;
                          var textfieldvalue = $(textfieldvalue).val();

                          $.ajax({
                              context: this,
                              type: \'POST\',
                              data: { \'precioModificado\': textfieldvalue, \'id_cotizacion\': id},
                              url: \'index.php?r=Joyeria/productos/seleccionProductos\',
                              complete: function() { $.fn.yiiGridView.update(\'Cotizaciones-grid\'); }
                          })  
                          return false;
                           });"
                  ));',
                'type'=>'raw',
                // Si el rol es admin o usecommerce se muestra la columna
                'visible' => Yii::app()->session['rol_usuario']=='usecommerce' || Yii::app()->session['rol_usuario']=='admin'? true : false,
                'htmlOptions'=>array('title'=> 'Puede modificar el costo del producto')
              ),
              /*Por porcentaje*/
              array(
                'header'=>'Precio por Porcentaje',
                'value'=>'CHTML::textField($modelCotTmp, $data->porcentaje, array("maxlength"=>3, "placeholder"=>"%", "id"=> $data->id."-porcentaje", \'style\'=> \'width: 40px;\', "onchange"=>"js: $(function(){    
                          var id= $data->id;
                          var textfieldvalue = \'#\'+id+\'-porcentaje\';
                          var textfieldvalue = $(textfieldvalue).val();
                          $.ajax({
                              context: this,
                              type: \'POST\',
                              data: { \'porcentajeModificado\': textfieldvalue, \'id_cotizacion\': id},
                              url: \'index.php?r=Joyeria/productos/seleccionProductos\',
                              complete: function() { $.fn.yiiGridView.update(\'Cotizaciones-grid\'); }
                          })  
                          return false;
                           });",
                  ));',
                'type'=>'raw',
                // Si el rol es admin o usecommerce se muestra la columna
                'visible' => Yii::app()->session['rol_usuario']=='usecommerce' || Yii::app()->session['rol_usuario']=='admin'? true : false,
                'htmlOptions'=>array('title'=> 'Puede modificar el costo del producto por porcentaje')
              ),
              array(
                'name'=> 'precio_tmp',
                'value'=>function($data){
                    return number_format($data->precio_tmp*1.16, 2, '.', '');
                },
                'filter'=>false,
                'htmlOptions'=>array('style'=>'width: 70px;')
              ),
              array(
                //'header'=>'Opciones',
                'type'=>'raw',
                'value'=>'$data->getEliminar()',
                'htmlOptions'=>array('style'=>'width: 200px; font-size: 20px;')
              ),
          ),
         'htmlOptions' => array('style' => 'padding-top: 10px; overflow-x: auto;')
      ));
  ?>
  </div>

  <?php
    $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target' => '.fancyBox',
        'config' => array(
            'scrolling' => 'false',
            'titleShow' => true,
        ),));
  ?>

  <!-- Se muestra en un Dialog los productos para ser agregados -->
  <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'mydialog',
        // additional javascript options for the dialog plugin
        'options'=>array(
            'title'=>'Listado de Productos',
            'autoOpen'=>false,
            'modal' => true
        ),
    ));

    //Se encierra el contenido, grid con los productos
    echo CHtml::beginForm();
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id'=>'Productos-grid',
        'dataProvider'=>$modelProductos->search(),
        'type' => TbHtml::GRID_TYPE_CONDENSED,
        'emptyText'=> 'Resultados no encontrados',
        'filter'=>$modelProductos,
        'columns'=>array(
            //Muestra imagen del producto sólo en versión desktop y tablet
            array(
                'type'=>'html',
                'header'=>'Imagen',
                'value'=>'$data->getImageProd()',
                'visible'=> Yii::app()->request->cookies['tipodispositivo']->value==1 ? false : true
            ),
            array(
                'name' => 'nombre_producto',
                'value'=> '$data->lang->truncate',  
                'htmlOptions'=> array('style'=>'width: 50%;'),  
            ),
            array(
                'name'=>'price',
                'visible'=> Yii::app()->request->cookies['tipodispositivo']->value==1 ? false : true
            ),
            array(
                'name'=>'reference',
                'visible'=> Yii::app()->request->cookies['tipodispositivo']->value==1 ? false : true
            ),
            array(
                'name'=>'producto.quantity', //this lookup works
                // I need solution here to do filter & search of this relationship data field
            ),
            array(
                'header'=>'Cant.',
                'value'=>'CHTML::textField($data->id_product,$data->cantidadPr,array("id"=>"pro".$data->id_product, "maxlength"=>3, \'style\'=> \'width: 30px;\'))',
                'type'=>'raw'  
            ),
            array(
              'class'=>'CButtonColumn',
              'template'=>'{down}',
              'buttons'=>array(
                  'down' => array(
                      'label'=>'[O]',
                      'click'=>"function(){
                            var linkUrl= $(this).attr('href');
                            var linkDividido = linkUrl.split('&');
                            arrValores= linkDividido[1];
                            
                            var valoresDividido = arrValores.split('=');
                            arrValor= valoresDividido[1];
                            var idProductoRowGrid = $('#pro' + arrValor).val();

                            var cadena= '&cantidad=' + idProductoRowGrid;
                            var linkUrlNuevo = linkUrl.concat(cadena);

                          $.ajax({
                              type: 'POST',
                              url: linkUrlNuevo,
                              complete: function() { 
                                
                                smoke.signal('Producto Agregado', function(e){
                                }, {
                                  duration: 2000,
                                  classname: 'custom-class'
                                });
                                $.fn.yiiGridView.update('Cotizaciones-grid'); 
                              }
                          })
                          return false;
                      }",
                      'url'=>'Yii::app()->createUrl("/Joyeria/productos/seleccionProductos", array("id_producto"=>$data->id_product, "precio"=>$data->price, "token"=>$_GET["token"] ? $_GET["token"] : $_GET["tokenEdt"]))',
                      'options'=>array(
                          'style' => 'font-size: 16px;',
                      ),
                  ),
              ),
            ),
        ),
        'htmlOptions' => array('style' => 'padding-top: 20px;')
      )); 
      echo CHtml::endForm();
     //-----------
    $this->endWidget('zii.widgets.jui.CJuiDialog');
  ?>
  <script>
    $(document).ready(function(){
        $("#agregarProducto").click(function(){
            $("#mydialog").dialog("open");
            $("dialog[role='dialog']").css("left", "0px"); 
            
             //Resetear filtros del grid
             var id='Productos-grid';
             var inputSelector='#'+id+' .filters input, '+'#'+id+' .filters select';
             $(inputSelector).each( function(i,o) {
                  $(o).val('');
             });
             var data=$.param($(inputSelector));
             $.fn.yiiGridView.update(id, {data: data});
            return false;
        });

        // Evento para agregar porcentaje global a los productos
        $("#btnPorcentajeGlobal").click(function(){
          if($("#porcentajeGlobal").val()!= "")
          { 
            var cantidadPorcentaje= $("#porcentajeGlobal").val();
            var idCotizaciones= [];
            var precios= [];
            var k= 0;
            $("#Cotizaciones-grid table.items tr").each(function( i ) {
              $("td", this).each(function( j ) {
                if(i>1){
                  if(j==2){
                    idCotizaciones[k]= $(this).find(".idCotOculto").val();
                    console.log($(this).find(".idCotOculto").val());
                    k++;
                  }
                }
              });
            });

            $.ajax({
               url: 'index.php?r=Joyeria/productos/seleccionProductos',
               data: {
                  arrayIdCotizaciones: idCotizaciones,
                  porcentajeGlobal: 1,
                  cantidadPorcentaje: cantidadPorcentaje
               },
               type: 'POST',      
               success: function(data) {
                  $.fn.yiiGridView.update('Cotizaciones-grid'); alert('Porcentaje Aplicado');
               },
               error: function() {
                  alert('Ha ocurrido un problema, intente de nuevo');
               }
            });
          }
          else
            alert("Debe ingresar un dígito del 1 al 100");
        });
    });
  </script>




