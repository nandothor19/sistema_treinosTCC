<?php 
include("includes/cabecalho.php"); 
include("includes/menu.php");
include("includes/conexao.php");

session_start();

$userId = $_SESSION['id_Usuario'];

$sql = "
SELECT * FROM notificacoes
WHERE id_Usuario = ?
ORDER BY dataEnvio DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_Usuario);
$stmt->execute();

$result = $stmt->get_result();
?>

<section class="w3-container" style="margin-top: 30px;">

    <div class="w3-center">
        <h2 style="color: #e67b39;">
            <b>Notificações</b>
        </h2>

        <p>
            Aqui você acompanha avisos importantes do sistema,
            como lembretes de treino, períodos de descanso e
            atualizações do seu plano.
        </p>

        <hr>

        <div class="bloco-notificacao
        w3-container w3-round-xxlarge w3-card-4"

        style="
        margin: 70px auto 0 auto;
        padding: 12px 24px;
        max-width: 500px;
        display: block;
        ">

        <?php while($notificacao = $result->fetch_assoc()) { ?>

            <div class="notificacao w3-round-xxlarge"

            style="
            margin: 20px auto 0 auto;
            padding: 12px 24px;
            max-width: 500px;
            display: block;
            border: 2px solid rgb(0, 0, 0);
            ">

                <h3>
                    <?php echo $notificacao['titulo']; ?>
                </h3>

                <p>
                    <?php echo $notificacao['mensagem']; ?>
                </p>

                <span>
                    <?php
                    echo date(
                        'd/m/Y H:i',
                        strtotime($notificacao['dataEnvio'])
                    );
                    ?>
                </span>

            </div>

        <?php } ?>

        </div>
    </div>

</section>

<hr>

<?php include("includes/rodape.php"); ?>