<?php
session_start();
require_once '../mock_data.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
} else if ($_SESSION['perfil'] === 'funcionario') {
    header('location: ../funcionario/pedidos.php');
    exit;
}


$pecas = MockData::get('pecas');


$pedidos = MockData::pedidosDetalhados();


$itens = MockData::itensPedido(2);


$pode = MockData::transicaoValida(
    statusAtualId: 1,
    novoStatusId:  2,
    perfil:        'funcionario'
); // true


$usuario = MockData::encontrar('usuarios', 3);


$novoId = MockData::proximoId('pedidos');


$pedidos   = MockData::get('pedidos');
$pedidos[] = [
    'id'            => $novoId,
    'cliente_id'    => 3,
    'status_id'     => 1,
    'valor_total'   => 30.00,
    'observacoes'   => null,
    'criado_em'     => date('Y-m-d H:i:s'),
    'atualizado_em' => date('Y-m-d H:i:s'),
];
MockData::salvar('pedidos', $pedidos);


file_put_contents('mock_store.json', json_encode(MockData::get(), JSON_PRETTY_PRINT));


if (file_exists('mock_store.json')) {
    $dados = json_decode(file_get_contents('mock_store.json'), true);
    MockData::salvar('pedidos', $dados['pedidos']);

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
   <div class="card shadow-sm p-4">
    <form action="pedidos.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Qual peça deseja lavar?</label>
            <select name="peca_id" class="form-select" required>
                <?php foreach ($pecas as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= $p['nome'] ?> - R$ <?= number_format($p['preco_unitario'], 2, ',', '.') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Quantidade</label>
            <input type="number" name="quantidade" class="form-control" min="1" value="1">
        </div>

        <button type="submit" name="btn_fechar_pedido" class="btn btn-primary w-100">
            <i class="bi bi-check-lg"></i> Confirmar Pedido
        </button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>