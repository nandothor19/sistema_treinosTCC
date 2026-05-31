<?php

session_start();

include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['Nome']);
    $senha = trim($_POST['Senha']);

    $sql = "SELECT id, nome, senha FROM usuario WHERE nome = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $nome);

    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {

            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['idUsuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];

            header("Location: dashboard.php");
            exit();

        } else {

            header("Location: login.php?erro=senha");
            exit();

        }

    } else {

        header("Location: login.php?erro=usuario");
        exit();

    }
}
?>