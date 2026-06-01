<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'] ?? 'Usuário';

include("includes/conexao.php");

// Buscar dados completos do usuário
$stmt = $conn->prepare("
    SELECT * 
    FROM usuarios
    WHERE idUsuario = ? 
    ORDER BY dataRegistro DESC LIMIT 1
");
$stmt->execute([$usuario_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Painel do Usuário</b></h2>
        <p>Bem-vindo(a) ao seu painel de treino.</p>
    </div>

    <div class="w3-row-padding" style="margin-top: 30px;">

        <!-- Boas-vindas -->
        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Olá, <?php echo htmlspecialchars($nome); ?> 👋</b></h3>
                <p>Bem-vindo(a) ao seu painel de treino. Continue acompanhando sua evolução.</p>
            </div>
        </div>

        <!-- Informações do usuário -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Informações do Usuário</b></h3>
                <p><b>Nome:</b> <?php echo htmlspecialchars($user['nome'] ?? 'Não informado'); ?></p>
                <p><b>Idade:</b> <?php echo $user['idade'] ?? 'Não informado'; ?> anos</p>
                <p><b>Objetivo:</b> <?php echo htmlspecialchars($user['objetivo'] ?? 'Não definido'); ?></p>
                <p><b>Nível:</b> <?php echo htmlspecialchars($user['nivelExperiencia'] ?? 'Não informado'); ?></p>
            </div>
        </div>

        <!-- Treino de hoje -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Treino de Hoje</b></h3>
                <p><b>Dia:</b> Segunda-feira</p>
                <p><b>Grupo muscular:</b> Peito / Bíceps</p>
                <p><b>Exercícios programados:</b> 3</p>
                <a href="plano_treino.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Ver Plano Completo
                </a>
            </div>
        </div>

        <!-- Últimas medidas -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Últimas Medidas</b></h3>
                <p><b>Peso:</b> <?php echo $user['peso'] ?? '—'; ?> kg</p>
                <p><b>Cintura:</b> <?php echo $user['cintura'] ?? '—'; ?> cm</p>
                <p><b>Peito:</b> <?php echo $user['peito'] ?? '—'; ?> cm</p>
                <p><b>Braço:</b> <?php echo $user['braco'] ?? '—'; ?> cm</p>
                <p><b>Perna:</b> <?php echo $user['perna'] ?? '—'; ?> cm</p>
                <a href="info_usuario.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Atualizar Medidas
                </a>
            </div>
        </div>

        <!-- Notificações -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Notificações</b></h3>
                <p>✅ Seu treino de hoje está disponível.</p>
                <p>📌 Atualize suas medidas esta semana.</p>
                <a href="notificacoes.php" class="w3-button w3-round-xxlarge"
                   style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">
                    Ver Todas
                </a>
            </div>
        </div>

    </div>
</section>

<?php include("includes/rodape.php"); ?>