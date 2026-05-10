<?php

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Pagina Inicial Cliente</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="css/style.css">
        <script src="script.js"></script>
    </head>
    <body>
        <div id="titulos-LOL">
            <h1 id="titulo-principal">LOL</h1>
            <h2 id="titulo-menor">Lavanderia On-line</h2>
        </div>
            <form id="area-login" action="processa_login.php" method="POST">
                <input type="text" id="campo-user" name="email" placeholder="e-mail"><br>
                <input type="password" id="campo-senha" name="senha" placeholder="senha"><br>
                <button id="botão" type="submit">ENTRAR</button>
            </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>