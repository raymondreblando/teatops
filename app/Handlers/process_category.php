<?php
require_once '../../init.php';
use Ramsey\Uuid\Uuid;

$c_name = $functions->validate($_POST['c_name']);
$tableDataOne = json_decode($_POST["tableDataOne"], true);
$tableDataTwo = json_decode($_POST["tableDataTwo"], true);

if(empty($c_name)){
       $functions->toast_message("Please provide category name.", "error", "no", "");
}else{
        if (!empty($_FILES["c_image"])) {
            $allowTypes = array('jpg', 'png', 'svg');
            $filename = $_FILES["c_image"]["name"];
            $uploadDir = "../../uploads/category/";
            $getFileExt = pathinfo($filename, PATHINFO_EXTENSION);
            $newFilename = $functions->randomString(25)  ."." . $getFileExt;
            if(!in_array($getFileExt, $allowTypes)){
                $functions->toast_message("Uploaded file not Supported.", "error", "no", "");
            }else{
            foreach ($tableDataOne as $row) {
                $unique_id = Uuid::uuid4()->toString();

                $size = $row[0];
                $price = $row[1];

                $database->DBQuery("INSERT INTO `price` (`p_id`,`category_id`,`p_size`,`p_price`) VALUES (?,?,?,?)",[$unique_id, RANDOM_ID, $size, $price]);
            }

            foreach ($tableDataTwo as $row) {
                $unique_id = Uuid::uuid4()->toString();

                $name = $row[0];
                $price = $row[1];

                $database->DBQuery("INSERT INTO `addons` (`addons_id`,`category_id`,`addons_name`,`addons_price`) VALUES (?,?,?,?)",[$unique_id, RANDOM_ID, $name, $price]);
            }

                move_uploaded_file($_FILES["c_image"]["tmp_name"], $uploadDir . $newFilename);

                $database->DBQuery("INSERT INTO `category` (`category_id`,`category_name`,`category_icon`,`category_date`) VALUES (?,?,?,?)",[RANDOM_ID, $c_name, $newFilename, TODAYS]);

                $functions->toast_message("Category successfully added.", "success", "yes", "");
            }
        }else{
            $functions->toast_message("Please upload image.", "error", "no", "");
        }
}

$database->closeConnection();