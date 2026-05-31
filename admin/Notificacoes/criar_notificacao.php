<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../../includes/conexao.php");

$valTitulo = "";
$valMensagem = "";
$valTipo = "";
if (isset($_SESSION["cadastro_titulo"])) {
    $valTitulo = $_SESSION["cadastro_titulo"];
}
if (isset($_SESSION["cadastro_mensagem"])) {
    $valMensagem = $_SESSION["cadastro_mensagem"];
}
if (isset($_SESSION["cadastro_tipo"])) {
    $valTipo = $_SESSION["cadastro_tipo"];
}

$msgErro = "";
if (isset($_GET["erro"])) {
    if ($_GET["erro"] == "campos") {
        $msgErro = "Preencha todos os campos.";
    } elseif ($_GET["erro"] == "titulo_duplicado") {
        $msgErro = "Este título de notificação já está cadastrado.";
    }
}
?>

<?php include("../../includes/cabecalho.php"); ?>
<?php include("../../includes/menu_admin2.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Notificação</title>
        <link rel="stylesheet"
        href="https://www.w3schools.com/w3css/4/w3.css">
    </head>
    <body>

<div class="w3-container w3-round-xxlarge w3-card-4"
     style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    <div class="w3-center">
        <br>
        <h2 class="w3-center" style="color: #e67b39;"><b>Cadastrar Nova Notificação</b></h2>
    </div>

    <?php if ($msgErro != "") { ?>
        <div class="w3-panel w3-pale-red w3-border w3-round-large w3-margin-top">
            <p><?php echo $msgErro; ?></p>
        </div>
    <?php } ?>

    <form class="w3-container" action="criar_notificacao_Action.php" method="post">
        <div class="w3-section">
            <label style="font-weight: bold;">Título</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
                   name="titulo" placeholder="Insira o título da Notificação:" required
                   value="<?php echo $valTitulo; ?>">

            <label style="font-weight: bold;">Mensagem</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="<textarea>"
                   name="mensagem" placeholder="Insira a mensagem presenta na notificação:" required
                   value="<?php echo $valMensagem; ?>">

            <label style="font-weight: bold;">Tipo</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="<text>"
                   name="tipo" placeholder="Insira o tipo de notificação:" required
                   value="<?php echo $valTipo; ?>">

            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit"
                    style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                <b>Cadastrar</b>
            </button>

            <?php 
                if(isset ($_SESSION['exibir_botao'])):
            ?>    
                <div class="w3-container w3-section w3-center">
                    <a href="info_usuario.php" style="color: #e67b39; font-weight: bold;">Enviar Notificações para os Usuários</a>
                </div>
            <?php endif; ?>
        </div>
    </form>

    <div class="w3-container w3-section w3-center">
        <a href="/admin/dashboard.php" style="color: #e67b39; font-weight: bold;">Voltar ao Início</a>
    </div>
    <br>
</div>
</body>
</html>

<?php include("../../includes/rodape.php"); ?>