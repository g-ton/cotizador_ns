$(document).ready(function(){

  //Evento que guarda la cotización y manda mensajes de validación 
  $('#btn_guardar').click(function(){
    var token_valor= $('#token_input').attr('value');
    $.ajax({
       url: 'index.php?r=Joyeria/cotizaciones/index',
       data: {
          token: token_valor,
          guardar: 1
       },
       type: 'GET',      
       beforeSend: function(){
          $.blockUI({ message: '<strong><img src="../cotizador/images/cargando.png" /> Guardando...</strong>' });
       },
       success: function(data) {
        var data = $.parseJSON(data);
        if(data.error== 1){
          $('#controles_cotizacion').css('display', 'none');
          $('#mensaje_validacion_error').css('display', 'block');
          $('#mensaje_validacion_correcto').css('display', 'none');

          $('#mensaje_validacion_error #mensaje_valor').empty();
          $('#mensaje_validacion_error #mensaje_valor').append(data.mensaje);
        } else{
          $('#controles_cotizacion').css('display', 'block');
          $('#mensaje_validacion_correcto').css('display', 'block');
          $('#mensaje_validacion_error').css('display', 'none');

          $('#mensaje_validacion_correcto #mensaje_valor').empty();
          $('#mensaje_validacion_correcto #mensaje_valor').append(data.mensaje);
        }
       },
       error: function() {
          $('#controles_cotizacion').css('display', 'none');
          smoke.alert("Ha ocurrido Error, intente más tarde", function(e){
            }, {
              ok: "Aceptar",
              classname: "custom-class"
          });
       },
        complete: function(){
          $.unblockUI();
        }
    });
  });

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

  // Evento para agregar porcentaje global a los productos de la cotización
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