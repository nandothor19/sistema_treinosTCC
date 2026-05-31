<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<div class="w3-container w3-round-xxlarge w3-card-4"
         style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    <div class="w3-center">
        <br>
        <img src="img/foto_login.png" alt="Login" style="width:40%" class="w3-circle w3-margin-top">
        <h2 class="w3-center" style="color: #e67b39;"><b>Login</b></h2>
    </div>

    <form class="w3-container" action="loginAction.php" method="post">
        <div class="w3-section">
            <label style="font-weight: bold;">Usuário</label>
            <input class="w3-input w3-border w3-round-xxlarge w3-margin-bottom" type="text" placeholder="Digite o nome" name="txtNome" required>

            <label style="font-weight: bold;">Senha</label>
            <div style="position:relative;">
                <input class="w3-input w3-border w3-round-xxlarge" type="password" placeholder="Digite a Senha" name="txtSenha" id="txtSenha" required>

                <span onclick="togglePassword()" style="position:absolute; right:10px; top:10px; cursor:pointer;">
                    <img src="https://img.icons8.com/ios-glyphs/24/000000/visible.png" id="toggleIcon" alt="Mostrar senha"/>
                </span>
            </div>
            <script>
                function togglePassword() {
                    var senha = document.getElementById('txtSenha');
                    var icon = document.getElementById('toggleIcon');
                    if (senha.type === "password") {
                        senha.type = "text";
                        icon.src = "https://img.icons8.com/ios-glyphs/24/000000/invisible.png";
                    } else {
                        senha.type = "password";
                        icon.src = "https://img.icons8.com/ios-glyphs/24/000000/visible.png";
                    }
                }
            </script>
                
            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge"
                    style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                <b>Entrar</b>
            </button>
        </div>
    </form>

    <div class="w3-container w3-section">
        <a href="cadastro.php" class="w3-button w3-block w3-padding w3-round-xxlarge"
           style="background: transparent; color: #e67b39; border: 2px solid #e67b39; text-decoration: none; text-align: center;">
            <b>Cadastre-se</b>
        </a>
    </div>
    <br>
</div>
<?php include("includes/rodape.php"); ?>            