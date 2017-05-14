<?php

class CotizacionesController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index', 'agregarProductos', 'eliminar', 'generarPdf', 'superIndex', 
                    'descargarPdf', 'eliminarGral', 'agregarProductoManual', 'clientesCotizacion', 'configurarDatos',
                    'obtenerImagen', 'indexClientes', 'eliminarCliente'),
                'roles'=>array('admin', 'usecommerce'),
            ),

            array('allow',
                'actions'=>array('index', 'agregarProductos', 'eliminar', 'generarPdf', 'superIndex', 
                    'descargarPdf', 'eliminarGral', 'agregarProductoManual', 'clientesCotizacion', 'indexClientes', 'eliminarCliente'),
                'roles'=>array('vendedor'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actions() 
	{
        return array(
            'superIndex' => 'application.modules.Joyeria.controllers.cotizaciones.actionSuperIndex',
            'index' => 'application.modules.Joyeria.controllers.cotizaciones.actionIndex',
            'agregarProductos' => 'application.modules.Joyeria.controllers.cotizaciones.actionAgregarProductos',
            'eliminar' => 'application.modules.Joyeria.controllers.cotizaciones.actionEliminar',
            'generarPdf' => 'application.modules.Joyeria.controllers.cotizaciones.actionGenerarPdf',
            'descargarPdf' => 'application.modules.Joyeria.controllers.cotizaciones.actionDescargarPdf',
            'eliminarGral' => 'application.modules.Joyeria.controllers.cotizaciones.actionEliminarGral',
            'agregarProductoManual' => 'application.modules.Joyeria.controllers.cotizaciones.actionAgregarProductoManual',
            'clientesCotizacion' => 'application.modules.Joyeria.controllers.cotizaciones.actionClientesCotizacion',
            'configurarDatos' => 'application.modules.Joyeria.controllers.cotizaciones.actionConfigurarDatos',
            'obtenerImagen' => 'application.modules.Joyeria.controllers.cotizaciones.actionObtenerImagen',
            'indexClientes' => 'application.modules.Joyeria.controllers.cotizaciones.actionIndexClientes',
            'eliminarCliente' => 'application.modules.Joyeria.controllers.cotizaciones.actionEliminarCliente',
        );
    }

    /**
     * params tipo date(Y-m-d)
     *return diferencia restante entre las dos fechas
     */
    public function dias_vigencia($fecha_i, $fecha_f)
    {
        $dias   = (strtotime($fecha_i)-strtotime($fecha_f))/86400;
        $dias   = abs($dias); $dias = floor($dias);     
        return $dias;
    }
}