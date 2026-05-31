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
DELETE FROM exercicios
WHERE idExercicio = ?
");

$stmt->execute([$id]);


header("Location: ../exercicios.php");

?>
