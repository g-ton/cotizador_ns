<?php

class ProductosController extends Controller
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
                'actions'=>array('index', 'nuevo', 'eliminar', 'exportarExcel', 'obtenerImagen', 'seleccionProductos'),
                'roles'=>array('admin', 'usecommerce'),
            ),

            array('allow',
                'actions'=>array('index', 'nuevo', 'eliminar', 'seleccionProductos'),
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
            'index' => 'application.modules.Joyeria.controllers.productos.actionIndex',
            'nuevo' => 'application.modules.Joyeria.controllers.productos.actionNuevo',
            'eliminar' => 'application.modules.Joyeria.controllers.productos.actionEliminar',
            'exportarExcel' => 'application.modules.Joyeria.controllers.productos.actionExportarExcel',
            'obtenerImagen' => 'application.modules.Joyeria.controllers.productos.actionObtenerImagen',
            'seleccionProductos' => 'application.modules.Joyeria.controllers.productos.actionSeleccionProductos',
        );
    }
}