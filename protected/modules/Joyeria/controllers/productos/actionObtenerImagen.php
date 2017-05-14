<?php

class actionObtenerImagen extends CAction {

        public $something;
    public function run() 
    {
        $tempFolder = Yii::getPathOfAlias('webroot').'/temp';

        if(!file_exists($tempFolder) && !is_dir($tempFolder)) mkdir($tempFolder, 0777, TRUE);
        if(!file_exists($tempFolder.'/chunks') && !is_dir($tempFolder.'/chunks')) mkdir($tempFolder.'/chunks', 0777, TRUE);

        Yii::import("ext.EFineUploader.qqFileUploader");

        $uploader = new qqFileUploader();
        $uploader->allowedExtensions = array('jpg','jpeg');
        $uploader->sizeLimit = 6 * 1024 * 1024;//maximum file size in bytes
        $uploader->chunksFolder = $tempFolder.'chunks';

        $result = $uploader->handleUpload($tempFolder);
        $result['filename'] = $uploader->getUploadName();
        //$result['folder'] = $webFolder;

        //Función para reducir imagen
        $rutaArchivo= $tempFolder."/".$result['filename'];
        $image = Yii::app()->image->load($rutaArchivo);
        //$image->resize(400, 100)->rotate(-45)->quality(75)->sharpen(20);
        $tempFolderThumbs = Yii::getPathOfAlias('webroot').'/temp/thumbs/'.$result['filename'];
        $image->resize(400, 100)->quality(85);
        $image->save($tempFolderThumbs);
        // -------------------

        header("Content-Type: text/plain");
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
        Yii::app()->end();
    }

}
