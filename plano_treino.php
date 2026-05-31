<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'] ?? 'Usuário';

include("includes/conexao.php");

// Buscar plano de treino do usuário (futuro: você pode expandir esta parte)
$stmt = $conn->prepare("
    SELECT u.nome, u.objetivo, u.nivelExperiencia, 
           p.dataInicio, p.dataFim
    FROM usuarios u
    LEFT JOIN plano_treino p ON u.idUsuario = p.idUsuario
    WHERE u.idUsuario = ?
");
$stmt->execute([$usuario_id]);
$plano = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Plano de Treino Semanal</b></h2>
        <p>Gerencie seu plano de treino personalizado.</p>
    </div>

    <hr>

    <div class="w3-row-padding" style="margin-top: 30px;">

        <!-- Informações Gerais -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Informações Gerais</b></h3>
                <p><b>Objetivo:</b> <?php echo htmlspecialchars($plano['objetivo'] ?? 'Não definido'); ?></p>
                <p><b>Nível:</b> <?php echo htmlspecialchars($plano['nivelExperiencia'] ?? 'Não informado'); ?></p>
                <p><b>Data de Início:</b> <?php echo $plano['dataInicio'] ?? '—'; ?></p>
                <p><b>Data de Fim:</b> <?php echo $plano['dataFim'] ?? '—'; ?></p>
            </div>
        </div>

        <!-- Seleção do Dia -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Selecionar Dia</b></h3>
                <label for="diaSemana"><b>Dia da semana</b></label>
                <select id="diaSemana" class="w3-select w3-border w3-round-xxlarge w3-margin-top" onchange="mostrarTreino()">
                    <option value="">-- Escolha um dia --</option>
                    <option value="segunda">Segunda-feira</option>
                    <option value="terca">Terça-feira</option>
                    <option value="quarta">Quarta-feira</option>
                    <option value="quinta">Quinta-feira</option>
                    <option value="sexta">Sexta-feira</option>
                    <option value="sabado">Sábado</option>
                    <option value="domingo">Domingo</option>
                </select>
            </div>
        </div>

        <!-- Área dos Treinos (ainda estática por enquanto - podemos melhorar depois) -->
        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">

                <div id="segunda" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Segunda-feira - Peito / Tríceps</b></h3>
                    <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 16px; margin-top: 16px;">
                        <strong>Supino Reto</strong><br>
                        <p>4 séries × 12 repetições</p>
                    </div>
                </div>

                <div id="terca" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Terça-feira - Costas / Bíceps</b></h3>
                    <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 16px; margin-top: 16px;">
                        <strong>Puxada Frontal</strong><br>
                        <p>4 séries × 10 repetições</p>
                    </div>
                </div>

                <!-- Adicione os outros dias conforme necessário -->

            </div>
        </div>
    </div>
</section>

<script>
function mostrarTreino() {
    const dias = document.querySelectorAll('.treino-dia');
    const diaSelecionado = document.getElementById('diaSemana').value;

    dias.forEach(function(dia) {
        dia.style.display = 'none';
    });

    if (diaSelecionado !== '') {
        const elemento = document.getElementById(diaSelecionado);
        if (elemento) elemento.style.display = 'block';
    }
}
</script>

<hr>
<?php include("includes/rodape.php"); ?>