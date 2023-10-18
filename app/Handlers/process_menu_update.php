<?php
require_once '../../init.php';

$identifier = $functions->validate($_POST['identifier']);
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
                    $database->DBQuery("SELECT `menu_id`, `menu_photo` FROM `menu` WHERE `menu_id` = ?",[$identifier]);
                    $row = $database->fetch();

                    $existing_photo = $uploadDir.$row->menu_photo;
                    
                    unlink($existing_photo);

                    move_uploaded_file($_FILES["product_img"]["tmp_name"], $uploadDir . $newFilename);

                    $database->DBQuery("UPDATE `menu` SET `menu_name`=?,`category_id`=?,`menu_stock`=?,`menu_photo`=? WHERE `menu_id` = ?",[$menu_name, $menu_category, $stocks, $newFilename, $identifier]);
                    $functions->toast_message("Menu successfully updated.", "success", "yes", "");
              }
          }else{
                $database->DBQuery("UPDATE `menu` SET `menu_name`=?,`category_id`=?,`menu_stock`=? WHERE `menu_id` = ?",[$menu_name, $menu_category, $stocks, $identifier]);
                $functions->toast_message("Menu successfully updated.", "success", "yes", "");
          }
}

$database->closeConnection();