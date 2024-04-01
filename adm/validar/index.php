<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validação de Comprovantes</title>
    <link rel="stylesheet" href="../../css/index.css">
    <?php 
        require_once('../../backend/mysql.php');
        if(PHP_SESSION_NONE === session_status()) {
            session_start();
        }
        if($_SESSION['adm'] !== TRUE or !isset($_SESSION['id'])) {
            header("Location: ../../");
        }
    ?>

    <!-- Jquery para facilitar o uso do ajax -->
    

</head>

<body>

    <header>
        <a href="../../"><img src="../../images/logoifms.png" alt="Logo IFMS" class="logo"></a>
        <h1>Validação de Comprovantes</h1>
        <p>Comprovantes aguardando validação:</p>
        <nav>
            <ul>
                <li>
                    <a href="javascript:history.go(-1)">Voltar</a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container" style="
    margin-bottom: 10rem; 
    border-radius: 0px !important;
    box-shadow:none; 
    background-color: rgba(0, 0, 0, 0)">
        <div class='table-responsive'>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Turma</th>
                        <th>Professor Responsável</th>
                        <th>Tipo de Atividade</th>
                        <th>Observação</th>
                        <th>Data enviada</th>
                        <th>Comprovante</th>
                        <th>Validar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $query = $mysql->query("SELECT envios.*, usuarios.nome AS nome_aluno
                    FROM envios
                    JOIN usuarios ON envios.id_aluno = usuarios.id;");
                    while($comprovantes = $query->fetch_assoc()) {
                        $path = $comprovantes['path'];
                        $comprovanteid = $comprovantes['id'];
                        
                    ?>

                    <tr>
                        <td><?php echo $comprovantes['nome_aluno'] ?></td>
                        <td><?php echo $comprovantes['email'] ?></td>
                        <td><?php echo $comprovantes['turma'] ?></td>
                        <td><?php echo $comprovantes['prof'] ?></td>
                        <td><?php echo $comprovantes['tipo'] ?></td>
                        <td><?php echo $comprovantes['obs'] ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($comprovantes['horario_enviado'])); ?></td>
                        <td><a href=<?php echo "'../$path'"?> target="_blank">Ver Comprovante</a></td>
                        <td>

                            <?php if($comprovantes['validado'] == 0) { ?>
                            <form <?php echo "id='form".$comprovanteid."'" ?>>
                                <input style='margin-bottom: 1rem; width: 100% !important;' placeholder="Carga Horária"
                                    type="number"
                                    <?php echo 'id="cargahoraria'.$comprovanteid.'"' ?>>
                                <button <?php echo 'form="validar'.$comprovanteid.'"' ?> 
                                type="submit" <?php echo "id='$comprovanteid'" ?> onclick="validar(this.name, this.id)"
                                    <?php echo 'name="validar'.$comprovanteid.'"' ?>>
                                    Validar
                                </button>
                            </form>
                            <?php }     
                            else {
                                echo "<span style='color: green'><strong>Já validado!";
                                echo "<br> Carga Horária: ".$comprovantes['carga_horaria']."m</strong></span>";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- Adicione mais linhas conforme necessário -->
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Validação de Comprovantes. Todos os direitos reservados.</p>
    </footer>
    <script type="text/javascript" src="jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</body>

</html>