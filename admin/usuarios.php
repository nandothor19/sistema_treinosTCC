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
SELECT * FROM usuarios
ORDER BY idUsuario ASC
";

$result = $conn->query($sql);

?>

<?php include("../includes/cabecalho.php"); ?>

<?php include("../includes/menu_admin.php"); ?>

<!DOCTYPE html>

<html>

    <head>

        <title>Usuários</title>

        <link rel="stylesheet"
        href="https://www.w3schools.com/w3css/4/w3.css">

    </head>

    <body>

    <div class="w3-container">


        <div style="display:flex; justify-content:space-between; align-items:center;">

            <h2>Gerenciar Usuários</h2>

            <a href="Usuario/criar_usuario.php"
            class="w3-button w3-green"
            style="border-radius: 12px;">

                Novo usuário

            </a>

        </div>

        <style>

        .w3-table-all {
            width: 100%;
            margin-left: auto;
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
                <th>Email</th>
                <th>Informações do Usuário</th>
                <th>Excluir Usuário</th>

            </tr>

            <?php while($user = $result->fetch(PDO::FETCH_ASSOC)) { ?>

            <tr>

                <td>
                    <?php echo $user['idUsuario']; ?>
                </td>

                <td>
                    <?php echo $user['nome']; ?>
                </td>

                <td>
                    <?php echo $user['email']; ?>
                </td>

                <td>

                    <a href="Usuario/dados_usuario.php?id=<?php echo $user['idUsuario']; ?>&readonly=1"
                    class="w3-button w3-yellow"
                    style="border-radius: 12px;">
                        Visualizar Dados Complementares
                    </a>

                    <a href="Usuario/dados_usuario.php?id=<?php echo $user['idUsuario']; ?>"
                    class="w3-button w3-blue"
                    style="border-radius: 12px;">
                        Editar
                    </a>

                </td>

                <td>
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

                            <h3>Deseja realmente excluir esse usuário?</h3>
                            
                            <div class="w3-container" style="text-align: center;">
                                <a href="Usuario/excluir_usuario.php?id=<?php echo $user['idUsuario']; ?>"
                                class="w3-button w3-green"
                                style="border-radius: 12px;">
                                    Sim
                                </a>

                                <a href="usuarios.php"
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
    <footer>
        <p>&copy; 2026 - Sistema de Elaboração de Treinos</p>
    </footer>
</html>