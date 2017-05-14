<?php

class actionExportarExcel extends CAction {

    public function run() 
    {
        $criteria= Yii::app()->session['criteriaSession'];
       
        $dataprovider= new  CActiveDataProvider('Categorias',array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
               
        set_time_limit(0);

       $this->controller->widget('application.extensions.EExcelView',
                array(
                'dataProvider'=> $dataprovider,
                'columns'=>  array(            
                'nombre_categoria',             
                ),

                'title'=>'Lista_Categorías'.date('d-m-Y'),
                'autoWidth'=>true,
            ));
    }
}


