<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Plano de Treino Semanal</b></h2>
        <p>Gerencie os exercícios do seu plano semanal, editando, adicionando ou removendo atividades.</p>
    </div>

    <hr>

    <div class="w3-row-padding" style="margin-top: 30px;">

        <!-- Informações gerais -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Informações Gerais</b></h3>
                <p><b>Objetivo:</b></p>
                <p><b>Nível:</b></p>
                <p><b>Data de início:</b></p>
                <p><b>Data de fim:</b></p>
            </div>
        </div>

        <!-- Seleção do dia -->
        <div class="w3-col l6 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Selecionar Dia</b></h3>
                <label for="diaSemana"><b>Dia da semana</b></label>
                <select id="diaSemana"
                        class="w3-select w3-border w3-round-xxlarge w3-margin-top"
                        onchange="mostrarTreino()">
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

        <!-- Área dos treinos -->
        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4"
                 style="padding: 20px; margin-bottom: 20px;">

                <div id="segunda" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Segunda-feira</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>

                </div>

                <div id="terca" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Terça-feira</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>

                <div id="quarta" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Quarta-feira</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>

                <div id="quinta" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Quinta-feira</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>

                <div id="sexta" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Sexta-feira</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>

                <div id="sabado" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Sábado</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>

                <div id="domingo" class="treino-dia" style="display: none;">
                    <h3 style="color: #e67b39;"><b>Domingo</b></h3>

                    <div class="w3-container w3-round-xxlarge w3-card-4"
                         style="padding: 16px; margin-top: 16px;">
                        <strong></strong>
                        <p></p>
                    </div>
                </div>
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
        document.getElementById(diaSelecionado).style.display = 'block';
    }
}
</script>

<hr>
<?php include("includes/rodape.php"); ?>