<?php 
    require_once('../../backend/mysql.php');
    header("Content-Type: application/json");

    $comprovanteid = $_POST['comprovanteid'];
    $carga = $_POST['cargahoraria'];
    
    if(!empty($carga)){
        $update = "UPDATE `envios` SET `validado` = '1', 
        `carga_horaria` = '$carga' WHERE `envios`.`id` = '$comprovanteid'";
        if($mysql->query($update)) {
            echo json_encode($carga);
        } else echo json_encode("Falha ao validar");
    } else {
        echo json_encode("Erro");
    }
    
?>