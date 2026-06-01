<?php
session_start();
include("includes/conexao.php");

$idUsuario = $_SESSION['usuario_id'];

$dia = $_POST['dia'];
$exercicio = $_POST['exercicio'];

$sql = $conn->prepare("
    INSERT INTO progresso_treino
    (idUsuario, dia, exercicio, data_conclusao)
    VALUES (?, ?, ?, CURDATE())
");

$sql->execute([
    $idUsuario,
    $dia,
    $exercicio
]);