<?php
session_start();
include("includes/conexao.php");

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'] ?? null;

    if (!$usuario_id) {
        header("Location: login.php");
        exit();
    }

    $nome              = trim($_POST['nome'] ?? '');
    $email             = trim($_POST['email'] ?? '');
    $sexo              = $_POST['sexo'] ?? '';
    $idade             = (int)($_POST['idade'] ?? 0);
    $nivelExperiencia  = $_POST['nivelExperiencia'] ?? '';
    $objetivo          = $_POST['objetivo'] ?? '';
    $data_inicio       = $_POST['data_inicio'] ?? null;
    $data_fim          = $_POST['data_fim'] ?? null;
    $peso     = ($_POST['peso'] ?? 0);
    $altura   = ($_POST['altura'] ?? 0);
    $cintura  = ($_POST['cintura'] ?? 0);
    $peito    = ($_POST['peito'] ?? 0);
    $braco    = ($_POST['braco'] ?? 0);
    $perna    = ($_POST['perna'] ?? 0);

   echo "O ID do usuário é: " . $_SESSION['usuario_id'];
   echo $nome,
    $email,
    $sexo,
    $idade,
    $nivelExperiencia,
    $objetivo,
    $data_inicio,
    $data_fim,    
    $peso,
    $altura,
    $cintura,
    $peito,
    $braco,
    $perna;
    
    // Atualiza dados do usuário
        $stmt = $conn->prepare("
            UPDATE usuarios 
            SET nome = ?, email = ?, idade = ?, sexo = ?, 
            nivelExperiencia = ?, objetivo = ?, peso ?, altura = ?, cintura = ?,
             peito = ?, braco = ?, perna = ?
             WHERE idUsuario = ?
        ");
        $stmt->execute([$nome, $email, $idade, $sexo, $nivelExperiencia, $objetivo, 
        $peso, $altura, $cintura, $peito, $braco, $perna, $usuario_id] );

        // Atualiza nome na sessão
        $_SESSION['usuario_nome'] = $nome;

        // Redireciona com sucesso
        header("Location: dashboard.php");
        exit();

    /*try {

    } catch (Exception $e) {
        error_log("Erro em info_usuario_action: " . $e->getMessage());
        header("Location: info_usuario.php?erro=1");
        exit();
    }
} else {
    header("Location: info_usuario.php");
    exit(); */
}
?>