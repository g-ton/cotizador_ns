<script src="./js/modulos/cotizacionIndex.min.js" type="text/javascript"></script>

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

<!-- Alerts para validaciones -->
<div>
   <div>
    <div id="mensaje_validacion_error" class="alert alert-danger alert-dismissible" style="display: none">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <span id='mensaje_valor'></span>
    </div>

    <div id="mensaje_validacion_correcto" class="alert alert-success alert-dismissible" style="display: none">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <span id='mensaje_valor'></span>
    </div>
  </div>
</div>

<div class="row" style="margin-bottom: 10px;">
  <div class="span3">
    <?php
      echo TbHtml::linkButton('Crear Otra Cotización', array(
        'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/superIndex')),
        'style' => "margin-bottom: 10px"
        ));
    ?>
  </div>

  <div class="span3">
    <?php
      echo TbHtml::linkButton('Datos del Cliente', array(
        'color'=> TbHtml::BUTTON_COLOR_WARNING, 
        'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/datosCliente', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'])),
        'style'=> 'float: left; margin-bottom: 10px;',
        'icon'=>"icon-mas",
        'class'=>'datosCliente boton-primary-alt'
      ));
    ?>
  </div>

  <div class="span3">
    <?php $token_valor= $_GET['token'] ? $_GET['token'] : $_GET['tokenEdt']; ?>
    <input type="hidden" id="token_input" value=<?php echo $token_valor; ?> >
    <button id='btn_guardar' class='btn boton-default-alt'>Guardar</button>
    <?php
      $this->widget('application.extensions.fancybox.EFancyBox', array(
        'target' => '.datosCliente',
        'config' => array(
            'titleShow' => true,
            ),
      ));
    ?>
  </div>
</div>

<!-- Controles para Enviar por mail e imprimir cotización ya Guardada -->
<div class="row">
  <div class='span6' id='controles_cotizacion' style="margin-bottom: 15px; display: none;">
    <?php 
      echo TbHtml::linkButton('Imprimir', array(
        'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/generarPdf', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'])),
        'icon'=>"icon-printer",
        'style'=> 'margin-right: 10px;',
        'class'=> 'boton-primary-alt'
      ));

      echo TbHtml::ajaxSubmitButton('Enviar a Email', CHtml::normalizeUrl(array('/Joyeria/cotizaciones/generarPdf', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'], 'email'=>1)),
      array(
        'type' => 'post',      
        'beforeSend' => 'function() { $.blockUI({ message: "<strong><img src=\'../cotizador/images/cargando.png\' /> Enviando...</strong>" }); }',         
        'success'=>'function(data) { 
          var data = $.parseJSON(data);

          $.unblockUI( {onUnblock: function() { 
              smoke.alert(data.mensaje, function(e){
              }, {
                ok: "Aceptar",
                classname: "custom-class"
              });
            }
          }); 
        }',         
      ));      
    ?>
  </div>
</div>

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

<div class="row pull-right">
  <div class="span3">
    <?php 
      //Botón para agregar producto manualmente
      echo TbHtml::linkButton('Agregar Producto Manualmente', array(
      'url' => CHtml::normalizeUrl(array('/Joyeria/cotizaciones/agregarProductoManual', 'token'=>$_GET['token'] ? $_GET['token'] : $_GET['tokenEdt'])),
      'class'=>'fancyBox',
      'icon'=>"icon-mas",
      'style'=>"margin-bottom: 10px;",
      ));  
    ?>
  </div>

  <div class="span3">
    <?php 
      //Botón para lanzar CgridView en Dialog
      echo TbHtml::linkButton('Agregar Productos', array(
        'id'=>"agregarProducto",
        'icon'=>"icon-mas",
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
                              complete: function() { 
                                $.fn.yiiGridView.update(\'Cotizaciones-grid\', {
                                    complete: function(jqXHR, status) {
                                        if (status==\'success\'){
                                          agregarTotal();
                                        }
                                    }
                                });
                              }
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
                            $.fn.yiiGridView.update(\'Cotizaciones-grid\', {
                                complete: function(jqXHR, status) {
                                    if (status==\'success\'){
                                      $(\'#\' + des + \'-porcentaje\').removeAttr(\'value\');
                                      agregarTotal();
                                    }
                                }
                            });
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
                'htmlOptions'=>array('class'=>'precioUnitario', 'style' => 'width: 100px;',
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
                              complete: function() { 
                                $.fn.yiiGridView.update(\'Cotizaciones-grid\', {
                                    complete: function(jqXHR, status) {
                                        if (status==\'success\'){
                                          agregarTotal();
                                        }
                                    }
                                });
                              }
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
                              complete: function() { 
                                $.fn.yiiGridView.update(\'Cotizaciones-grid\', {
                                    complete: function(jqXHR, status) {
                                        if (status==\'success\'){
                                          agregarTotal();
                                        }
                                    }
                                }); 
                              }
                          });
                          return false;
                    });",
                  ));',
                'type'=>'raw',
                // Si el rol es admin o usecommerce se muestra la columna
                'visible' => Yii::app()->session['rol_usuario']=='usecommerce' || Yii::app()->session['rol_usuario']=='admin'? true : false,
                'htmlOptions'=>array('title'=> 'Puede modificar el costo del producto por porcentaje')
              ),
              //Precio Total
              array(
                'name'=> 'precio_tmp',
                'value'=>function($data){
                    return number_format($data->precio_tmp*1.16, 2, '.', '');
                },
                'filter'=>false,
                'htmlOptions'=>array('style'=>'width: 70px;', 'class'=>'precio_total')
              ),
              array(
                //'header'=>'Opciones',
                'type'=>'raw',
                'value'=>'$data->getEliminar()',
                'htmlOptions'=>array('style'=>'width: 200px; font-size: 20px;')
              ),
          ),
         'htmlOptions' => array('style' => 'padding-top: 10px; overflow-x: auto; clear: right;')
      ));
  ?>
    <table id='tabla_total' class="items table table-condensed">
      <tr>
        <td><b>Subtotal</b></td>
        <td id='campo_subtotal'>0.00</td>
      </tr>
      <tr>
        <td><b>Total</b></td>
        <td id='campo_total'>0.00</td>
      </tr>
    </table>
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
                'name'=>'producto.quantity'
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
                      'label'=>'<span class="icon-mas"></span>',
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
                                $.fn.yiiGridView.update('Cotizaciones-grid', {
                                    complete: function(jqXHR, status) {
                                        if (status=='success'){
                                          agregarTotal();
                                        }
                                    }
                                });
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