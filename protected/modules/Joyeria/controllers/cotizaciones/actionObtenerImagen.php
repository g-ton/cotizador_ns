<?php

class actionObtenerImagen extends CAction {

    public $something;
    public function run() 
    {
        $tempFolder = Yii::getPathOfAlias('webroot').'/temp';

        if(!file_exists($tempFolder) && !is_dir($tempFolder)) mkdir($tempFolder, 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('png');
        $uploader->sizeLimit = 2 * 1024 * 1024;//maximum file size in bytes

        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();

        //Función para reducir imagen
        $rutaArchivo= $tempFolder."/".$result['filename'];
        $image = Yii::app()->image->load($rutaArchivo);
        $tempFolderThumbs = Yii::getPathOfAlias('webroot').'/temp/thumbs/'.$result['filename'];
        $image->resize(400, 73)->quality(90);
        $image->save($tempFolderThumbs);
        // -------------------

        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
    }

}
