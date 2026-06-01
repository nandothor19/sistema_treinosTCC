<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login.php");
    exit();
}

$nome = $_SESSION['admin_nome'];

?>

<?php include("../includes/cabecalho.php"); ?>
<?php include("../includes/menu.php"); ?>

<?php

include("../includes/conexao.php");

$sql = "
SELECT plano_treino.*, usuarios.nome
FROM plano_treino

INNER JOIN usuarios
ON usuarios.idUsuario = plano_treino.idUsuario
";

$result = $conn->query($sql);

?>

<h2>Treinos</h2>

<table border="1">

<tr>

<th>Usuário</th>
<th>Treino</th>
<th>Dia</th>
<th>Horário</th>

</tr>

<?php while($treino = $result->fetch(PDO::FETCH_ASSOC)) { ?>

<tr>

<td>
    <?php echo $treino['nome']; ?>
</td>

<td>
    <?php echo $treino['nome_treino']; ?>
</td>

<td>
    <?php echo $treino['dia_semana']; ?>
</td>

<td>
    <?php echo $treino['horario']; ?>
</td>

</tr>

<?php } ?>

</table>