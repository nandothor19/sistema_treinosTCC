<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

        .drop-down__button {
            background-color: white;
            color: #e67b39;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .drop-down__name {
            font-size: 16px;
        }

        .drop-down__icon {
            width: 16px;
            height: 16px;
            fill: #e67b39;
        }

        .drop-down__menu-box {
            display: none;
            position: absolute;
            top: 55px;
            right: 0;
            width: 20%;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            overflow: hidden;
            z-index: 1000;
        }

        .drop-down__menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .drop-down__item {
            border-bottom: 1px solid #ddd;
        }

        .drop-down__item:last-child {
            border-bottom: none;
        }

        .drop-down__item a {
            display: block;
            padding: 14px 18px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: background 0.2s;
        }

        .drop-down__item a:hover {
            background-color: #f2f2f2;
        }

        main {
            padding: 30px;
        }
    </style>
</head>
<body>

<header>
    <div style="display:flex; justify-content:space-between; align-items:center;">

    <h1><b>Painel Administrativo</b></h1>
    
    <div class="drop-down"> 
        <div id="dropDown" class="drop-down__button">
            <span class="drop-down__name">☰ Menu</span>
            <svg class="drop-down__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                <path d="M31.3 192h257.3c28.4 0 42.8 34.5 22.6 54.6L182.6 375.3c-12.5 12.5-32.8 12.5-45.3 0L8.7 246.6C-11.5 226.5 2.9 192 31.3 192z"/>
            </svg>
        </div>

        <div class="drop-down__menu-box">
            <ul class="drop-down__menu">
                <li class="drop-down__item">
                    <a href="../../admin/dashboard.php">🏠︎ Dashboard</a>
                </li>
                <li class="drop-down__item">
                    <a href="../../admin/usuarios.php">📏 Gerenciar Usuários</a>
                </li>
                <li class="drop-down__item">
                    <a href="../../admin/exercicios.php">💪 Gerenciar Exercícios</a>
                </li>
                <li class="drop-down__item">
                    <a href="../../admin/notificacoes.php">🔔 Gerenciar Notificações</a>
                </li>
                <li class="drop-down__item">
                    <a href="../../logout.php">↩ Sair</a>
                </li>

            </ul>
        </div>
    </div>
    </div>
</header>

<main>

<script>
    const dropDown = document.getElementById("dropDown");
    const menuBox = document.querySelector(".drop-down__menu-box");

    dropDown.addEventListener("click", function () {
        menuBox.style.display = menuBox.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function (event) {
        const menu = document.querySelector(".drop-down");
        if (!menu.contains(event.target)) {
            menuBox.style.display = "none";
        }
    });
</script>