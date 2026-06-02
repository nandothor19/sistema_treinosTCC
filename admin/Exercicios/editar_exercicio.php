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
    SELECT * FROM exercicios
    WHERE idExercicio = ?
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if($_POST){
    $nome = $_POST['nome'];
    $grupoMuscular = $_POST['grupoMuscular'];
    $series = $_POST['series'];
    $repeticoes = $_POST['repeticoes'];
    $descricao = $_POST['descricao'];

    $update = $conn->prepare("
        UPDATE exercicios
        SET nome = ?,
        grupoMuscular = ?,
        series = ?,
        repeticoes = ?,
        descricao = ?
        WHERE idExercicio = ?
    ");

    $update->execute([
        $nome,
        $grupoMuscular,
        $series,
        $repeticoes,
        $descricao,
        $id
    ]);

    header("Location: ../exercicios.php");
    exit();
}

include("../../includes/cabecalho.php");

include("../../includes/menu_admin2.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Exercício</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <style>

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .conteudo {
            flex: 1;
        }
    </style>
</head>
<body class="w3-light-grey">
<div class="w3-container w3-round-xxlarge w3-card-4"
     style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    <div class="w3-center">
        <br>
        <h2 class="w3-center" style="color: #e67b39;"><b>Dados do Exercício</b></h2>
    </div>

    <form class="w3-container" action="" method="post">

        <div class="w3-section">
            <label style="font-weight: bold;"> Nome </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="nome" placeholder="Digite o nome do Exercício:" required
            value="<?php echo $user['nome']; ?>">

            <label style="font-weight: bold;"> Grupo Muscular </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="grupoMuscular" placeholder="Digite o nome do Grupo Muscular ao qual o exercício faz parte:" required
            value="<?php echo $user['grupoMuscular']; ?>">

            <label style="font-weight: bold;"> Séries </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="series" placeholder="Digite a quantidade de séries recomendadas para o exercício:" required
            value="<?php echo $user['series']; ?>">

            <label style="font-weight: bold;"> Repetições </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
            name="repeticoes" placeholder="Digite a quantidade de repetições recomendadas para o exercício:" required
            value="<?php echo $user['repeticoes']; ?>">

            <label style="font-weight: bold;"> Descrição </label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="<textarea>"
            name="descricao" placeholder="Digite a descrição do exercício:" required
            value="<?php echo $user['descricao']; ?>">


            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit" 
                    style="background: transparent; color: #e67b39; border: 3px solid #e67b39;">
                Salvar
            </button>
        </div>

    </form>

</div>
</body>

<?php include("../../includes/rodape.php"); ?>
</html>