<?php

class actionIndex extends CAction {

    public function run() 
    {
        $arrayInfonavit['1'] = "INFONAVIT TRADICIONAL";
        $arrayInfonavit['2'] = "INFONAVIT TOTAL";
        $arrayInfonavit['3'] = "COFINAVIT";
        $arrayInfonavit['4'] = "INFONAVIT LINEA IV (Reparación/Ampliación)";
        $arrayInfonavit['5'] = "INFONAVIT LINEA V (Pago de pasivos)";
        $arrayInfonavit['6'] = "INFONAVIT LINEA III (Construcción en terreno propio)";

        if($_POST['valorInfonavit']!=NULL && $_POST['metrosCuadrados']!=NULL)
        {
            $m2= $_POST['metrosCuadrados'];

            if($_POST['valorInfonavit']<=5)
            {
                if($m2<=40)
                    $precio= "$1,260.00";

                if($m2>40 && $m2<=60)
                    $precio= "$1,386.00";

                 if($m2>60 && $m2<=100)
                    $precio= "$1,450.00";
            }

            else
            {
                if($m2<=40)
                    $precio= "$2,038.00";

                if($m2>40 && $m2<=60)
                    $precio= "$2,344.00";

                 if($m2>60 && $m2<=100)
                    $precio= "$2,587.00";
            }
        }
  
        // if(isset($_GET['Categorias']))
        //     $model->attributes=$_GET['Categorias'];
 
        $this->controller->render('index',array(
            'arrayInfonavit'=>$arrayInfonavit, 'precio'=>$precio
        ));
    }

}
