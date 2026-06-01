<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include("includes/conexao.php");
include("includes/cabecalho.php");
include("includes/menu.php");

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM progresso_treino
    WHERE idUsuario = ?
");
$stmt->execute([$usuario_id]);
$totalConcluidos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$totalPlanejado = 28;

$porcentagem = 0;

if ($totalPlanejado > 0) {
    $porcentagem = min(
        round(($totalConcluidos / $totalPlanejado) * 100),
        100
    );
}

$stmt = $conn->prepare("
    SELECT dia, exercicio, data_conclusao
    FROM progresso_treino
    WHERE idUsuario = ?
    ORDER BY data_conclusao DESC
    LIMIT 10
");
$stmt->execute([$usuario_id]);

$historico = $stmt->fetchAll(PDO::FETCH_ASSOC);

$diasSemana = [
    'segunda' => 0,
    'terca' => 0,
    'quarta' => 0,
    'quinta' => 0,
    'sexta' => 0
];

$stmt = $conn->prepare("
    SELECT dia, COUNT(*) as total
    FROM progresso_treino
    WHERE idUsuario = ?
    GROUP BY dia
");
$stmt->execute([$usuario_id]);

while($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

    if(isset($diasSemana[$linha['dia']])) {
        $diasSemana[$linha['dia']] = $linha['total'];
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="w3-container" style="margin-top:30px;">

    <div class="w3-center">
        <h2 style="color:#e67b39;">
            <b>Meu Progresso</b>
        </h2>

        <p>
            Acompanhe sua evolução no plano de treino.
        </p>
    </div>

    <hr>

    <div class="w3-row-padding" style="margin-top:30px;">

        <div class="w3-col l12 m12 s12 w3-margin-bottom">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px;">

                <h3 style="color:#e67b39;">
                    <b>Conclusão do Plano</b>
                </h3>

                <div class="w3-light-grey w3-round-xlarge"
                     style="height:24px;">

                    <div class="w3-container w3-round-xlarge"
                         style="
                            width:<?= $porcentagem ?>%;
                            height:24px;
                            background-color:#e67b39;
                            color:white;
                            text-align:center;
                         ">

                        <?= $porcentagem ?>%

                    </div>

                </div>

                <p>
                    Você concluiu
                    <b><?= $totalConcluidos ?></b>
                    exercícios.
                </p>

            </div>

        </div>

        <div class="w3-col l4 m12 s12">

            <div class="w3-container w3-card-4 w3-round-xxlarge w3-center"
                 style="
                    padding:20px;
                    border-top:5px solid #e67b39;
                 ">

                <h4 class="w3-text-grey">
                    Exercícios Concluídos
                </h4>

                <h2 style="color:#e67b39;">
                    <b><?= $totalConcluidos ?></b>
                </h2>

            </div>

        </div>

        <div class="w3-col l4 m12 s12">

            <div class="w3-container w3-card-4 w3-round-xxlarge w3-center"
                 style="
                    padding:20px;
                    border-top:5px solid #e67b39;
                 ">

                <h4 class="w3-text-grey">
                    Aproveitamento
                </h4>

                <h2 style="color:#e67b39;">
                    <b><?= $porcentagem ?>%</b>
                </h2>

            </div>

        </div>

        <div class="w3-col l4 m12 s12">

            <div class="w3-container w3-card-4 w3-round-xxlarge w3-center"
                 style="
                    padding:20px;
                    border-top:5px solid #e67b39;
                 ">

                <h4 class="w3-text-grey">
                    Meta
                </h4>

                <h2 style="color:#e67b39;">
                    <b>28</b>
                </h2>

                <p>Exercícios planejados</p>

            </div>

        </div>

        <div class="w3-col l12 m12 s12 w3-margin-top">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px;">

                <h3 style="color:#e67b39;">
                    <b>Treinos por Dia</b>
                </h3>

                <canvas id="graficoTreino"></canvas>

            </div>

        </div>

        <div class="w3-col l12 m12 s12 w3-margin-top">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px;">

                <h3 style="color:#e67b39;">
                    <b>Últimos Exercícios Realizados</b>
                </h3>

                <ul class="w3-ul">

                    <?php foreach($historico as $item): ?>

                        <li>

                            <b><?= ucfirst($item['dia']) ?></b>
                            -
                            <?= $item['exercicio'] ?>

                            <span
                                class="w3-tag w3-green w3-round w3-right">
                                Feito ✅
                            </span>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

    </div>

</section>

<script>

const ctx =
document.getElementById('graficoTreino').getContext('2d');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'Segunda',
            'Terça',
            'Quarta',
            'Quinta',
            'Sexta'
        ],

        datasets: [{

            label: 'Exercícios concluídos',

            data: [
                <?= $diasSemana['segunda'] ?>,
                <?= $diasSemana['terca'] ?>,
                <?= $diasSemana['quarta'] ?>,
                <?= $diasSemana['quinta'] ?>,
                <?= $diasSemana['sexta'] ?>
            ],

            backgroundColor: '#e67b39'
        }]
    },

    options: {

        responsive: true,

        scales: {

            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

<hr>

<?php include("includes/rodape.php"); ?>