<?php
session_start();

$cadastroNome = "";
$cadastroEmail = "";
if (isset($_SESSION["cadastro_nome"])) {
    $cadastroNome = $_SESSION["cadastro_nome"];
    unset($_SESSION["cadastro_nome"]);
}
if (isset($_SESSION["cadastro_email"])) {
    $cadastroEmail = $_SESSION["cadastro_email"];
    unset($_SESSION["cadastro_email"]);
}
?>
<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>     

<div class="w3-container w3-round-xxlarge w3-card-4"
         style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
    
    <div class="w3-center">
        <br>
        <h2 style="color: #e67b39;"><b>Informações do usuário</b></h2>
    </div>

    <form class="w3-container" action="#" method="post">

        <div class="w3-section">

            <label style="font-weight: bold;">Nome</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="text" name="nome" placeholder="Digite seu nome" required
                   value="<?php echo $cadastroNome; ?>">

            <label style="font-weight: bold;">E-mail</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="email" name="email" placeholder="Digite seu e-mail"
                   <?php if ($cadastroEmail != "") { echo "readonly"; } ?>
                   value="<?php echo $cadastroEmail; ?>">

            <label style="font-weight: bold;">Sexo</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="sexo">
                <option>Masculino</option>
                <option>Feminino</option>
            </select>

            <label style="font-weight: bold;">Idade</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" name="idade" placeholder="Digite sua idade" required>

            <label style="font-weight: bold;">Nível de Experiência</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="nivel">
                <option>Iniciante</option>
                <option>Intermediário</option>
                <option>Avançado</option>
            </select>

            <label style="font-weight: bold;">Objetivo</label>
            <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="objetivo">
                <option>Emagrecimento</option>
                <option>Hipertrofia</option>
                <option>Condicionamento físico</option>
            </select>

                <div style="display: flex; gap: 10px;">
                     <div style="flex: 1;">
                     <label style="font-weight: bold;">Data de Início</label>
                     <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                            type="date" name="data_inicio" id="data_inicio" required
                            min="<?php echo date('Y-m-d'); ?>">
                     </div>
                     <div style="flex: 1;">
                     <label style="font-weight: bold;">Data de Fim</label>
                     <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                            type="date" name="data_fim" id="data_fim" required
                            min="<?php echo date('Y-m-d'); ?>">
                     </div>
                </div>

            <hr>

            <h3 style="color: #e67b39;"><b>Medidas Corporais</b></h3>

            <label style="font-weight: bold;">Peso (kg)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="peso" placeholder="Ex: 72.50" required>

            <label style="font-weight: bold;">Altura (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="altura" placeholder="Ex: 175.00" required>

            <label style="font-weight: bold;">Cintura (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="cintura" placeholder="Ex: 82.00" required>

            <label style="font-weight: bold;">Peito (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="peito" placeholder="Ex: 95.00" required>

            <label style="font-weight: bold;">Braço (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="braco" placeholder="Ex: 32.00" required>

            <label style="font-weight: bold;">Perna (cm)</label>
            <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                   type="number" step="0.1" name="perna" placeholder="Ex: 52.00" required>

            <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit" 
                    style="background: transparent; color: #e67b39; border: 3px solid #e67b39;">
                <b>Salvar</b>
            </button>

        </div>
    </form>
</div>

<script>
document.getElementById('data_inicio').addEventListener('change', function() {
    var dataInicio = this.value;
    var dataFim = document.getElementById('data_fim');
    dataFim.min = dataInicio;   
    if (dataFim.value < dataInicio) {
        dataFim.value = '';
    }
});
</script>

<?php include("includes/rodape.php"); ?>    