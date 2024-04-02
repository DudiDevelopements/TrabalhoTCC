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

        <script type="text/javascript" src="../../scripts/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="script.js"></script>
    </header>
    </div>
    <div class="container" style="
    margin-bottom: 10rem; 
    border-radius: 0px !important;
    box-shadow:none; 
    background-color: rgba(0, 0, 0, 0)">
        <form>
            <input type="text" id="inputPesquisa" onkeypress="pesquisa()" placeholder="Pesquisar por nome ou turma">
        </form>
        <div id='sortBtns'>
            <button id="btnMostrarValidados">Já validados</button>
            <button id="btnMostrarNaoValidados">Ainda não validados</button>
            <button id="btnMostrarTodos">Mostrar todos</button>
        </div>
        <div class='table-responsive'>
            <table class='table'>
                <thead>
                    <tr>
                        <th><button onclick="ordenarPorNome()">Nome</button></th>
                        <th><button onclick="ordenarPorEmail()">Email</button></th>
                        <th>Turma</th>
                        <th>Professor Responsável</th>
                        <th>Tipo de Atividade</th>
                        <th>Observação</th>
                        <th><button onclick="ordenarPorData()">Data enviada</button></th>
                        <th>Comprovante</th>
                        <th><button onclick="ordenarPorValidacao()">Validar </br> (em minutos)</button></th>
                    </tr>
                </thead>
                <tbody id='tbody'>

                    <!-- ... ... ... ... ... ... ... ... ... ... ... ... ... ... ... -->
                    <!-- ... Começo da repetição de tabelas pra listar comprovantes enviados ... -->
                    <!-- ... ... ... ... ... ... ... ... ... ... ... ... ... ... ... -->
                    <?php 
                    $query = $mysql->query("SELECT envios.*, usuarios.nome AS nome_aluno
                    FROM envios
                    JOIN usuarios ON envios.id_aluno = usuarios.id;");
                    while($comprovantes = $query->fetch_assoc()) {
                        $path = $comprovantes['path'];
                        $comprovanteid = $comprovantes['id'];
                        $hora_enviada = strtotime($comprovantes['horario_enviado']);
                    ?>
                    <tr>
                        <td><?php echo $comprovantes['nome_aluno'] ?></td>
                        <td><?php echo $comprovantes['email'] ?></td>
                        <td><?php echo $comprovantes['turma'] ?></td>
                        <td><?php echo $comprovantes['prof'] ?></td>
                        <td><?php echo $comprovantes['tipo'] ?></td>
                        <td><?php echo $comprovantes['obs'] ?></td>
                        <td><?php echo date('d/m/Y', $hora_enviada) . "</br>às " . date('H:i', $hora_enviada); ?></td>
                        <td><a id='link' href=<?php echo "'../$path'"?> target="_blank">Ver Comprovante</a></td>
                        <td>

                            <?php if($comprovantes['validado'] == 0) { ?>
                            <form id="form<?php echo $comprovanteid ?>">
                                <input style='margin-bottom: 1rem; width: 100% !important;' placeholder="Carga Horária"
                                    type="number" id="cargahoraria<?php echo $comprovanteid ?>">
                                <button type="button" id="<?php echo $comprovanteid ?>" onclick="validar(this.id)">
                                    Validar
                                </button>
                            </form>
                            <?php } else { ?>
                            <div id="form<?php echo $comprovanteid ?>">
                                <span style='color: green'><strong>Já validado!
                                        <?php
                                    $cargaHorariaEmHoras = ($comprovantes['carga_horaria']/60);
                                    $cargaHorariaEmHoras = str_replace('.', ',', number_format($cargaHorariaEmHoras, 1));
                                    echo "<br> Carga Horária: ".$cargaHorariaEmHoras." horas</strong></span>";
                                    ?>
                                        <button type="button" id="<?php echo $comprovanteid ?>"
                                            style="background-color: #c21414;"
                                            onclick="revogar(this.id)">Revogar</button>
                            </div>
                            <?php }?>
                        </td>
                    </tr>
                    <?php } ?>
                    <!-- ... ... ... ... ... ... ... ... ... ... ... ... ... ... ...  ... ...-->
                    <!-- ... Fim da repetição de tabelas pra listar comprovantes enviados ... -->
                    <!-- ... ... ... ... ... ... ... ... ... ... ... ... ... ... ...  ... ...-->

                    <!-- Adicione mais linhas conforme necessário -->
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Validação de Comprovantes. Todos os direitos reservados.</p>
    </footer>
</body>

</html>