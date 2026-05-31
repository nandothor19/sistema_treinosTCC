<?php

session_start();

include("includes/conexao.php");

    /*
    =========================
    VERIFICA ADMIN
    =========================
    */

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['txtNome']);
    $senha = trim($_POST['txtSenha']);

    // Verifica ADMIN
    $stmtAdmin = $conn->prepare("SELECT idAdministrador, nome, senha FROM administrador WHERE email = ?");
    $stmtAdmin->execute([$email]);
    if ($stmtAdmin->rowCount() == 1) {
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
        if (password_verify($senha, $admin['senha'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['idAdministrador'];
            $_SESSION['admin_nome'] = $admin['nome'];
            $_SESSION['tipo'] = 'admin';
            header("Location: admin/dashboard.php");
            exit();
        }
    }

    /*
    =========================
    VERIFICA USUÁRIO
    =========================
    */

   $stmtUser = $conn->prepare("SELECT idUsuario, nome, senha FROM usuarios WHERE email = ?");
    $stmtUser->execute([$email]);
    if ($stmtUser->rowCount() == 1) {
        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
        if (password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['idUsuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['tipo'] = 'usuario';
            header("Location: dashboard.php");
            exit();
        }
    }

    /*
    =========================
    LOGIN INVÁLIDO
    =========================
    */

    header("Location: login.php?erro=login");
    exit();
}
?>