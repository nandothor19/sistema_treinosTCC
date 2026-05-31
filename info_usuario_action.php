<?php
session_start();
include("includes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];

    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $sexo = $_POST['sexo'];
    $idade = (int)$_POST['idade'];
    $nivelExperiencia = $_POST['nivelExperiencia'];
    $objetivo = $_POST['objetivo'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    $peso = (float)$_POST['peso'];
    $altura = (float)$_POST['altura'];
    $cintura = (float)$_POST['cintura'];
    $peito = (float)$_POST['peito'];
    $braco = (float)$_POST['braco'];
    $perna = (float)$_POST['perna'];

    try {
        // Atualiza tabela usuarios
        $stmt = $conn->prepare("
            UPDATE usuarios SET 
            nome = ?, email = ?, idade = ?, sexo = ?, 
            nivelExperiencia = ?, objetivo = ?
            WHERE idUsuario = ?
        ");
        $stmt->execute([$nome, $email, $idade, $sexo, $nivelExperiencia, $objetivo, $usuario_id]);

        // Insere ou atualiza medidas corporais
        $stmt2 = $conn->prepare("
            INSERT INTO medidas_corporais 
            (idUsuario, peso, altura, cintura, peito, braco, perna, dataRegistro)
            VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_DATE)
        ");
        $stmt2->execute([$usuario_id, $peso, $altura, $cintura, $peito, $braco, $perna]);

        // Atualiza sessão
        $_SESSION['usuario_nome'] = $nome;

        header("Location: dashboard.php?sucesso=1");
        exit();

    } catch (Exception $e) {
        header("Location: info_usuario.php?erro=1");
        exit();
    }
}
?>