<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {

    header("Location: login.php");
    exit();
}

$nome = $_SESSION['usuario_nome'];

?>
<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Painel do Usuário</b></h2>
        <p>Bem-vindo(a) ao seu painel de treino. Aqui você acompanha suas principais informações.</p>
    </div>

    <div class="w3-row-padding" style="margin-top: 30px;">

        <!-- Boas-vindas -->
        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Olá, <?php echo $nome; ?> 👋</b></h3>
                <p>Bem-vindo(a) ao seu painel de treino. Continue acompanhando sua evolução e seu plano semanal.</p>
            </div>
        </div>

        <!-- Informações do usuário -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Informações do Usuário</b></h3>
                <p><b>Nome:</b></p>
                <p><b>Idade:</b></p>
                <p><b>Objetivo:</b></p>
                <p><b>Nível:</b></p>
            </div>
        </div>

        <!-- Treino de hoje -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Treino de Hoje</b></h3>
                <p><b>Dia:</b></p>
                <p><b>Grupo muscular:</b></p>
                <p><b>Exercícios programados:</b></p>
                <a href="plano_treino.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Ver Plano
                </a>
            </div>
        </div>

        <!-- Últimas medidas -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Últimas Medidas</b></h3>
                <p><b>Peso:</b></p>
                <p><b>Cintura:</b></p>
                <p><b>Peito:</b></p>
                <p><b>Braço:</b></p>
                <p><b>Perna:</b></p>
                <a href="info_usuario.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Editar medidas
                </a>
            </div>
        </div>

        <!-- Notificações -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Notificações</b></h3>
                <p>✅ Seu treino de hoje está disponível.</p>
                <p>📌 Atualize suas medidas corporais esta semana.</p>
                <p>💤 Lembre-se de manter o descanso entre os treinos.</p>
                <a href="notificacoes.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Ver Notificações
                </a>
            </div>
        </div>

        <!-- Acesso rápido -->
        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Acesso Rápido</b></h3>

                <div class="w3-bar w3-center">
                    <a href="plano_treino.php" class="w3-button w3-round-xxlarge w3-margin-right w3-margin-bottom"
                       style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                        Plano de Treino
                    </a>

                    <a href="exercicios.php" class="w3-button w3-round-xxlarge w3-margin-right w3-margin-bottom"
                       style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                        Exercícios
                    </a>

                    <a href="medidas.php" class="w3-button w3-round-xxlarge w3-margin-right w3-margin-bottom"
                       style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                        Medidas Corporais
                    </a>

                    <a href="notificacoes.php" class="w3-button w3-round-xxlarge w3-margin-bottom"
                       style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                        Notificações
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("includes/rodape.php"); ?>