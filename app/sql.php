<?php
define('DB_HOST','localhost');
define('DB_USER','kbt_user');
define('DB_PASSWORD','kbt_2019');
define('DB_NAME','kbt_poc_2019');
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysqli_select_db($link, DB_NAME);

$sql="ALTER TABLE `inventario` CHANGE `ini_placa` `ini_placa` VARCHAR(15) NULL DEFAULT NULL COMMENT 'Placa del equipo';";
$result = mysqli_query($link,$sql);
if ($result){
    echo "ok";
}
else {
    echo $sql."->".mysqli_error($link);
}

 ?>
