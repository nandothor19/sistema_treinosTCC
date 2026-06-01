<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}?>
<?php include("includes/cabecalho.php"); ?>
<?php include("includes/menu.php"); ?>

<section class="w3-container" style="margin-top: 30px;">
    <div class="w3-center">
        <h2 style="color: #e67b39;"><b>Plano de Treino Semanal</b></h2>
    <p>Gerencie os exercícios do seu plano semanal, editando, adicionando ou removendo atividades.</p>

        <hr>

    <div class="bloco-treino
    w3-container w3-round-xxlarge w3-card-4" style="margin: 70px auto 0 auto; padding: 12px 24px 12px 24px; max-width: 500px; display: block;">
        <h3>Segunda-feira</h3>

        <div class="card-exercicio 
        w3-container w3-round-xxlarge w3-card-4" style="margin: 20px auto 0 auto; padding: 12px 24px 12px 24px; max-width: 500px; display: block;">
            <strong>Supino Inclinado</strong>
            <p>4 séries | 10 repetições</p>
            <button class="w3-button w3-round-xxlarge"
                    style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">✏️ Editar</button>
            <button class="w3-button w3-round-xxlarge"
                    style="background: transparent; color:rgb(180, 0, 0); border: 2px solid rgb(180, 0, 0);">🗑️ Remover</button>
        </div>

        <div class="card-exercicio 
         w3-container w3-round-xxlarge w3-card-4" style="margin: 20px auto 0 auto; padding: 12px 24px 12px 24px; max-width: 500px; display: block;">
             <strong>Rosca Direta</strong>
             <p>3 séries | 12 repetições</p>
              <button class="w3-button w3-round-xxlarge"
                      style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">✏️ Editar</button>
              <button class="w3-button w3-round-xxlarge"
                      style="background: transparent; color:rgb(180, 0, 0); border: 2px solid rgb(180, 0, 0);">🗑️ Remover</button>
        </div>

        <div class="card-exercicio 
             w3-container w3-round-xxlarge w3-card-4" style="margin: 20px auto 0 auto; padding: 12px 24px 12px 24px; max-width: 500px; display: block;">
            <strong>Agachamento</strong>
            <p>4 séries | 8 repetições</p>
            <button class="w3-button w3-round-xxlarge"
                    style="background: transparent; color: #e67b39; border: 2px solid #e67b39;">✏️ Editar</button>
            <button class="w3-button w3-round-xxlarge"
                    style="background: transparent; color:rgb(180, 0, 0); border: 2px solid rgb(180, 0, 0);">🗑️ Remover</button>
        </div>

        <button class="w3-button w3-round-xxlarge "
                style="margin: 10px; background: transparent; color:rgb(15, 182, 0); border: 2px solid rgb(15, 182, 0);"> <b>+</b> Adicionar Exercício</button>        
    </div>
</section>

        <hr>

<?php include("includes/rodape.php"); ?>