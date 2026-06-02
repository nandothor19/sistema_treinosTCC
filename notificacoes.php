<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();
}

include("includes/conexao.php");

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'] ?? 'Usuário'; 

// Buscar dados completos do usuário
$stmt = $conn->prepare("
    SELECT * 
    FROM usuarios
    WHERE idUsuario = ? 
");

$stmt = $conn->prepare("
    SELECT a.DataEnvio, b.*
    FROM(SELECT idNotificacao, DataEnvio
    FROM notificacoes_usuarios
    WHERE idUsuario = ?) as a
    LEFT JOIN notificacoes as b
    ON a.idNotificacao = b.idNotificacao
    ORDER BY DataEnvio DESC
");

$stmt->execute([$usuario_id]);

// $result = $stmt->fetch(PDO::FETCH_ASSOC);

include("includes/cabecalho.php");

include("includes/menu.php"); ?>

<!DOCTYPE html> 

<html lang="pt-br"> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
        <link rel="stylesheet" href="style.css">  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
        <style>

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .conteudo {
            flex: 1;
        }
    </style>
        <title>Notificações</title> 
    </head> 
    <body> 
    
    <div class="w3-padding-128 w3-content">

    <div class="w3-row-padding" style="margin-top: 30px;">

        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h2 style="color: #e67b39;"><b>Olá, <?php echo htmlspecialchars($nome); ?>.</b></h2>
                <h3>Aqui você acompanha avisos importantes do sistema, como lembretes de treino, períodos de descanso e atualizações do seu plano.</h3  >
            </div>
        </div>
    
        <?php   
            if($stmt->rowCount() > 0)  {?>

    <form action="" method="post" class="w3-container w3-margin w3-center" style="width: 100%;" method="post"> 
    <table class="w3-table w3-centered w3-bordered w3-round-large"> 
            <thead>  
                <tr class="w3-center w3-round-large" style="background-color: #e67b39 ;color: white;">  
                    <th style="border-top-left-radius: 12px;">Título</th>  
                    <th>Mensagem</th>
                    <th>Tipo</th>
                    <th style="border-top-right-radius: 12px;">Data de Envio</th>
                </tr>  
            </thead>

    <tbody>
        <?php   
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
                echo '<tr>'; 
                echo '<td style="width: 25%;">'.$row['titulo'].'</td>';
                echo '<td style="width: 25%;">'.$row['mensagem'].'</td>';
                echo '<td style="width: 25%;">'.$row['tipo'].'</td>';
                echo '<td style="width: 25%;">'.$row['DataEnvio'].'</td>';
                echo '</tr>';  
                }  
        ?> 
        </tbody>

    </table> 

    <?php } else { ?>
            <div class="w3-container w3-round-xxlarge w3-card-4 w3-centered" style="padding: 20px; margin-bottom: 20px;">
                <h2 style="color: #e67b39;"><b>Você não possui novas notificações.</b></h2>
            </div>
    <?php } ?>
        <div class="w3-row w3-section" style="display: flex; justify-content: center;">
            <a href="dashboard.php" 
            class="w3-button w3-margin w3-round-large"
            style="min-width: 200px; background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                Voltar
            </a>
        </div>
    </form>  

</div>
</body>  
<?php include("includes/rodape.php"); ?>
</html> 