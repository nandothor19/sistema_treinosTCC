<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();
}

$nome = $_SESSION['admin_nome'];


include("../includes/conexao.php");

$id = $_GET['id'];

$stmt = $conn->prepare("
DELETE FROM notificacoes
WHERE idNotificacao = ?
");

$stmt->execute([$id]);


header("Location: ../notificacoes.php");

?>
