<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['data_nasc']);
unset($_SESSION['nome']);
unset($_SESSION['id']);
if(isset($_SESSION['cpf'])) unset($_SESSION['cpf']);
if(isset($_SESSION['email'])) unset($_SESSION['email']);
if(isset($_SESSION['adm'])) unset($_SESSION['adm']);
session_destroy();
?>

<html>
    <head>
    <?php 
    header("Location: ./");
    ?>    
    </head>
    <body>
        <?php
        echo "<br>";
        var_dump($_SESSION); ?>
    </body>
</html>
