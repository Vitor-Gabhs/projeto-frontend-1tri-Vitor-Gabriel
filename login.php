<?php
session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Lavanderia On-line</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="titulos-LOL">
        <h1 class="titulo-principal">LOL</h1>
        <h2 class="titulo-menor">Lavanderia On-line</h2>
    </div>
    <form class="area-login" action="processa_login.php" method="POST">
        <input type="text" class="campo-user" name="email" placeholder="e-mail" required><br>
        <input type="password" class="campo-senha" name="senha" placeholder="senha" required><br>
        <button class="botão" type="submit">ENTRAR</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>