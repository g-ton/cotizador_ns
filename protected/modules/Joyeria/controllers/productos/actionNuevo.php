<?php
// ActionNuevo PRODUCTOS
class actionNuevo extends CAction {

    public function run($id_producto= null) 
    {
        //$id_producto= $_GET['id_producto']; 
        // Valores por default para los campos hidden e imágenes
        $input1= "vacio1";
        $imagen1= "./images/sinImagen.jpg";
        $input2= "vacio2";
        $imagen2= "./images/sinImagen.jpg"; 
        $input3= "vacio3";
        $imagen3= "./images/sinImagen.jpg";
        $input4= "vacio4";
        $imagen4= "./images/sinImagen.jpg";
        //----------------
        
        if($id_producto!=NULL)
        {                              
            $model =  Productos::model()->findByPk($id_producto);
            $model2 = new Imagenes;
            $modelImagenes =  Imagenes::model()->findAll('id_producto=?', array($id_producto));

            // Se obtienen las imágenes del producto para editar
            $i=1;
            $tamImagenesArray= sizeof($modelImagenes);

            if($tamImagenesArray>0)
            {    
                foreach ($modelImagenes as $imagenesArray) 
                {
                    if($i<= $tamImagenesArray)
                    {
                        if($i==1)
                            $imagen1= $imagenesArray->ruta;
                        
                        if($i==2)
                            $imagen2= $imagenesArray->ruta;
                        
                        if($i==3)
                            $imagen3= $imagenesArray->ruta;
                        
                        if($i==4)
                            $imagen4= $imagenesArray->ruta;
                    }
                    $i++;
                }
            }
            //--------
        }
         
        else
        {
            $model = new Productos;
            $model2 = new Imagenes;
        }

            if(isset($_POST['Productos']))
            {                  
                $model->attributes = $_POST['Productos'];
                $model->estatus = 'ACTIVO';

                $model2->attributes = $_POST['Imagenes'];

                /////// Se obtiene las imágenes
                if(isset($_POST['hiddenImg1']) || isset($_POST['hiddenImg2']) || isset($_POST['hiddenImg3']) || isset($_POST['hiddenImg4']))
                {
                    if($_POST['hiddenImg1']!="vacio1")
                    {
                        $imagen1= $_POST['hiddenImg1'];
                        $input1= $_POST['hiddenImg1'];
                        $model2->ruta0= $_POST['hiddenImg1'];
                    }

                    if($_POST['hiddenImg2']!="vacio2")
                    {
                        $imagen2= $_POST['hiddenImg2'];
                        $input2= $_POST['hiddenImg2'];
                        $model2->ruta1= $_POST['hiddenImg2'];
                    } 

                    if($_POST['hiddenImg3']!="vacio3")
                    {
                        $imagen3= $_POST['hiddenImg3'];
                        $input3= $_POST['hiddenImg3'];
                        $model2->ruta2= $_POST['hiddenImg3'];
                    }

                    if($_POST['hiddenImg4']!="vacio4")
                    {
                        $imagen4= $_POST['hiddenImg4'];
                        $input4= $_POST['hiddenImg4'];
                        $model2->ruta3= $_POST['hiddenImg4'];
                    }
                } ////////  

                //Parte hardcodeada para poder pasar la validación del modelo "Imagenes"
                $model2->id_producto= 5;
                $model2->estatus= 'ACTIVO';
                //Parte hardcodeada para poder pasar la validación

                $valid= $model->validate();
                $valid= $model2->validate() && $valid;

                if($valid)
                {
                    if($model->save())
                    {
                        if($tamImagenesArray>0)
                        {
                            $imagesArray= array();
                            $imagesArray[0]= $model2->ruta0;
                            $imagesArray[1]= $model2->ruta1;
                            $imagesArray[2]= $model2->ruta2;
                            $imagesArray[3]= $model2->ruta3;

                            $i= 0;
                            foreach ($imagesArray as $key) 
                            {
                                if($key!=NULL)
                                {   
                                    if($i< $tamImagenesArray)
                                    {
                                        $modelImagenes[$i]->ruta= $key;
                                        $modelImagenes[$i]->id_producto= $model->id;
                                        $modelImagenes[$i]->estatus= 'ACTIVO';
                                        $modelImagenes[$i]->save();
                                    }

                                    else
                                    {
                                        $model2= new Imagenes;
                                        $model2->ruta= $key;
                                        $model2->id_producto= $model->id;
                                        $model2->estatus= 'ACTIVO';
                                        $model2->save();
                                    }
                                } 
                                $i++;                    
                            }
                        }

                        else
                        {
                            $imagesArray= array();
                            $imagesArray[0]= $model2->ruta0;
                            $imagesArray[1]= $model2->ruta1;
                            $imagesArray[2]= $model2->ruta2;
                            $imagesArray[3]= $model2->ruta3;

                            foreach ($imagesArray as $key) 
                            {
                                if($key!=NULL)
                                {   $model2= new Imagenes;
                                    $model2->ruta= $key;
                                    $model2->id_producto= $model->id;
                                    $model2->estatus= 'ACTIVO';
                                    $model2->save();
                                }                     
                            }
                        }
 
                        $this->controller->redirect(Yii::app()->createUrl('/Joyeria/productos'));
                        Yii::app()->end();
                    }
                }   
            }//fin if isset

        $modelCategorias= Categorias::model()->findAll();
        $listCategorias = CHtml::listData($modelCategorias, 'id', 'nombre_categoria');

        $this->controller->render("nuevo", array('model' => $model, 'model2' => $model2, 
            'id_producto' => $id_producto, 'listCategorias' => $listCategorias, 
            'imagen1' => $imagen1, 'input1' => $input1,
            'imagen2' => $imagen2, 'input2' => $input2,
            'imagen3' => $imagen3, 'input3' => $input3,
            'imagen4' => $imagen4, 'input4' => $input4), false, true);
    }

}
