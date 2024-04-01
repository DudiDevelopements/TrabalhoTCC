<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php 
        if (PHP_SESSION_NONE === session_status()) session_start();
        if (isset($_SESSION['adm'])) header('Location: ../');
        require_once('../../backend/mysql.php');
    ?>
</head>

<body>
    <div class="login-container">
        <link rel="stylesheet" type="text/css" href="../../css/index.css">
        <link rel="stylesheet" type="text/css" href="../../css/login.css">
        <div class="logo">
            <img src="../../images/logoifms.png" alt="logoifms">
        </div>
        <strong>Login como professor/servidor</strong>
        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit" name='login_btn'>Entrar</button>
        </form>
        <br>
        <a href="../../">Sou aluno(a)</a>

        <?php
            if (isset($_POST['login_btn'])) {
                if (!isset($_POST['email']) or !isset($_POST['senha'])) {
                    die();
                } else {
                    $email = $mysql->real_escape_string($_POST['email']);
                    $senha = $mysql->real_escape_string($_POST['senha']);

                    $queryRequest = "SELECT * FROM `administradores` WHERE email = '$email' and senha = '$senha'";
                    $queryUsuario = $mysql->query($queryRequest) or die('Erro em bd->query() em login.php');
                    $quantidadeDeUsuariosAchados = $mysql->query("SELECT * FROM `administradores` WHERE email = '$email' 
                    and senha = '$senha'");
                    $quantidadeDeUsuariosAchados = $quantidadeDeUsuariosAchados->num_rows;
                    
                    if ($quantidadeDeUsuariosAchados != 1) {
                        echo '<h3>Usuário não existe</h3>';
                    } elseif ($quantidadeDeUsuariosAchados = 1) {
                        $usuario = $queryUsuario->fetch_assoc();
                        $_SESSION['id'] = $usuario['id'];
                        $_SESSION['nome'] = $usuario['nome'];
                        $_SESSION['email'] = $usuario['email'];
                        $_SESSION['data_nasc'] = $usuario['data_nasc'];
                        $_SESSION['adm'] = TRUE;
                        header("Location: ../../");
                    } else {
                        echo '<span class="form-text">Usuário ou senha incorretos (code: 1)</span>';
                    }
                }
            } 
            
            ?>
    </div>
</body>

</html>