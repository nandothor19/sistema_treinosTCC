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
SELECT DISTINCT idNotificacao, titulo, mensagem, tipo
FROM notificacoes
ORDER BY idNotificacao ASC
";

$result = $conn->query($sql);

?>

<?php include("../includes/cabecalho.php"); ?>

<?php include("../includes/menu_admin.php"); ?>

<!DOCTYPE html>

<html>

<head>

    <title>Notificações</title>

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

<body>

    <div style="display:flex; justify-content:space-between; align-items:center;">

        <h2>Gerenciar Notificações</h2>

        <a href="Notificacoes/criar_notificacao.php"
        class="w3-button w3-green"
        style="border-radius: 12px;">

            Nova Notificação

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
            <th>Título</th>
            <th>Mensagem</th>
            <th>Tipo</th>
            <th>Ações</th>
            <th>Enviar</th>

        </tr>

        <?php while($user = $result->fetch(PDO::FETCH_ASSOC)) { ?>

        <tr>

            <td>
                <?php echo $user['idNotificacao']; ?>
            </td>

            <td>
                <?php echo $user['titulo']; ?>
            </td>

            <td>
                <?php echo $user['mensagem']; ?>
            </td>

            <td>
                <?php echo $user['tipo']; ?>
            </td>            
            
            <td>

                <a href="Notificacoes/editar_notificacoes.php?id=<?php echo $user['idNotificacao']; ?>"
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

                        <h3>Deseja realmente excluir essa Notificação?</h3>
                        
                        <div class="w3-container" style="text-align: center;">
                            <a href="Notificacoes/excluir_notificacoes.php?id=<?php echo $user['idNotificacao']; ?>"
                            class="w3-button w3-green"
                            style="border-radius: 12px;">

                                Sim

                            </a>

                            <a href="notificacoes.php"
                            class="w3-button w3-red"
                            style="border-radius: 12px;">

                                Não

                            </a>
                        </div>
                    </div>

                </div>
            </td>

            <td>
                <a href="Notificacoes/enviar_notificacoes.php?id=<?php echo $user['idNotificacao']; ?>"
                class="w3-button w3-blue"
                style="border-radius: 12px;">
                    Enviar para Usuários
                </a>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
<?php include("includes/rodape.php"); ?>
</html>

