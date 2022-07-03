<?php

include "Database.php";

    class File extends Database{

        //Check NId Exists
        public function nIdCheck($data){
            $sql = "SELECT * FROM files WHERE nId = '$data'";
            $statement = $this->conn->prepare($sql);
            $statement->execute();      
            if( $statement->rowCount() > 0 ){
                return true;
            }else{
                return false;
            } 
        }

        //Check Ref No Exists
        public function rIdCheck($data){
            $sql = "SELECT * FROM files WHERE rId = '$data'";
            $statement = $this->conn->prepare($sql);
            $statement->execute();      
            if( $statement->rowCount() > 0 ){
                return true;
            }else{
                return false;
            } 
        }

        //Check FILE Status
        public function pdfFileCheck($file, $file_path =''){
            $file_name = $file['name'];
            $file_tmp_name = $file['tmp_name'];
            $file_size = $file['size'];

            //GET FILE EXTENSION
            $file_arr = explode('.', $file_name);
            $file_beforeDot = array_shift(explode('.', $file_name));
            $file_extension = strtolower(end($file_arr));           

            // GET NEW FILE NAME
            $file_name = date('m-d-Y_H-i-s').'_'.$file_beforeDot.'.'.$file_extension;

             //GET FILE FORMAT
            $file_format = ['pdf'];
           
            $fileErrMsg = '';

            if(empty($file['name'])){
                $fileErrMsg = 'Required';
            }elseif (in_array($file_extension, $file_format) == false){
                $fileErrMsg = 'Invalid file format';          
            }elseif ($file_size >= 1000000) {
                $fileErrMsg = 'File is too large';
            }else {
                //FILE MOVE TO FOLDER
                move_uploaded_file($file_tmp_name, $file_path.$file_name); 
            }
            return [
                'fileErrMsg'       => $fileErrMsg,
                'fileName'         => $file_name
            ];
        }       

       //Add Douments
        public function addUserDocument($nId, $rId, $fname){
            $sql= "INSERT INTO files (nId, rId, fname) VALUES('$nId', '$rId', '$fname') ";           
            $Statement= $this->conn->prepare($sql);
            $Statement->execute();
        }

        //Display specific User Documents
        public function displayUserDocument($nId, $rId){
            $sql = "SELECT * FROM files WHERE nId = '$nId' OR rId = '$rId'";
            $statement= $this->conn->prepare($sql);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);         
        }


    }


?>