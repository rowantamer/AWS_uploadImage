<?php

use Aws\S3\S3Client;
 class uploadFile{
    private $_s3;

    public function fileSize ($file){

        if($file > 3000000){
            print_r("File Size is too large please upload another file");
            return false;
        }
        return true;
    }
    public function fileType ($file, $type){
        if(!strstr($file, $type) ){
            print_r("please enter file with image extension like .png .jpg .jpeg");
            return false;
        }
        return true;
    }
    public function set_credentials ($key, $secret,$region,$version){
       $this->_s3 = S3Client::factory(array(
            'credentials' => array(
                'key' => $key,
                'secret' => $secret
            ),'region' => $region,
            'version' => $version
        ));
    }

    public function upload(){
       $this->_s3->putObject([
            'Bucket' => 'rowanbucket',
            'Key'    => uniqid(),
            'SourceFile' => $_FILES["fileToUpload"]["tmp_name"]
        ]);
    }
    public function __construct(){
        if(!empty($_FILES)){
            if($this->fileType($_FILES["fileToUpload"]["type"],"image")&&$this->fileSize($_FILES["fileToUpload"]["size"])){
                $this->set_credentials(__KEY__,__SECRET__, __REGION__, __VERSION__);
                 try{
                    $this->upload();
                    echo "File Uploaded successfully ^_^"; 
                 }
                 catch (Aws\S3\Exception\S3Exception $e) {
                    echo "Can't Upload this file.";
                }
            }
        }
    }

 }


?>