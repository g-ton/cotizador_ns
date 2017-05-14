<?php
//Es un ejemplo para el cliente Viasc
class EjemploController extends Controller
{
	public function actions() 
	{
        return array(
            'index' => 'application.modules.Joyeria.controllers.ejemplo.actionIndex',
            'nuevo' => 'application.modules.Joyeria.controllers.ejemplo.actionNuevo',
            'eliminar' => 'application.modules.Joyeria.controllers.ejemplo.actionEliminar',
            'exportarExcel' => 'application.modules.Joyeria.controllers.ejemplo.actionExportarExcel',
        );
    }
}