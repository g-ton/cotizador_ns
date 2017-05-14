<?php

class DefaultController extends Controller
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
                'actions'=>array('index', 'nuevo', 'eliminar', 'exportarExcel'),
                'roles'=>array('admin'),
            ),

              array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index', 'exportarExcel'),
                'roles'=>array('normal'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	public function actions() 
	{
        return array(
            'index' => 'application.modules.Joyeria.controllers.default.actionIndex',
            'nuevo' => 'application.modules.Joyeria.controllers.default.actionNuevo',
            'eliminar' => 'application.modules.Joyeria.controllers.default.actionEliminar',
            'exportarExcel' => 'application.modules.Joyeria.controllers.default.actionExportarExcel',
        );
    }
}