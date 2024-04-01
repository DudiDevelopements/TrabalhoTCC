<!DOCTYPE html>
<html lang="pt-br">
<?php 
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['id']) or $_SESSION['adm'] !== TRUE) {
    header("Location: ../../");
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Carga Horária</title>
    <link rel="stylesheet" type="text/css" href="../../css/index.css">
</head>
    
<body>
    <header>
        <a href="../"><img src="../images/logoifms.png" alt="Logo IFMS" class="logo"></a>
        <h1>Sistema de Gerenciamento de Carga Horária</h1>
        <p>Facilitando o envio, acompanhamento e avaliação de horas extracurriculares.</p>
        <nav>
            <ul>
                <li><a href="javascript:history.go(-1)">Voltar</a></li>
            </ul>
        </nav>
    </header>

    <div class="container" style="margin-bottom: 10rem;">
        <h2>Envio de Comprovantes</h2>
        <form id="submission-form" action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="email">E-mail<span style="color: red">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="nome">Professor responsável<span style="color: red">*</span>:</label>
                <input type="text" id="prof_responsavel" name="prof_responsavel" required>
            </div>
            <div class="form-group">
                <label for="turma">Turma<span style="color: red">*</span>:</label>
                <input type="text" id="turma" name="turma" required>
            </div>
            <div class="form-group">
                <label for="tipo-atividade">Tipo de atividade<span style="color: red">*</span>:</label>
                <select id="tipo-atividade" name="tipo-atividade" required>
                    <option value="">Selecione...</option>
                    <option value="Unidade curriculares optativas/eletivas">Unidade curriculares optativas/eletivas
                    </option>
                    <option value="Projeto de ensino, pesquisa ou extensão">Projeto de ensino, pesquisa ou extensão
                    </option>
                    <option value="Prática profissional integradora e/ou vivência acadêmica">Prática profissional
                        integradora e/ou vivência acadêmica</option>
                    <option value="Práticas desportivas">Práticas desportivas</option>
                    <option value="Práticas artístico-culturais">Práticas artístico-culturais</option>
                </select>
            </div>
            <div class="form-group">
                <label for="comprovante">Comprovante<span style="color: red">*</span>:</label>
                <input type="file" id="comprovante" name="comprovante" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                    required>
            </div>
            <div class="form-group">
                <label for="observacao">Observação:</label>
                <textarea id="observacao" name="observacao" rows="3"></textarea>
            </div>
            <button type="submit" id="submit-btn" name="enviar_form">Enviar</button>
        </form>

        <?php 
    require_once('../backend/mysql.php');

    if(isset($_POST['enviar_form']) && isset($_SESSION['nome'])) {
        if(isset($_FILES['comprovante'])) {
            if($_FILES['comprovante']['size'] > 3145728) die(
                "<h3 style='color: red; text-align: center;'>Falha ao enviar: Arquivo muito grande (max: 3MB) </h3>"
            );
            //Caminho de onde estão os arquivos dos alunos que enviaram.
            $caminho_arquivos = "../arquivos/comprovantes_aluno";
            $nome_aluno = $_SESSION['nome'];
            $id_aluno = $_SESSION['id'];
            $comprovante = $_FILES['comprovante']['tmp_name'];
            $nome_antigo_comprovante = basename($_FILES['comprovante']['name']);
            
            $form_email = $mysql->real_escape_string($_POST['email']);
            $form_turma = $mysql->real_escape_string($_POST['turma']);
            $form_prof = $mysql->real_escape_string($_POST['prof_responsavel']);
            $form_atv = $mysql->real_escape_string($_POST['tipo-atividade']);
            $form_obs = $mysql->real_escape_string($_POST['observacao']);

            //Verifica se já existe a pasta do aluno no diretório e se não existir é criado.
            if(is_dir("$caminho_arquivos/$id_aluno") || mkdir("$caminho_arquivos/$id_aluno")) {
                $nome_comprovante = uniqid($id_aluno.$nome_aluno, true);
                $ext = strtolower(pathinfo($nome_antigo_comprovante, PATHINFO_EXTENSION));
                $caminho_gravado = "$caminho_arquivos/$id_aluno/$nome_comprovante.".$ext;

                //Faz o arquivo enviado pelo aluno ser permanente no sistema. Caso der erro ele morre o script.
                if(move_uploaded_file($comprovante, $caminho_gravado)) {
                    echo "<div><h3 style='color: green; text-align: center;'>Envio bem sucedido.";
                    $caminho_gravado = $mysql->real_escape_string($caminho_gravado);
                    
                    $insertbd = "INSERT INTO `envios` (`id`, `id_aluno`, `email`, `turma`, `prof`, `tipo`, `obs`, `path`, `validado`, `horario_enviado`) 
                        VALUES (DEFAULT, '$id_aluno', '$form_email', '$form_turma', '$form_prof', '$form_atv', '$form_obs', '$caminho_gravado', 
                        0, DEFAULT)";

                    if($mysql->query($insertbd) === TRUE) {
                        echo "CODE: 1</h3></div>";
                    } else {
                        die("Erro> " . $insertbd . $mysql->error . "</h3></div>");
                    }
                } else {
                    die("Envio mal sucedido. Por favor tente novamente mais tarde.");
                }
            }
        }
    }
    ?>

    </div>
    <footer>
        <p>&copy; 2024 Sistema de Gerenciamento de Carga Horária</p>
    </footer>


</body>

</html>