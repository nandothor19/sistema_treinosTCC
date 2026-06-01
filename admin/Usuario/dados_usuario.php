<?php

    session_start();

    if (!isset($_SESSION['admin_id'])) {
        header("Location: login.php");
        exit();
    }

    $nome = $_SESSION['admin_nome'];

    $readonly = isset($_GET['readonly']);

    include("../../includes/conexao.php");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $stmt = $conn->prepare("
        SELECT *
        FROM usuarios
        WHERE idUsuario = ?
    ");

    $stmt->execute([$id]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $sexo = $_POST['sexo'];
        $idade = $_POST['idade'];
        $nivelExperiencia = $_POST['nivelExperiencia'];
        $objetivo = $_POST['objetivo'];
        $created_at = $_POST['data_inicio'];
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $cintura = $_POST['cintura'];
        $peito = $_POST['peito'];
        $braco = $_POST['braco'];
        $perna = $_POST['perna'];
        
        $update = $conn->prepare("
            UPDATE usuarios
            SET nome = ?,
            email = ?,
            idade = ?,
            peso = ?,
            sexo = ?,
            altura = ?,
            nivelExperiencia = ?,
            objetivo = ?,
            created_at = ?,
            cintura = ?,
            peito = ?,
            braco = ?,
            perna = ?
            WHERE idUsuario = ?
        ");

        $update->execute([
            $nome,
            $email,
            $idade,
            $peso,
            $sexo,
            $altura,
            $nivelExperiencia,
            $objetivo,
            $created_at,
            $cintura,
            $peito,
            $braco,
            $perna,           
            $id
        ]);  

        header("Location: ../usuarios.php");
        exit();
    }

    include("../../includes/cabecalho.php");

    include("../../includes/menu_admin2.php");
?>

<!DOCTYPE html>

<html>

    <head>

        <title>Usuários</title>

        <link rel="stylesheet"
        href="https://www.w3schools.com/w3css/4/w3.css">

    </head>

    <body>

    <div class="w3-container w3-round-xxlarge w3-card-4"
        style="margin: 70px auto 0 auto; padding: 12px 24px 24px 24px; max-width: 500px; display: block;">
        <div class="w3-center">
            <br>
            <h2 class="w3-center" style="color: #e67b39;"><b>Dados do Usuário</b></h2>
        </div>

        <form class="w3-container" action = "" method="post">
            <div class="w3-section">

                <label style="font-weight: bold;">Nome</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="text"
                    name="nome" placeholder="Digite o nome do Usuário" required
                    value="<?php echo $user['nome']; ?>">
                
                <label style="font-weight: bold;">E-mail</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" type="email"
                    name="email" placeholder="Digite o e-mail do usuário" required
                    value="<?php echo $user['email']; ?>">

                <label style="font-weight: bold;">Sexo</label>
                <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="sexo">
                    <option <?php if($user['sexo'] == 'Masculino') echo 'selected'; ?>>
                        Masculino
                    </option>
                    <option <?php if($user['sexo'] == 'Feminino') echo 'selected'; ?>>
                        Feminino
                    </option>
                </select>

                <label style="font-weight: bold;">Idade</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" name="idade" placeholder="Digite sua idade"
                    value="<?php echo $user['idade']; ?>">

                <label style="font-weight: bold;">Nível de Experiência</label>
                <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="nivelExperiencia">
                    <option <?php if($user['nivelExperiencia'] == 'Iniciante') echo 'selected'; ?>>
                        Iniciante
                    </option>
                    <option <?php if($user['nivelExperiencia'] == 'Intermediário') echo 'selected'; ?>>
                        Intermediário
                    </option>
                    <option <?php if($user['nivelExperiencia'] == 'Avançado') echo 'selected'; ?>>
                        Avançado
                    </option>
                </select>

                <label style="font-weight: bold;">Objetivo</label>
                <select class="w3-select w3-border w3-margin-bottom w3-round-xxlarge" name="objetivo">
                    <option <?php if($user['objetivo'] == 'Emagrecimento') echo 'selected'; ?>>
                        Emagrecimento
                    </option>
                    <option <?php if($user['objetivo'] == 'Hipertrofia') echo 'selected'; ?>>
                        Hipertrofia
                    </option>
                    <option <?php if($user['objetivo'] == 'Condicionamento físico') echo 'selected'; ?>>
                        Condicionamento físico
                    </option>
                </select>

                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                        <label style="font-weight: bold;">Data de Início</label>
                        <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                                type="date" name="data_inicio" id="data_inicio"
                                min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div style="flex: 1;">
                        <label style="font-weight: bold;">Data de Fim</label>
                        <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                                type="date" name="data_fim" id="data_fim"
                                min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                <hr>

                <h3 style="color: #e67b39;"><b>Medidas Corporais</b></h3>

                <label style="font-weight: bold;">Peso (kg)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="0.1" name="peso" placeholder="Ex: 72.50"
                    value="<?php echo $user['peso']; ?>">

                <label style="font-weight: bold;">Altura (cm)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="1" name="altura" placeholder="Ex: 175"
                    value="<?php echo $user['altura']; ?>">

                <label style="font-weight: bold;">Cintura (cm)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="1" name="cintura" placeholder="Ex: 82"
                    value="<?php echo $user['cintura']; ?>">

                <label style="font-weight: bold;">Peito (cm)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="1" name="peito" placeholder="Ex: 95"
                    value="<?php echo $user['peito']; ?>">

                <label style="font-weight: bold;">Braço (cm)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="1" name="braco" placeholder="Ex: 32"
                    value="<?php echo $user['braco']; ?>">

                <label style="font-weight: bold;">Perna (cm)</label>
                <input class="w3-input w3-border w3-margin-bottom w3-round-xxlarge" 
                    type="number" step="1" name="perna" placeholder="Ex: 52"
                    value="<?php echo $user['perna']; ?>">

                <button class="w3-button w3-block w3-section w3-padding w3-round-xxlarge" type="submit" 
                        style="background: transparent; color: #e67b39; border: 3px solid #e67b39;">
                    <b>Salvar</b>
                </button>
                
                <div class="w3-container w3-section w3-center">
                    <?php if($readonly): ?>
                        <a href="../Usuario/dados_usuario.php?id=<?php echo $id; ?>" style="color: #e67b39; font-weight: bold;">
                            Editar Dados do Usuário
                        </a>
                    <?php endif; ?>
                </div>
            </div>

        </form>
    </div>

    <?php if($readonly): ?>

        <script>
            document.addEventListener("DOMContentLoaded", () => {

                document.querySelectorAll('input, textarea').forEach(el => {
                    el.readOnly = true;
                });

                document.querySelectorAll(
                    'select, button, input[type=checkbox], input[type=radio]'
                ).forEach(el => {
                    el.disabled = true;
                });

            });
        </script>

    <?php endif; ?>

    </body>
    <footer>
        <p>&copy; 2026 - Sistema de Elaboração de Treinos</p>
    </footer>
</html>