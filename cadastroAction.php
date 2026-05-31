<?php
session_start();
include("includes/conexao.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: cadastro.php");
    exit();
}

$nome  = trim($_POST["nome"] ?? "");
$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

try {
    // Validação básica
    if ($nome === "" || $email === "" || $senha === "") {
        $_SESSION["cadastro_nome"] = $nome;
        $_SESSION["cadastro_email"] = $email;
        header("Location: cadastro.php?erro=campos");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["cadastro_nome"] = $nome;
        $_SESSION["cadastro_email"] = $email;
        header("Location: cadastro.php?erro=email_invalido");
        exit();
    }

    // Verifica se email já existe
    $stmt = $conn->prepare("SELECT idUsuario FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION["cadastro_nome"] = $nome;
        $_SESSION["cadastro_email"] = $email;
        header("Location: cadastro.php?erro=email_duplicado");
        exit();
    }

    // Criptografa senha
    $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);

    // Insere novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senhaCripto]);

    $idUsuario = $conn->lastInsertId();

    // Limpa sessões antigas
    unset($_SESSION["cadastro_nome"]);
    unset($_SESSION["cadastro_email"]);

    // Inicia sessão do usuário
    $_SESSION['usuario_id']   = $idUsuario;
    $_SESSION['usuario_nome'] = $nome;

    // Redireciona para completar informações
    header("Location: info_usuario.php");
    exit();

} catch (Exception $e) {
    error_log("Erro no cadastroAction: " . $e->getMessage());
    header("Location: cadastro.php?erro=erro_interno");
    exit();
}
?>