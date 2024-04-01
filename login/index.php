
<div class="login-container">
    
    <link rel="stylesheet" type="text/css" href="css/login.css">
        <div class="logo">
            <img src="images/logoifms.png" alt="logoifms">
        </div>
        <strong>Login como estudante</strong>
        <form id="login-form" action="" method="POST">
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" maxlength="14" id="cpf" name="cpf" required>
            </div>
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="text" id="data_nascimento" maxlength="10" name="data_nasc" required>
            </div>
            <button type="submit" name='login_btn'>Entrar</button>
        </form>
        
        <a href="adm/login/">Sou professor/servidor</a>

        <?php
        require_once('backend/mysql.php');

        if (isset($_POST['login_btn'])) {
            if (!isset($_POST['cpf'])) {
                die();
            } else {
                $cpf = $mysql->real_escape_string($_POST['cpf']);
                $data_nasc = date("Y-d-m", strtotime($_POST['data_nasc']));
                $data_nasc = $mysql->real_escape_string($data_nasc);

                $queryRequest = "SELECT * FROM USUARIOS WHERE cpf = '$cpf'";
                $queryUsuario = $mysql->query($queryRequest) or die('Erro em bd->query() em login.php');
                $quantidadeDeUsuariosAchados = $mysql->query("SELECT * FROM USUARIOS WHERE cpf = '$cpf' and
                data_nascimento = '$data_nasc'");
                $quantidadeDeUsuariosAchados = $quantidadeDeUsuariosAchados->num_rows;
                
                if ($quantidadeDeUsuariosAchados != 1) {
                    echo '<h4 class="form-text">Usuário ou senha incorretos</h4>';
                } elseif ($quantidadeDeUsuariosAchados = 1) {
                    $usuario = $queryUsuario->fetch_assoc();
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['nome'] = $usuario['nome'];
                    $_SESSION['cpf'] = $usuario['cpf'];
                    $_SESSION['data_nasc'] = $usuario['data_nascimento'];
                    header("Location: ./");
                } else {
                    echo '<h4 class="form-text">Usuário ou senha incorretos</h4>';
                }
            }
        }
        
        ?>
</div>
<script>
        const input = document.getElementById("cpf");
        input.addEventListener('keypress', () => {
            let inputlength = input.value.length;

            if(inputlength === 3 || inputlength === 7) input.value += '.';
            if(inputlength === 11) input.value += '-';
        });
        const input_nasc = document.getElementById('data_nascimento');
        input_nasc.addEventListener('keypress', () => {
            let inputlength_nasc = input_nasc.value.length;

            if(inputlength_nasc === 2 || inputlength_nasc === 5 ) input_nasc.value += '/';
        })
</script>