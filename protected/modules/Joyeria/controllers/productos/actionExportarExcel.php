<?php

class actionExportarExcel extends CAction {

    public function run() 
    {
        $criteria= Yii::app()->session['criteriaSession'];
       
        $dataprovider= new  CActiveDataProvider('Productos',array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
               
        set_time_limit(0);

       $this->controller->widget('application.extensions.EExcelView',
                array(
                'dataProvider'=> $dataprovider,
                'columns'=>  array(             
                    'clave',
                    'nombre',
                    'precio',
                    'descripcion',         
                ),

                'title'=>'Lista_Productos'.date('d-m-Y'),
                'autoWidth'=>true,
            ));
    }
}


