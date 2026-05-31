<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../../includes/conexao.php");

$titulo = trim($_POST["titulo"] ?? "");
$mensagem = trim($_POST["mensagem"] ?? "");
$tipo = trim($_POST["tipo"] ?? "");

if ($titulo == "" || $mensagem == "" || $tipo == "") {
    $_SESSION["cadastro_titulo"] = $titulo;
    $_SESSION["cadastro_mensagem"] = $mensagem;
    $_SESSION["cadastro_tipo"] = $tipo;
    header("Location: criar_notificacao.php?erro=campos");
    exit;
}

$sqlBusca = $conn->prepare("SELECT idNotificacao FROM notificacoes WHERE titulo = ?");
$sqlBusca->execute([$titulo]);
if ($sqlBusca->fetch()) {
    $_SESSION["cadastro_nome"] = $nome;
    $_SESSION["cadastro_titulo"] = $titulo;
    header("Location: criar_notificacao.php?erro=titulo_duplicado");
    exit;
}


$sqlInsert = $conn->prepare("INSERT INTO notificacoes (titulo, mensagem, tipo) VALUES (?, ?, ?)");
$sqlInsert->execute([$titulo, $mensagem, $tipo]);

$id = $conn->lastInsertId();

unset($_SESSION["cadastro_titulo"]);
unset($_SESSION["cadastro_mensagem"]);
unset($_SESSION["cadastro_tipo"]);

$_SESSION["cadastro_idnotificacao"] = $id;
$_SESSION["cadastro_titulo"] = $titulo;
$_SESSION["cadastro_mensagem"] = $mensagem;
$_SESSION["cadastro_tipo"] = $tipo;
$_SESSION['exibir_botao'] = true;

header("Location: criar_notificacao.php");

exit;
