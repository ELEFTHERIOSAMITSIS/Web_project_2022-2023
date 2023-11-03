<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_FILES['file']['name'])){
   // file name
   $filename = $_FILES['file']['name'];

   // Location
   $location = '/var/www/html/web/uploaded_files/'.$filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("json");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
             $response = 1;
        } 
   }

   echo $response;
   exit;
}
?>