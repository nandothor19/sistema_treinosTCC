<?php
session_start();

$valNome = "";
$valEmail = "";
if (isset($_SESSION["cadastro_nome"])) {
    $valNome = $_SESSION["cadastro_nome"];
    unset($_SESSION["cadastro_nome"]);
}
if (isset($_SESSION["cadastro_email"])) {
    $valEmail = $_SESSION["cadastro_email"];
    unset($_SESSION["cadastro_email"]);
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
<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<div class="w3-container w3-round-xxlarge w3-card-4"
     style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    <div class="w3-center">
        <br>
        <h2 class="w3-center" style="color: #e67b39;"><b>Cadastro</b></h2>
    </div>

    <?php if ($msgErro != "") { ?>
        <div class="w3-panel w3-pale-red w3-border w3-round-large w3-margin-top">
            <p><?php echo $msgErro; ?></p>
        </div>
    <?php } ?>

    <form class="w3-container" action="cadastroAction.php" method="post">
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

            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit"
                    style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                <b>Cadastrar</b>
            </button>
        </div>
    </form>

    <div class="w3-container w3-section w3-center">
        <a href="login.php" style="color: #e67b39; font-weight: bold;">Voltar ao login</a>
    </div>
    <br>
</div>
<?php include("includes/rodape.php"); ?>
