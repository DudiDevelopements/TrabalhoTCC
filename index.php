<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['id'])) {
            echo 'Página Inicial';
        } else {
            echo 'Autenticação';
        }
        ?>
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
    
    <?php  
    require_once('backend/mysql.php');
    if(isset($_SESSION['id'])) {  
        include('meuperfil/index.php');
    } else {
        include('login/index.php');
    }
    
    
    ?> 
</body>
</html>
