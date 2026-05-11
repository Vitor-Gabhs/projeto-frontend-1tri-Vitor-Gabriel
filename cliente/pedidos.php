<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
} else if ($_SESSION['perfil'] === 'funcionario') {
    header('location: ../funcionario/pedidos.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pagina Inicial Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../css/style.css">
    <script src="script.js"></script>
</head>

<body>
    <div class="titulos-LOL">
        <h1 class="titulo-principal">LOL</h1>
        <h2 class="titulo-menor">Lavanderia On-line</h2>
    </div>
    <div class="bloco-central">
        <a class="botao-criar" type="button" href="novo_pedido.php"><i class="bi bi-plus-lg"></i></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>