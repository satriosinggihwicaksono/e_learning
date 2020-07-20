<?php

function server(){
    return sprintf(
      "%s://%s%s",
      isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    );
  }
  
if(isset($_FILES['upload']['name'])){
 $file = $_FILES['upload']['tmp_name'];
 $file_name = $_FILES['upload']['name'];
 $file_name_array = explode(".",$file_name);
 $extension = end($file_name_array);
 $new_image_name = time().'.'.$extension;
 $allowed_extension = array("jpg", "gif", "png");

 if(in_array($extension, $allowed_extension))
 {
  move_uploaded_file($file, $new_image_name);
  $function_number = $_GET['CKEditorFuncNum'];
  $url = 'http://'.$_SERVER['SERVER_NAME'].'/e_learning/assets/files/ckeditor/'. $new_image_name;
  $message = '';
  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";

 }

}