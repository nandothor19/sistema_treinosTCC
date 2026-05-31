<?php
session_start();
include("includes/conexao.php");

$nome = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($nome == "" || $email == "" || $senha == "") {
    $_SESSION["cadastro_nome"] = $nome;
    $_SESSION["cadastro_email"] = $email;
    header("Location: cadastro.php?erro=campos");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["cadastro_nome"] = $nome;
    $_SESSION["cadastro_email"] = $email;
    header("Location: cadastro.php?erro=email_invalido");
    exit;
}

$sqlBusca = $conn->prepare("SELECT idUsuario FROM usuarios WHERE email = ?");
$sqlBusca->execute([$email]);
if ($sqlBusca->fetch()) {
    $_SESSION["cadastro_nome"] = $nome;
    $_SESSION["cadastro_email"] = $email;
    header("Location: cadastro.php?erro=email_duplicado");
    exit;
}

$senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

$sqlInsert = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$sqlInsert->execute([$nome, $email, $senhaCripto]);

$id = $conn->lastInsertId();

unset($_SESSION["cadastro_nome"]);
unset($_SESSION["cadastro_email"]);

$_SESSION["usuario_id"] = $id;
$_SESSION["cadastro_nome"] = $nome;
$_SESSION["cadastro_email"] = $email;

header("Location: info_usuario.php");
exit;
