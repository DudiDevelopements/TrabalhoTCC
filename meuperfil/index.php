<!-- Lateral esquerda -->
<div class="sidebar-left"></div>

<!-- Lateral direita -->
<div class="sidebar-right"></div>

<?php
    //Caso seja professor/servidor, ele loga como administrador e mostra os recebidos no nome dele.
    if(isset($_SESSION['adm'])) {
        if($_SESSION['adm'] === TRUE) {
            $nome = $_SESSION['nome'];
            $nome = strtok($nome, " ");
            $query = $mysql->query("SELECT * FROM `envios` WHERE `prof` = '$nome'") or die($mysql->error);
            $query2 = $mysql->query("SELECT * FROM `envios` WHERE `prof` = '$nome'") or die($mysql->error);
        } 
    } 
    //Caso seja aluno, loga como aluno e mostra os formularios enviados.
    else {
        $id_aluno = $_SESSION['id'];
        $query = $mysql->query("SELECT * FROM `envios` WHERE id_aluno = $id_aluno") or die($mysql->error);
        $query2 = $mysql->query("SELECT * FROM `envios` WHERE id_aluno = $id_aluno") or die($mysql->error);
    }
?>

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


<!-- Seção disponível apenas para aluno, verifica se usuario logado é aluno e mostra seção -->
<?php if(!isset($_SESSION['adm']) and isset($_SESSION['id'])) { ?>
<div class="container" id="enviar">
    <a href="envio">
        <h2>Enviar Comprovantes</h2>
        <p>Aqui você pode enviar os comprovantes de suas atividades extracurriculares.</p>
        <!-- Conteúdo da seção de envio de comprovantes -->
        <!-- ... -->
    </a>
</div>
<?php } ?>


<!-- ... ... Seção de total de horas ... ... -->
<?php 
if(!isset($_SESSION['adm']) and isset($_SESSION['id'])) {
    $queryMinutos = "SELECT SUM(`carga_horaria`) FROM `envios` WHERE id_aluno='$id_aluno'";
    $queryMinutos = $mysql->query($queryMinutos) or die("<span style='color: red;'>ERRO</span>");
    $minutosAcumulados = ($queryMinutos->fetch_row())[0]; 
    $totalEmHoras = $minutosAcumulados / 60; 
    $totalEmHorasF = str_replace('.', ',', number_format($totalEmHoras, 1));          
    ?>
    <div class="container" id="total">
        <h2>Total de Horas: <?php echo $totalEmHorasF ?>H</h2>
        
        <p>1º semestre: <?php 
        $totalEmHoras = number_format($totalEmHoras, 1);
        if ($totalEmHoras < 40) echo str_replace('.', ',', $totalEmHoras);
        else echo '40'; ?> de 40 horas completas</p>
        <p>2º semestre: <?php 
        if ($totalEmHoras < 80 && $totalEmHoras > 40) echo str_replace('.', ',', ($totalEmHoras - 40));
        else if ($totalEmHoras >= 80) echo '40'; 
        else echo '0,0'; ?> de 40 horas completas</p>
        <p>3º semestre: <?php 
        if ($totalEmHoras < 120 && $totalEmHoras > 80) echo str_replace('.', ',', ($totalEmHoras - 80));
        else if ($totalEmHoras >= 120) echo '40'; 
        else echo '0,0'; ?> de 40 horas completas</p>
        <p>4º semestre: <?php 
        if ($totalEmHoras < 160 && $totalEmHoras > 120) echo str_replace('.', ',', ($totalEmHoras - 120));
        else if ($totalEmHoras >= 160) echo '40'; 
        else echo '0,0'; ?> de 40 horas completas</p>
        <p>5º semestre: <?php 
        if ($totalEmHoras < 200 && $totalEmHoras > 160) echo str_replace('.', ',', ($totalEmHoras - 160));
        else if ($totalEmHoras >= 200) echo '40'; 
        else echo '0,0'; ?> de 40 horas completas</p>
        <p>6º semestre: <?php 
        if ($totalEmHoras < 240 && $totalEmHoras > 200) echo str_replace('.', ',', ($totalEmHoras - 200));
        else if ($totalEmHoras >= 240) echo '40'; 
        else echo '0,0'; ?> de 40 horas completas</p>
        
        <p style="font-size: 14px;">Em minutos: <?php 
        echo $minutosAcumulados/1;
        ?> minutos acumulados</p>
        <?php if($totalEmHoras >= 240) echo "<h3 style='text-align: center; color: green;'>
        <strong>Parabéns! Você concluiu sua carga de atividades complementárias!</strong></h3>" ?>
    </div>
<?php 
} ?>
<!-- ... ... Fim da seção de total de horas ... ... -->


<div class="container" id="enviados" style="margin-bottom: 100px;">

    <?php if(isset($_SESSION['adm']) and isset($_SESSION['id'])) { ?>
    <h2>Comprovantes recebidos</h2>
    <p>Visualize os comprovantes recebidos</p>
    <?php } else { ?>
    <h2>Comprovantes Enviados</h2>
    <p>Visualize o status dos comprovantes que você enviou.</p>
    <br>
    <?php } ?>

    <?php if($query2->num_rows === 0) {
        if(isset($_SESSION['adm'])) echo "<span>Você ainda não recebeu envios no seu nome</span>";
        else echo "<span>Você ainda não fez envios</span>";
        } else { ?>
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
            function get_validado($item, $cg) {
                if($item == 1) { 
                    $cargaHorariaEmHoras = ($cg/60);
                    $cargaHorariaEmHoras = str_replace('.', ',', number_format($cargaHorariaEmHoras, 1));
                                    
                    return "
                    <span style='color: green;''>
                        <strong>Validado! Total: ". $cargaHorariaEmHoras . " horas </strong>
                    </span>";
                } else
                    return "
                    <span style='color: red;'>
                        <strong>Não validado</strong>
                    </span>
                ";
            }
            while($comprovante = $query->fetch_assoc()) {
                $path = $comprovante['path'];
            ?>
            <tr>
                <td><?php echo $comprovante['tipo']; ?></td>
                <td><?php echo $comprovante['prof']; ?></td>
                <td><?php echo $comprovante['obs']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($comprovante['horario_enviado'])); ?></td>
                <td><?php echo "<a href='TrabalhoTCC/$path' id='link' target='_blank' rel='noopener noreferrer'>Link do arquivo</a>"; ?></td>
                <td><?php echo get_validado($comprovante['validado'], $comprovante['carga_horaria']) ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <!-- Conteúdo da seção de comprovantes enviados -->
    <!-- ... -->
</div>

<footer>
    <p>&copy; 2024 Sistema de Gerenciamento de Carga Horária</p>
</footer>