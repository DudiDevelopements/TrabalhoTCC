<?php 
    require_once('../../backend/mysql.php');
    header("Content-Type: application/json");

    $idcomprovante = $_POST['comprovanteid'];

    $query_revog = "UPDATE `envios` SET `validado` = '0', 
        `carga_horaria` = NULL WHERE `envios`.`id` = '$idcomprovante'";
    
    
    if($mysql->query($query_revog)) echo json_encode('ok');
    else echo json_encode('fail');

?>