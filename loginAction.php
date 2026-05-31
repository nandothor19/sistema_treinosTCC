<?php

session_start();

include("includes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['txtNome']);
    $senha = trim($_POST['txtSenha']);

    /*
    =========================
    VERIFICA ADMIN
    =========================
    */

    $sqlAdmin = "SELECT idAdministrador, nome, email FROM administrador WHERE email = :nome";

    $stmtAdmin = $conn->prepare($sqlAdmin);

    $stmtAdmin->bindParam(':nome', $nome);

    $stmtAdmin->execute();

    /*
    =========================
    VERIFICA USUÁRIO
    =========================
    */

    $sqlUser = "SELECT idUsuario, nome, email, senha FROM usuarios WHERE email = :nome";

    $stmtUser = $conn->prepare($sqlUser);

    $stmtUser->bindParam(':nome', $nome);

    $stmtUser->execute();

    /*
    =========================
    VERIFICA ADMIN
    =========================
    */

    if ($stmtAdmin->rowCount() == 1) {

        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);
        if (password_verify($senha, $usuario['senha'])) {

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