<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$cadastroNome = $_SESSION['cadastro_nome'] ?? '';
$cadastroEmail = $_SESSION['cadastro_email'] ?? '';

include("includes/conexao.php");

// Buscar dados existentes (caso já tenha preenchido antes)
$stmt = $conn->prepare("
    SELECT u.*, m.* 
    FROM usuarios u 
    LEFT JOIN medidas_corporais m ON u.idUsuario = m.idUsuario 
    WHERE u.idUsuario = ?
    ORDER BY m.dataRegistro DESC LIMIT 1
");
$stmt->execute([$usuario_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>     

<div class="w3-container w3-round-xxlarge w3-card-4"
     style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 600px;">
    
    <div class="w3-center">
        <br>
        <h2 style="color: #e67b39;"><b>Informações Complementares</b></h2>
        <p>Complete seu perfil para personalizar seu plano de treino.</p>
    </div>

    <form class="w3-container" action="info_usuario_action.php" method="post">
        <div class="w3-section">

            <label style="font-weight: bold;">Nome</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="text" name="nome" value="<?php echo htmlspecialchars($user['nome'] ?? $cadastroNome); ?>" required>

            <label style="font-weight: bold;">E-mail</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? $cadastroEmail); ?>" required>

            <label style="font-weight: bold;">Sexo</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="sexo">
                <option value="Masculino" <?php if(($user['sexo']??'') == 'Masculino') echo 'selected'; ?>>Masculino</option>
                <option value="Feminino" <?php if(($user['sexo']??'') == 'Feminino') echo 'selected'; ?>>Feminino</option>
            </select>

            <label style="font-weight: bold;">Idade</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" name="idade" value="<?php echo $user['idade'] ?? ''; ?>" required>

            <label style="font-weight: bold;">Nível de Experiência</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="nivelExperiencia">
                <option value="Iniciante" <?php if(($user['nivelExperiencia']??'') == 'Iniciante') echo 'selected'; ?>>Iniciante</option>
                <option value="Intermediário" <?php if(($user['nivelExperiencia']??'') == 'Intermediário') echo 'selected'; ?>>Intermediário</option>
                <option value="Avançado" <?php if(($user['nivelExperiencia']??'') == 'Avançado') echo 'selected'; ?>>Avançado</option>
            </select>

            <label style="font-weight: bold;">Objetivo</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="objetivo">
                <option value="Emagrecimento" <?php if(($user['objetivo']??'') == 'Emagrecimento') echo 'selected'; ?>>Emagrecimento</option>
                <option value="Hipertrofia" <?php if(($user['objetivo']??'') == 'Hipertrofia') echo 'selected'; ?>>Hipertrofia</option>
                <option value="Condicionamento físico" <?php if(($user['objetivo']??'') == 'Condicionamento físico') echo 'selected'; ?>>Condicionamento físico</option>
            </select>

            <div style="display: flex; gap: 10px;">
                <div style="flex: 1;">
                    <label style="font-weight: bold;">Data de Início</label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                           type="date" name="data_inicio" value="<?php echo $user['dataInicio'] ?? date('Y-m-d'); ?>" required>
                </div>
                <div style="flex: 1;">
                    <label style="font-weight: bold;">Data de Fim</label>
                    <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                           type="date" name="data_fim" value="<?php echo $user['dataFim'] ?? ''; ?>" required>
                </div>
            </div>

            <hr>
            <h3 style="color: #e67b39;"><b>Medidas Corporais</b></h3>

            <label>Peso (kg)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="peso" value="<?php echo $user['peso'] ?? ''; ?>" required>

            <label>Altura (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="altura" value="<?php echo $user['altura'] ?? ''; ?>" required>

            <label>Cintura (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="cintura" value="<?php echo $user['cintura'] ?? ''; ?>" required>

            <label>Peito (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="peito" value="<?php echo $user['peito'] ?? ''; ?>" required>

            <label>Braço (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="braco" value="<?php echo $user['braco'] ?? ''; ?>" required>

            <label>Perna (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="perna" value="<?php echo $user['perna'] ?? ''; ?>" required>

            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" 
                    style="background: transparent; color: #e67b39; border: 3px solid #e67b39;">
                <b>Salvar Informações</b>
            </button>
        </div>
    </form>
</div>

<?php include("includes/rodape.php"); ?>