<!-- Lateral esquerda -->
<div class="sidebar-left"></div>

<!-- Lateral direita -->
<div class="sidebar-right"></div>

<header>
    <a href="./"><img src="images/logoifms.png" alt="Logo IFMS" class="logo"></a>
    <h1>Página Inicial</h1>
    <p>Facilitando o envio, acompanhamento e avaliação de horas extracurriculares.</p>
    <h3>Bem vindo, <?php echo $_SESSION['nome'] ?>!</h3>

    <nav>
        <ul>
            <?php if(!isset($_SESSION['adm'])) { ?>
            <li><a href="envio">Enviar Comprovantes</a></li>
            <?php } if(isset($_SESSION['adm'])) {
                if($_SESSION['adm']  === TRUE) {?>
            <li><a href="./adm/validar/">Validar comprovantes</a></li>
            <?php } }?>
            <li><a href="deslogar.php">Deslogar</a></li>
        </ul>
    </nav>

</header>

<?php if(!isset($_SESSION['adm']) and isset($_SESSION['id'])) { ?>
<div class="container" id="enviar">
    <h2>Enviar Comprovantes</h2>
    <p>Aqui você pode enviar os comprovantes de suas atividades extracurriculares.</p>
    <!-- Conteúdo da seção de envio de comprovantes -->
    <!-- ... -->
</div>
<?php } ?>

<div class="container" id="enviados">
    <?php
        //Caso seja professor/servidor, ele loga como administrador e mostra os recebidos no nome dele.
        if(isset($_SESSION['adm'])) {
            if($_SESSION['adm'] === TRUE) {
                $nome = $_SESSION['nome'];
                $nome = strtok($nome, " ");
                $query = $mysql->query("SELECT * FROM `envios` WHERE `prof` = '$nome'") or die($mysql->error);
            } 
        } 
        //Caso seja aluno, loga como aluno e mostra os formularios enviados.
        else {
            $id_aluno = $_SESSION['id'];
            $query = $mysql->query("SELECT * FROM `envios` WHERE id_aluno = $id_aluno") or die($mysql->error);
        }
    ?>

    <?php if(isset($_SESSION['adm']) and isset($_SESSION['id'])) { ?>
    <h2>Comprovantes recebidos</h2>
    <p>Visualize os comprovantes recebidos</p>
    <?php } else { ?>
    <h2>Comprovantes Enviados</h2>
    <p>Visualize os comprovantes que você já enviou.</p>
    <?php } ?>

    <table>
        <thead>
            <th>Tipo</th>
            <th>Professor Responsável</th>
            <th>Observação</th>
            <th>Data Enviada</th>
            <th>Arquivo</th>
            <th>Validado</th>
        </thead>
        <tbody> 
            <?php 
            //$enviados = $query->fetch_assoc();
            //if (empty($enviados)) echo "<h4>Você ainda não fez envios</h4>";
            function get_validado($item) {
                if($item == 1) 
                    return "
                    <span style='color: green;''><strong>Validado!</strong></span>
                ";
                else
                    return "
                    <span style='color: red;'><strong>Não validado</strong></span>
                ";
            }
            if (empty($query)) echo "<h4>Você ainda não fez envios</h4>";
            while($comprovante = $query->fetch_assoc()) {
                $path = $comprovante['path'];
            ?>
            <tr>
                <td><?php echo $comprovante['tipo']; ?></td>
                <td><?php echo $comprovante['prof']; ?></td>
                <td><?php echo $comprovante['obs']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($comprovante['horario_enviado'])); ?></td>
                <td><?php echo "<a href='TrabalhoTCC/$path' target='_blank' rel='noopener noreferrer'>Clique aqui</a>"; ?></td>
                <td><?php echo get_validado($comprovante['validado']) ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <!-- Conteúdo da seção de comprovantes enviados -->
    <!-- ... -->
</div>

<?php if(!isset($_SESSION['adm']) and isset($_SESSION['id'])) {
        $queryMinutos = "SELECT SUM(`carga_horaria`) FROM `envios` WHERE id_aluno='$id_aluno'";
        $queryMinutos = $mysql->query($queryMinutos) or die("<span style='color: red;'>ERRO</span>");
        $minutosAcumulados = ($queryMinutos->fetch_row())[0]; 
        $totalEmHoras = $minutosAcumulados / 60; ?>
        
    <div class="container" id="total" style="margin-bottom: 100px;">
        <h2>Total de Horas: <?php echo $totalEmHoras ?>H</h2>
        <p>Em minutos: <?php 
        echo $minutosAcumulados;
        ?> minutos acumulados</p>
        <!-- Conteúdo da seção de total de horas -->
        <!-- ... -->
    </div>
<?php } ?>

<footer>
    <p>&copy; 2024 Sistema de Gerenciamento de Carga Horária</p>
</footer>