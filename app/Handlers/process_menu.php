<?php
require_once '../../init.php';

$menu_name = $functions->validate($_POST['menu_name']);
$menu_category = $functions->validate($_POST['menu_category']);
$stocks = $functions->validate($_POST['stocks']);

if(empty($menu_name) OR empty($menu_category) OR empty($stocks)){
       $functions->toast_message("Please fill-up all the fields.", "error", "no", "");
}else{
       if (!empty($_FILES["product_img"])) {
              $allowTypes = array('jpg', 'png', 'jpeg');
              $filename = $_FILES["product_img"]["name"];
              $uploadDir = "../../uploads/menu/";
              $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
              $newFilename = $functions->randomString(25)  ."." . $getFileExt;
              if(!in_array($getFileExt, $allowTypes)){
                  $functions->toast_message("Uploaded file not Supported.", "error", "no", "");
              }else{
                  move_uploaded_file($_FILES["product_img"]["tmp_name"], $uploadDir . $newFilename);
                  $database->DBQuery("INSERT INTO `menu` (`menu_id`,`menu_name`,`category_id`,`menu_stock`,`menu_photo`,`menu_date`) VALUES (?,?,?,?,?,?)",[RANDOM_ID, $menu_name, $menu_category, $stocks, $newFilename, TODAYS]);
                  $functions->toast_message("Menu successfully added.", "success", "yes", "");
              }
          }else{
              $functions->toast_message("Please upload image.", "error", "no", "");
          }
}

$database->closeConnection();