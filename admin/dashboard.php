<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include("../includes/conexao.php");

?>

<!DOCTYPE html>

<html>

<head>

    <title>Painel Admin</title>

    <link rel="stylesheet"
    href="https://www.w3schools.com/w3css/4/w3.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .conteudo {
            flex: 1;
        }

    </style>

</head>

<body class="w3-light-grey">

<div class="conteudo">

    <div class="w3-container"
    style="background:#e67b39; color:white; text-align:center;">

        <h2>Painel Administrativo</h2>

    </div>

    <!-- MENU -->

    <div class="w3-bar w3-black"
    style="display:flex; width:100%;">

        <a href="dashboard.php"
        class="w3-bar-item w3-button"
        style="flex:1; text-align:center;">
            Dashboard
        </a>

        <a href="usuarios.php"
        class="w3-bar-item w3-button"
        style="flex:1; text-align:center;">
            Usuários
        </a>

        <a href="exercicios.php"
        class="w3-bar-item w3-button"
        style="flex:1; text-align:center;">
            Exercícios
        </a>       

        <a href="notificacoes.php"
        class="w3-bar-item w3-button"
        style="flex:1; text-align:center;">
            Notificações
        </a>

        <a href="../logout.php"
        class="w3-bar-item w3-button"
        style="flex:1; text-align:center;">
            Sair
        </a>

    </div>

<?php

/* =========================
   GRÁFICO EXERCÍCIOS
========================= */

$exercicios = $conn->query("
    SELECT grupoMuscular, COUNT(*) as qnt_ex
    FROM exercicios
    GROUP BY grupoMuscular
");

$grupoMuscular = [];
$qnt_ex = [];

while($row = $exercicios->fetch(PDO::FETCH_ASSOC)){

    $grupoMuscular[] = $row['grupoMuscular'];
    $qnt_ex[] = $row['qnt_ex'];
}

/* =========================
   GRÁFICO USUÁRIOS
========================= */

$usuarios_idd = $conn->query("
    SELECT idade, COUNT(*) as qnt_p_idd
    FROM usuarios
    GROUP BY idade
");

$usuarios_nvl = $conn->query("
    SELECT nivelExperiencia, COUNT(*) as qnt_p_nvl
    FROM usuarios
    GROUP BY nivelExperiencia
");

$usuarios_sexo = $conn->query("
    SELECT sexo, COUNT(*) as qnt_p_sexo
    FROM usuarios
    GROUP BY sexo
");

$dados = [];

/* IDADE */

$dados['Idade'] = [
    'x' => [],
    'y' => []
];

while($row = $usuarios_idd->fetch(PDO::FETCH_ASSOC)){

    $dados['Idade']['x'][] = (string)$row['idade'];
    $dados['Idade']['y'][] = $row['qnt_p_idd'];
}

/* NÍVEL */

$dados['Nível de Experiência'] = [
    'x' => [],
    'y' => []
];

while($row = $usuarios_nvl->fetch(PDO::FETCH_ASSOC)){

    $dados['Nível de Experiência']['x'][] =
    $row['nivelExperiencia'];

    $dados['Nível de Experiência']['y'][] =
    $row['qnt_p_nvl'];
}

/* SEXO */

$dados['Sexo'] = [
    'x' => [],
    'y' => []
];

while($row = $usuarios_sexo->fetch(PDO::FETCH_ASSOC)){

    $dados['Sexo']['x'][] = $row['sexo'];

    $dados['Sexo']['y'][] = $row['qnt_p_sexo'];
}

?>

<div style="
display:flex;
justify-content:center;
gap:30px;
align-items:flex-end;
flex-wrap:wrap;
margin-top:30px;
">

    <!-- GRÁFICO 1 -->

    <div class="w3-card w3-white w3-padding w3-round-xxlarge"
    style="
    width:500px;
    height:450px;
    border:2px solid #e67b39;
    display:flex;
    flex-direction:column;
    ">

        <label><b>Selecionar variável:</b></label>

        <select id="user_var"
        class="w3-select w3-border
        w3-margin-bottom w3-round-xxlarge"
        style="text-align:center; width:100%;">

            <option>Idade</option>
            <option>Nível de Experiência</option>
            <option>Sexo</option>

        </select>

    <div style="flex:1; position:relative; height:320px; width:100%;">
        <canvas id="myChart"></canvas>
    </div>
    </div>

    <!-- GRÁFICO 2 -->

    <div class="w3-card w3-white w3-padding w3-round-xxlarge"
    style="
    width:500px;
    height:450px;
    border:2px solid #e67b39;
    display:flex;
    flex-direction:column;
    ">

    <div style="flex:1; position:relative; height:320px; width:100%;">
        <canvas id="graficoex"></canvas>
    </div>
    </div>

</div>

</div>

<!-- =========================
     SCRIPT GRÁFICO USUÁRIOS
========================= -->

<script>

const dados = <?= json_encode($dados) ?>;

const select =
document.getElementById('user_var');

const ctx1 =
document.getElementById('myChart');

let chart = new Chart(ctx1, {

    type: 'bar',

    data: {

        labels: [],

        datasets: [{

            label: 'Quantidade de Usuários',

            data: [],

            borderColor: 'blue',

            backgroundColor:
            'rgba(0,0,255,0.2)',

            borderWidth: 2,

            tension: 0.3,

            fill: true
        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        plugins: {

            title: {
                display: true,
                text: 'Análise de Usuários',
                font: {
                    size: 16
                }
            },

            legend: {
                position: 'bottom'
            }

        },
        scales: {

            y: {
                beginAtZero: true
            }
        }
    }
});

function atualizarDados(){

    const valor = select.value;

    const eixo_x = dados[valor].x;

    const eixo_y = dados[valor].y;

    chart.data.labels = eixo_x;

    chart.data.datasets[0].data = eixo_y;

    chart.update();
}

select.addEventListener('change', atualizarDados);

atualizarDados();

</script>

<!-- =========================
     SCRIPT GRÁFICO EXERCÍCIOS
========================= -->

<script>

const grupoMuscular =
<?= json_encode($grupoMuscular) ?>;

const qnt_ex =
<?= json_encode($qnt_ex) ?>;

const ctx2 =
document.getElementById('graficoex');

new Chart(ctx2, {

    type: 'bar',

    data: {

        labels: grupoMuscular,

        datasets: [{

            label: 'Quantidade de Exercícios',

            data: qnt_ex,

            borderColor: '#e67b39',

            backgroundColor:
            'rgba(230,123,57,0.3)',

            borderWidth: 1
        }]
    },

    options: {

        responsive: true,

        maintainAspectRatio: false,
        plugins: {

            title: {
                display: true,
                text: 'Análise de Exercícios',
                font: {
                    size: 16
                }
            },

            legend: {
                position: 'bottom'
            }

        },
        scales: {

            y: {
                beginAtZero: true
            }   
        }
    }
});

</script>

</body>
</html>

<?php include("../includes/rodape.php"); ?>