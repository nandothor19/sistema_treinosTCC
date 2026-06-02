<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$nome = $_SESSION['admin_nome'];

include("../../includes/conexao.php");


$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $conn->prepare("
    SELECT * FROM notificacoes
    WHERE idNotificacao = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($_POST){
    $titulo = $_POST['titulo'];
    $mensagem = $_POST['mensagem'];
    $tipo = $_POST['tipo'];

    $update = $conn->prepare("
        UPDATE notificacoes
        SET titulo = ?,
        mensagem = ?,
        tipo = ?
        WHERE idNotificacao = ?
    ");

    $update->execute([
        $titulo,
        $mensagem,
        $tipo,
        $id
    ]);

    header("Location: ../notificacoes.php");
    exit();
}

include("../../includes/cabecalho.php");

include("../../includes/menu_admin2.php");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Exercício</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
</head>
<body class="body">
<div class="w3-container w3-round-xxlarge w3-card-4"
     style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    <div class="w3-center">
        <br>
        <h2 class="w3-center" style="color: #e67b39;"><b>Dados da Notificação</b></h2>
    </div>

    <form class="w3-container" action="" method="post">

        <div class="w3-section">
            <label style="font-weight: bold;"> Título </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="titulo" placeholder="Digite o título da Notificação:" required
            value="<?php echo $user['titulo']; ?>">

            <label style="font-weight: bold;"> Mensagem </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="mensagem" placeholder="Digite a mensagem a ser enviada pela Notificação:" required
            value="<?php echo $user['mensagem']; ?>">

            <label style="font-weight: bold;"> Tipo </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="tipo" placeholder="Digite o tipo de Notificação:" required
            value="<?php echo $user['tipo']; ?>">

            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit" 
                    style="background: transparent; color: #e67b39; border: 3px solid #e67b39;">
                Salvar
            </button>
        </div>

    </form>

</div>
</body>
    
<?php include("../../includes/rodape.php"); ?>

</html>