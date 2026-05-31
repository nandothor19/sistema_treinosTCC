<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../includes/conexao.php");

$mensagem = "";

if ($_POST) {

    $nome = trim($_POST['nome']);
    $grupoMuscular = trim($_POST['grupoMuscular']);
    $series = trim($_POST['series']);
    $repeticoes = trim($_POST['repeticoes']);
    $descricao = trim($_POST['descricao']);

    if ($nome != "" && $grupoMuscular != "" && $series != "" && $repeticoes != "" && $descricao != "") {


        // Insere no banco
        $stmt = $conn->prepare("
            INSERT INTO exercicios
            (nome, grupoMuscular, series, repeticoes, descricao)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $nome,
            $grupoMuscular,
            $series,
            $repeticoes,
            $descricao
        ]);

        $mensagem = "Exercício cadastrado com sucesso!";
    } else {

        $mensagem = "Preencha todos os campos.";

    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Novo Exercício</title>

    <link rel="stylesheet"
    href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body class="w3-light-grey">

<div class="w3-container" style="max-width:600px; margin:auto; margin-top:50px;">

    <div class="w3-card w3-white w3-padding w3-round-large">

        <h2>Cadastrar Exercício</h2>

        <?php if($mensagem != "") { ?>

            <div class="w3-panel w3-green w3-round">
                <p><?php echo $mensagem; ?></p>
            </div>

        <?php } ?>

        <form method="POST">

            <label>Nome</label>

            <input
            type="text"
            name="nome"
            class="w3-input w3-border w3-margin-bottom">

            <label>Grupo Muscular</label>

            <input
            type="text"
            name="grupoMuscular"
            class="w3-input w3-border w3-margin-bottom">

            <label>Séries</label>

            <input
            type="text"
            name="series"
            class="w3-input w3-border w3-margin-bottom">

            <label>Repetições</label>

            <input
            type="text"
            name="repeticoes"
            class="w3-input w3-border w3-margin-bottom">

            <label>Descrição</label>

            <input
            type="text"
            name="descricao"
            class="w3-input w3-border w3-margin-bottom">

            <button
            type="submit"
            class="w3-button w3-orange w3-round">

                Cadastrar

            </button>

            <a href="../exercicios.php"
            class="w3-button w3-gray w3-round">

                Voltar

            </a>

        </form>

    </div>

</div>

</body>
</html>