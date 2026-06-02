<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

include("../../includes/conexao.php");

$idNotificacao = $_GET['id'] ?? 0;

if (!$idNotificacao) {
    die("Notificação não informada.");
}


$sql = "
SELECT *
FROM notificacoes
WHERE idNotificacao = :id
";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $idNotificacao, PDO::PARAM_INT);
$stmt->execute();

$notificacao = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$notificacao) {
    die("Notificação não encontrada.");
}

$mensagem = "";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuarios = $_POST['usuarios'] ?? [];

    if (count($usuarios) == 0) {

        $mensagem = "
        <div class='w3-panel w3-orange w3-round'>
            Selecione pelo menos um usuário.
        </div>";

    } else {

        $sqlInsert = "
        INSERT INTO notificacoes_usuarios
        (
            idUsuario,
            idNotificacao,
            dataEnvio,
            lida
        )
        VALUES
        (
            :idUsuario,
            :idNotificacao,
            NOW(),
            0
        )
        ";

        $stmtInsert = $conn->prepare($sqlInsert);

        $enviados = 0;

        foreach ($usuarios as $idUsuario) {

            $stmtInsert->execute([
                ':idUsuario' => $idUsuario,
                ':idNotificacao' => $idNotificacao
            ]);

            $enviados++;
        }

        $mensagem = "
        <div class='w3-panel w3-green w3-round'>
            Notificação enviada para {$enviados} usuário(s).
        </div>";
    }
}




$sqlUsuarios = "
SELECT idUsuario, nome
FROM usuarios
ORDER BY idUsuario ASC
";

$stmtUsuarios = $conn->query($sqlUsuarios);

include("../../includes/cabecalho.php");

include("../../includes/menu_admin2.php");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Enviar Notificação para Usuários</title>

        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body class="w3-container">

    <h2 class="w3-container" style="color: #e67b39;">
        <b>Enviar Notificação</b>
    </h2>

    <?php echo $mensagem; ?>

    <div class="w3-card w3-padding card w3-margin-bottom w3-round-large">

        <h3>
            <strong>Título:</strong>
            <?php echo htmlspecialchars($notificacao['titulo']); ?>
        </h3>

        <p>
            <strong>Mensagem:</strong>
            <?php echo htmlspecialchars($notificacao['mensagem']); ?>
        </p>

        <p>
            <strong>Tipo:</strong>
            <?php echo htmlspecialchars($notificacao['tipo']); ?>
        </p>

    </div>

    <div class="w3-container w3-round-xxlarge w3-card-4"
        style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">

    <div class="w3-center">
            <br>
            <h2 class="w3-center" style="color: #e67b39;"><b>Lista de Usuários</b></h2>
        </div>

    <form method="POST">

        <div class="usuarios-box">

            <?php while($usuario = $stmtUsuarios->fetch(PDO::FETCH_ASSOC)) { ?>

                <div class="usuario-item" style = "padding: 5px 50px">

                    <label>

                        <input
                            type="checkbox"
                            name="usuarios[]"
                            value="<?php echo $usuario['idUsuario']; ?>"
                            class="usuario-check">

                        <?php echo $usuario['idUsuario']; ?>
                        -
                        <?php echo htmlspecialchars($usuario['nome']); ?>

                    </label>

                </div>

            <?php } ?>

        </div>

        <div class="w3-container" style="padding: 12px 24px 24px 24px">

            <button
                type="button"
                class="w3-button w3-blue w3-round w3-half"
                onclick="selecionarTodos()">

                Selecionar Todos

            </button>

            <button
                type="button"
                class="w3-button w3-red w3-round w3-half"
                onclick="desmarcarTodos()">

                Desmarcar Todos

            </button>

        </div>


        <div class="w3-container">

        <button
            type="submit"
            class="w3-button w3-green w3-round w3-half">

            Enviar para Selecionados

        </button>

        <a href="../notificacoes.php"
           class="w3-button w3-grey w3-round w3-half">

            Voltar

        </a>
    </div>

    </form>

</div>

    <script>

        function selecionarTodos() {

            document.querySelectorAll('.usuario-check')
                .forEach(check => check.checked = true);

        }

        function desmarcarTodos() {

            document.querySelectorAll('.usuario-check')
                .forEach(check => check.checked = false);

        }

    </script>

</body>
    

</html>

<?php include("../../includes/rodape.php"); ?>