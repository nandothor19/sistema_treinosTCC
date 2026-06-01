<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}?>
<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Meu Progresso</b></h2>
        <p>Acompanhe sua consistência e evolução no plano de <b>Hipertrofia</b>.</p>
    </div>

    <hr>

    <div class="w3-row-padding" style="margin-top: 30px;">
        
        <div class="w3-col l12 m12 s12 w3-margin-bottom">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px;">
                <h3 style="color: #e67b39;"><b>Conclusão do Plano Mensal</b></h3>
                <p>Meta: <b>01/04/2026 a 30/04/2026</b></p>
                
                <div class="w3-light-grey w3-round-xlarge" style="height:24px">
                    <div class="w3-container w3-round-xlarge" style="width:65%; height:24px; background-color: #e67b39; text-align: center; color: white;">
                        65%
                    </div>
                </div>
                <p class="w3-small w3-text-grey">Você completou <b>18</b> dos <b>28</b> treinos planejados.</p>
            </div>
        </div>

        <div class="w3-col l12 m12 s12 w3-margin-bottom">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px;">
                <h3 style="color: #e67b39;"><b>Volume de Séries por Dia</b></h3>
                <div style="position: relative; height:300px; width:100%">
                    <canvas id="graficoEvolucao"></canvas>
                </div>
            </div>
        </div>

        <div class="w3-col l4 m12 s12 w3-margin-bottom">
            <div class="w3-container w3-round-xxlarge w3-card-4 w3-center" style="padding: 20px; border-top: 5px solid #e67b39;">
                <h4 class="w3-text-grey">Frequência</h4>
                <h2 style="color: #e67b39;"><b>92%</b></h2>
                <p>Nos últimos <b>30</b> dias</p>
            </div>
        </div>

        <div class="w3-col l4 m12 s12 w3-margin-bottom">
            <div class="w3-container w3-round-xxlarge w3-card-4 w3-center" style="padding: 20px; border-top: 5px solid #e67b39;">
                <h4 class="w3-text-grey">Exercícios</h4>
                <h2 style="color: #e67b39;"><b>145</b></h2>
                <p>Séries executadas este mês</p>
            </div>
        </div>

        <div class="w3-col l4 m12 s12 w3-margin-bottom">
            <div class="w3-container w3-round-xxlarge w3-card-4 w3-center" style="padding: 20px; border-top: 5px solid #e67b39;">
                <h4 class="w3-text-grey">Peso Médio</h4>
                <h2 style="color: #e67b39;"><b>+2.5kg</b></h2>
                <p>Evolução de carga total</p>
            </div>
        </div>

        <div class="w3-col l12 m12 s12">
            <div class="w3-container w3-round-xxlarge w3-card-4" style="padding: 20px; margin-bottom: 20px;">
                <h3 style="color: #e67b39;"><b>Checklist da Semana</b></h3>
                <ul class="w3-ul">
                    <li class="w3-display-container">Segunda-feira: Supino, Rosca e Agachamento 
                        <span class="w3-tag w3-green w3-round w3-display-right" style="margin-right:10px;">Feito ✅</span>
                    </li>
                    <li class="w3-display-container">Terça-feira: Puxada Frontal 
                        <span class="w3-tag w3-green w3-round w3-display-right" style="margin-right:10px;">Feito ✅</span>
                    </li>
                    <li class="w3-display-container">Quarta-feira: Leg Press 
                        <span class="w3-tag w3-orange w3-round w3-display-right" style="margin-right:10px; color: white;">Pendente ⏳</span>
                    </li>
                    <li class="w3-display-container w3-text-grey">Quinta-feira: Desenvolvimento 
                        <span class="w3-display-right" style="margin-right:10px;">Aguardando</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
const ctx = document.getElementById('graficoEvolucao').getContext('2d');
new Chart(ctx, {
    type: 'bar', 
    data: {
        labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        datasets: [{
            label: 'Séries Planejadas',
            // Dados extraídos do seu plano: Segunda(11), Terça(4), Quarta(4), Quinta(3), Sexta(4), Sábado(1), Domingo(0)
            data: [11, 4, 4, 3, 4, 1, 0],
            backgroundColor: 'rgba(230, 123, 57, 0.7)',
            borderColor: '#e67b39',
            borderWidth: 1,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<hr>
<?php include("includes/rodape.php"); ?>