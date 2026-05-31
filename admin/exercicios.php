<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();
}

$nome = $_SESSION['admin_nome'];

?>

<?php

include("../includes/conexao.php");


$sql = "
SELECT * FROM exercicios
ORDER BY idExercicio ASC
";

$result = $conn->query($sql);

?>

<?php include("../includes/cabecalho.php"); ?>

<?php include("../includes/menu_admin.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Exercícios</title>
    <link rel="stylesheet"
    href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>

    <div style="display:flex; justify-content:space-between; align-items:center;">
        <h2>Gerenciar Exercícios</h2>
        <a href="Exercicios/criar_exercicio.php"
        class="w3-button w3-green"
        style="border-radius: 12px;">
            Novo Exercício
        </a>

    </div>
    <style>
    .w3-table-all {
        width: 100%;
        margin-left: auto;   /* Centers table */
        margin-right: auto;
        text-align: center;
        border-radius: 12px;
        overflow: hidden;
        border-collapse: collapse;
    }

    .w3-table-all th,
    .w3-table-all td {
        text-align: center;
        vertical-align: middle;
    }

    </style>
    <table class="w3-table-all">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Grupo Muscular</th>
            <th>Séries</th>
            <th>Repetições</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>

        <?php while($user = $result->fetch(PDO::FETCH_ASSOC)) { ?>

        <tr>
            <td>
                <?php echo $user['idExercicio']; ?>
            </td>
            <td>
                <?php echo $user['nome']; ?>
            </td>
            <td>
                <?php echo $user['grupoMuscular']; ?>
            </td>
            <td>
                <?php echo $user['series']; ?>
            </td>            
            <td>
                <?php echo $user['repeticoes']; ?>
            </td>
            <td>
                <?php echo $user['descricao']; ?>
            </td>
            <td>
                <a href="Exercicios/editar_exercicio.php?id=<?php echo $user['idExercicio']; ?>"
                class="w3-button w3-blue"
                style="border-radius: 12px;">
                    Editar
                </a>

                <button onclick="document.getElementById('popup').style.display='block'"
                class="w3-button w3-red"
                style="border-radius: 12px;">
                    Excluir
                </button>

                <div id="popup" class="w3-modal" >
                    <div class="w3-modal-content w3-padding w3-round-large"  style="font-family: Arial, sans-serif;
            background-color:rgb(255, 244, 207);">
                        <span onclick="document.getElementById('popup').style.display='none'"
                            class="w3-button w3-display-topright">
                            &times;
                        </span>

                        <h3>Deseja realmente excluir esse exercício?</h3>
                        
                        <div class="w3-container" style="text-align: center;">
                            <a href="Exercicios/excluir_exercicio.php?id=<?php echo $user['idExercicio']; ?>"
                            class="w3-button w3-green"
                            style="border-radius: 12px;">
                                Sim
                            </a>

                            <a href="exercicios.php"
                            class="w3-button w3-red"
                            style="border-radius: 12px;">
                                Não
                            </a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <?php } ?>

    </table>
</div>
</body>
</html>