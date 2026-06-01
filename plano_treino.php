<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['usuario_nome'] ?? 'Usuário';

include("includes/conexao.php");

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE idUsuario = ?");
$stmt->execute([$usuario_id]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$sexo = strtolower(trim($usuario["sexo"]));
$objetivo = strtolower(trim($usuario["objetivo"]));
$nivel = $usuario["nivelExperiencia"];

include("includes/cabecalho.php");
include("includes/menu.php");

class GeradorTreino {

    public function gerarPlano($sexo, $objetivo) {

        $divisao = $this->definirDivisao($sexo);
        $plano = [];

        foreach ($divisao as $dia => $grupo) {
            $plano[$dia] = $this->montarTreino($grupo, $objetivo, $sexo, $dia);
        }

        return $plano;
    }

    private function definirDivisao($sexo) {

        if ($sexo == "feminino") {

            return [
                "segunda" => "pernas",
                "terca" => "costas",
                "quarta" => "posterior",
                "quinta" => "bracos",
                "sexta" => "gluteo"
            ];
        }

        return [
            "segunda" => "peito",
            "terca" => "costas",
            "quarta" => "pernas",
            "quinta" => "ombro",
            "sexta" => "pernas"
        ];
    }

    private function montarTreino($grupo, $objetivo, $sexo, $dia) {

        $treinosFemininos = [

            "segunda" => [
                ["nome"=>"Agachamento na barra guiada","series"=>"4","reps"=>"10"],
                ["nome"=>"Afundo","series"=>"4","reps"=>"10"],
                ["nome"=>"Mesa flexora","series"=>"3","reps"=>"10"],
                ["nome"=>"Leg 45°","series"=>"4","reps"=>"10"],
                ["nome"=>"Cadeira extensora","series"=>"4","reps"=>"10"],
                ["nome"=>"Cadeira adutora","series"=>"4","reps"=>"10"]
            ],

            "terca" => [
                ["nome"=>"Pull down","series"=>"4","reps"=>"10"],
                ["nome"=>"Remada baixa com triângulo","series"=>"4","reps"=>"10"],
                ["nome"=>"Puxada alta com triângulo","series"=>"4","reps"=>"10"],
                ["nome"=>"Crucifixo inverso","series"=>"4","reps"=>"10"],
                ["nome"=>"Elevação lateral","series"=>"3","reps"=>"10"],
                ["nome"=>"Desenvolvimento","series"=>"3","reps"=>"10"]
            ],

            "quarta" => [
                ["nome"=>"Stiff","series"=>"4","reps"=>"10"],
                ["nome"=>"Búlgaro","series"=>"4","reps"=>"10"],
                ["nome"=>"Agachamento sumô","series"=>"3","reps"=>"12"],
                ["nome"=>"Cadeira flexora","series"=>"4","reps"=>"10"],
                ["nome"=>"Extensão de quadril na polia","series"=>"4","reps"=>"10"]
            ],

            "quinta" => [
                ["nome"=>"Tríceps francês","series"=>"4","reps"=>"10"],
                ["nome"=>"Rosca Scott","series"=>"4","reps"=>"10"],
                ["nome"=>"Tríceps na polia","series"=>"4","reps"=>"12"],
                ["nome"=>"Rosca martelo","series"=>"3","reps"=>"10"]
            ],

            "sexta" => [
                ["nome"=>"Cadeira abdutora","series"=>"4","reps"=>"10"],
                ["nome"=>"Búlgaro","series"=>"4","reps"=>"8"],
                ["nome"=>"Elevação Pélvica","series"=>"4","reps"=>"10"],
                ["nome"=>"Abdução de quadril na polia","series"=>"4","reps"=>"10"],
                ["nome"=>"Levantamento terra sumô","series"=>"4","reps"=>"10"]
            ]
        ];

        $treinosMasculinos = [

            "segunda" => [
                ["nome"=>"Supino reto","series"=>"3","reps"=>"10"],
                ["nome"=>"Supino inclinado","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Crucifixo Máquina","series"=>"2","reps"=>"Falha"],
                ["nome"=>"Tríceps corda","series"=>"3","reps"=>"10-12"],
                ["nome"=>"Tríceps testa","series"=>"3","reps"=>"10-12"]
            ],

            "terca" => [
                ["nome"=>"Puxada alta aberta","series"=>"3","reps"=>"10"],
                ["nome"=>"Remada baixa (triângulo)","series"=>"3","reps"=>"8-12"],
                ["nome"=>"Pull down","series"=>"3","reps"=>"10-12"],
                ["nome"=>"Rosca direta 45º","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Rosca Scott","series"=>"4","reps"=>"10"]
            ],

            "quarta" => [
                ["nome"=>"Agachamento Hack","series"=>"4","reps"=>"10"],
                ["nome"=>"Cadeira extensora","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Mesa flexora","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Leg 45º","series"=>"4","reps"=>"8"],
                ["nome"=>"Panturrilha","series"=>"3","reps"=>"12"]
            ],

            "quinta" => [
                ["nome"=>"Desenvolvimento (halter)","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Elevação lateral","series"=>"4","reps"=>"10"],
                ["nome"=>"Crucifixo inverso","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Rosca martelo","series"=>"3","reps"=>"12"],
                ["nome"=>"Rosca Scott + tríceps corda","series"=>"4","reps"=>"10"],
                ["nome"=>"Tríceps francês","series"=>"3","reps"=>"8"]
            ],

            "sexta" => [
                ["nome"=>"Agachamento barra guiada","series"=>"3","reps"=>"10"],
                ["nome"=>"Cadeira adutora","series"=>"3","reps"=>"8"],
                ["nome"=>"Cadeira flexora","series"=>"3","reps"=>"8-10"],
                ["nome"=>"Cadeira extensora","series"=>"3","reps"=>"12"],
                ["nome"=>"Panturrilha","series"=>"3","reps"=>"10-12"]
            ]
        ];

        $treino = ($sexo == "feminino")
            ? $treinosFemininos[$dia]
            : $treinosMasculinos[$dia];

        foreach ($treino as &$exercicio) {
            $exercicio["descanso"] = "2 min";
        }

        if ($objetivo == "hipertrofia") {

            $treino[] = [
                "nome" => "Cardio",
                "series" => "-",
                "reps" => "24 min",
                "descanso" => "-"
            ];
        }

        if ($objetivo == "emagrecimento") {

            $treino[] = [
                "nome" => "Cardio",
                "series" => "-",
                "reps" => "35 min",
                "descanso" => "-"
            ];
        }

        return $treino;
    }
}

$gerador = new GeradorTreino();
$plano = $gerador->gerarPlano($sexo, $objetivo);
?>

<section class="w3-container" style="margin-top: 30px;">

    <div class="w3-center">
        <h2 style="color: #e67b39;">
            <b>Plano de Treino Semanal</b>
        </h2>

        <p>
            Gerencie os exercícios do seu plano semanal.
        </p>
    </div>

    <hr>

    <div class="w3-row-padding" style="margin-top:30px;">

        <!-- Informações -->
        <div class="w3-col l6 m12 s12">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px; margin-bottom:20px;">

                <h3 style="color:#e67b39;">
                    <b>Informações Gerais</b>
                </h3>

                <p>
                    <b>Objetivo:</b>
                    <?= ucfirst($objetivo) ?>
                </p>

                <p>
                    <b>Nível:</b>
                    <?= ucfirst($nivel) ?>
                </p>

                <p>
                    <b>Sexo:</b>
                    <?= ucfirst($sexo) ?>
                </p>

            </div>
        </div>

        <!-- Seleção -->
        <div class="w3-col l6 m12 s12">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px; margin-bottom:20px;">

                <h3 style="color:#e67b39;">
                    <b>Selecionar Dia</b>
                </h3>

                <label for="diaSemana">
                    <b>Dia da semana</b>
                </label>

                <select id="diaSemana"
                        class="w3-select w3-border w3-round-xxlarge w3-margin-top"
                        onchange="mostrarTreino()">

                    <option value="">
                        -- Escolha um dia --
                    </option>

                    <option value="segunda">Segunda-feira</option>
                    <option value="terca">Terça-feira</option>
                    <option value="quarta">Quarta-feira</option>
                    <option value="quinta">Quinta-feira</option>
                    <option value="sexta">Sexta-feira</option>

                </select>

            </div>
        </div>
    </div>

    <div class="w3-center" style="margin-top:20px;">
    <button onclick="mostrarTodos()"
            class="w3-button w3-green w3-round-xxlarge">
        Restaurar Exercícios
    </button>
</div>


    <!-- Treinos -->
    <?php foreach($plano as $dia => $exercicios): ?>

        <div id="<?= $dia ?>"
             class="treino-dia"
             style="display:none; margin-top:20px;">

            <div class="w3-container w3-card-4 w3-round-xxlarge"
                 style="padding:20px;">

                <h3 style="color:#e67b39; text-transform:capitalize;">
                    <?= $dia ?>
                </h3>

               <?php foreach($exercicios as $ex): ?>

    <div class="w3-container w3-round-xxlarge exercicio"
         style="
            background:#fff5d6;
            padding:15px;
            margin-top:15px;
            border-left:5px solid #e67b39;
         ">

        <label>
           <input type="checkbox"
       data-dia="<?= $dia ?>"
       data-exercicio="<?= $ex['nome'] ?>"
       onchange="marcarFeito(this)">
            <strong>
                <?= $ex['nome'] ?>
            </strong>
        </label>

        <br><br>

        Séries:
        <?= $ex['series'] ?>

        |

        Repetições:
        <?= $ex['reps'] ?>

        |

        Descanso:
        <?= $ex['descanso'] ?>

        <br><br>

        <button
            class="w3-button w3-round-xxlarge"
            onclick="removerExercicio(this)"
            style="
                background:transparent;
                color:#c00000;
                border:2px solid #c00000;
            ">
            🗑️ Remover
        </button>

    </div>

<?php endforeach; ?>

            </div>

        </div>

    <?php endforeach; ?>

</section>

<script>

function mostrarTreino() {

    const dias = document.querySelectorAll('.treino-dia');

    const diaSelecionado =
        document.getElementById('diaSemana').value;

    dias.forEach(function(dia) {

        dia.style.display = 'none';

    });

    if (diaSelecionado !== '') {

        document.getElementById(diaSelecionado)
            .style.display = 'block';
    }
}
function marcarFeito(checkbox) {

    fetch('salvar_progresso.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body:
            'dia=' + checkbox.dataset.dia +
            '&exercicio=' + checkbox.dataset.exercicio
    });

    const card = checkbox.closest('.exercicio');

    if (checkbox.checked) {

        card.style.backgroundColor = '#d4edda';
        card.style.borderLeft = '5px solid green';
        card.style.opacity = '0.9';

    } else {

        card.style.backgroundColor = '#fff5d6';
        card.style.borderLeft = '5px solid #e67b39';
        card.style.opacity = '1';
    }
}

function removerExercicio(botao) {

    const card = botao.closest('.exercicio');

    card.style.display = 'none';
}

function mostrarTodos() {

    const exercicios =
        document.querySelectorAll('.exercicio');

    exercicios.forEach(function(exercicio) {

        exercicio.style.display = 'block';

    });
}
</script>


<hr>

<?php include("includes/rodape.php"); ?>