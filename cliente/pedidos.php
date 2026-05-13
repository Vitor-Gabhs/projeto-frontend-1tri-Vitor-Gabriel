<?php
session_start();
require_once '../mock_data.php';



$caminhoCliente = 'mock_store.json';
$caminhoFuncionario = '../funcionario/pedidos_alterados.json';

if (file_exists($caminhoCliente)) {
    $dadosMestre = json_decode(file_get_contents($caminhoCliente), true);
} else {
    $dadosMestre = MockData::get();
}

$pedidosFinais = [];
if (isset($dadosMestre['pedidos'])) {
    foreach ($dadosMestre['pedidos'] as $p) {
        $pedidosFinais[$p['id']] = $p;
    }
}

if (file_exists($caminhoFuncionario)) {
    $dadosF = json_decode(file_get_contents($caminhoFuncionario), true);
    if (is_array($dadosF)) {
        foreach ($dadosF as $p) {
            $pedidosFinais[$p['id']] = $p;
        }
    }
}

MockData::salvar('pedidos', array_values($pedidosFinais));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_fechar_pedido'])) {
    $idEscolhido = $_POST['peca_id'];
    $qtd = (int) $_POST['quantidade'];
    $peca = MockData::encontrar('pecas', $idEscolhido);

    if ($peca) {
        $total = $peca['preco_unitario'] * $qtd;
        
        $novoId = count($pedidosFinais) > 0 ? max(array_keys($pedidosFinais)) + 1 : 1;

        $novoPedido = [
            'id' => $novoId,
            'cliente_id' => $_SESSION['usuario_id'],
            'status_id' => 1,
            'valor_total' => $total,
            'observacoes' => null,
            'criado_em' => date('Y-m-d H:i:s'),
            'atualizado_em' => date('Y-m-d H:i:s'),
        ];

        $pedidosFinais[$novoId] = $novoPedido;

        $dadosMestre['pedidos'] = array_values($pedidosFinais);
        
        file_put_contents($caminhoCliente, json_encode($dadosMestre, JSON_PRETTY_PRINT));
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Agora os pedidos detalhados estarão limpinhos
$meusPedidos = MockData::pedidosDetalhados();
$pecas = MockData::get('pecas');
?>
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lavanderia LOL - Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { background-color: #e6d5bc; }
        .card-pedido { transition: transform 0.2s; }
        .card-pedido:hover { transform: scale(1.02); }
    </style>
</head>
<body>
    <div class="titulos-LOL my-4">
        <h1 class="titulo-principal">LOL</h1>
        <h2 class="titulo-menor">Lavanderia On-line</h2>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm p-4">
                    <h4>Novo Pedido</h4>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">O que vamos lavar?</label>
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
            </div>

            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Meus Pedidos</h2>
                </div>

                <div class="row">
                    <?php 
                    $cont = 0;
                    foreach ($meusPedidos as $p): 
                        if ($p['cliente_id'] == $_SESSION['usuario_id']): 
                            $cont++;
                    ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm card-pedido">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Pedido #<?= $p['id'] ?></span>
                                    <span class="badge bg-primary"><?= $p['status_nome'] ?></span>
                                </div>
                                <div class="card-body">
                                    <p class="mb-1 text-muted small">Data: <?= date('d/m/Y H:i', strtotime($p['criado_em'])) ?></p>
                                    <h4 class="card-title text-success">R$ <?= number_format($p['valor_total'], 2, ',', '.') ?></h4>
                                </div>
                                <div class="card-footer bg-transparent border-0">
                                    <small class="text-muted">Última atualização: <?= date('d/m/Y H:i', strtotime($p['atualizado_em'])) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endif; 
                    endforeach; 
                    
                    if($cont === 0) echo "<p class='text-muted'>Você ainda não fez nenhum pedido.</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>