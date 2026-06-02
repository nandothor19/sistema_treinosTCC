<?php

    session_start();

    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }

    include("../../includes/conexao.php");

    $valNome = "";
    $valEmail = "";
    if (isset($_SESSION["cadastro_nome"])) {
        $valNome = $_SESSION["cadastro_nome"];
    }
    if (isset($_SESSION["cadastro_email"])) {
        $valEmail = $_SESSION["cadastro_email"];
    }

    $msgErro = "";
    if (isset($_GET["erro"])) {
        if ($_GET["erro"] == "campos") {
            $msgErro = "Preencha todos os campos.";
        } elseif ($_GET["erro"] == "email_invalido") {
            $msgErro = "Informe um e-mail válido.";
        } elseif ($_GET["erro"] == "email_duplicado") {
            $msgErro = "Este e-mail já está cadastrado.";
        }
    }
?>

<?php include("../../includes/cabecalho.php"); ?>

<?php include("../../includes/menu_admin2.php"); ?>

<!DOCTYPE html>

<html>

    <head>

        <title>Usuários</title>

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
            
        <div class="w3-container w3-round-xxlarge w3-card-4"
            style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
            <div class="w3-center">
                <br>
                <h2 class="w3-center" style="color: #e67b39;"><b>Cadastrar Novo Usuário</b></h2>
            </div>

            <?php if ($msgErro != "") { ?>
                <div class="w3-panel w3-pale-red w3-border w3-round-large w3-margin-top">
                    <p><?php echo $msgErro; ?></p>
                </div>
            <?php } ?>

            <form class="w3-container" action="criar_usuario_Action.php" method="post">
                <div class="w3-section">
                    <label style="font-weight: bold;">Nome</label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
                        name="nome" placeholder="Digite seu nome" required
                        value="<?php echo $valNome; ?>">

                    <label style="font-weight: bold;">E-mail</label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="email"
                        name="email" placeholder="Digite seu e-mail" required
                        value="<?php echo $valEmail; ?>">

                    <label style="font-weight: bold;">Senha</label>
                    <div style="position:relative;">
                        <input class="w3-input w3-border w3-round-xxlarge" type="password" placeholder="Digite a senha"
                            name="senha" id="txtSenhaCad" required>
                        <span onclick="togglePasswordCad()" style="position:absolute; right:10px; top:10px; cursor:pointer;">
                            <img src="https://img.icons8.com/ios-glyphs/24/000000/visible.png" id="toggleIconCad" alt="Mostrar senha"/>
                        </span>
                    </div>
                    <script>
                        function togglePasswordCad() {
                            var senha = document.getElementById('txtSenhaCad');
                            var icon = document.getElementById('toggleIconCad');
                            if (senha.type == "password") {
                                senha.type = "text";
                                icon.src = "https://img.icons8.com/ios-glyphs/24/000000/invisible.png";
                            } else {
                                senha.type = "password";
                                icon.src = "https://img.icons8.com/ios-glyphs/24/000000/visible.png";
                            }
                        }
                    </script>

                    <label style="font-weight: bold;">Tipo de Usuário</label>
                    <select class="w3-select w3-border w3-section w3-padding w3-round-xxlarge" name="tipo">
                        <option>Usuário</option>
                        <option>Administrador</option>
                    </select>

                    <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit"
                            style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                        <b>Cadastrar</b>
                    </button>

                    <?php 
                        if(isset ($_SESSION['exibir_botao'])):
                    ?>    
                        <div class="w3-container w3-section w3-center">
                            <a href="info_usuario.php" style="color: #e67b39; font-weight: bold;">Adicionar Informações do Usuário</a>
                        </div>
                    <?php endif; ?>
                </div>
            </form>

            <div class="w3-container w3-section w3-center">
                <a href="../../admin/dashboard.php" style="color: #e67b39; font-weight: bold;">Voltar ao Início</a>
            </div>
            <br>
        </div>

        <?php include("../../includes/rodape.php"); ?>

    </body>
    
    <?php include("../../includes/rodape.php"); ?>
</html>