<?php
session_start();  // sempre na primeira linha quando usa sessão

// Validar campos vazios
if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login.php?erro=2');
    exit;
}

// Pega o que veio do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// ✅ USAR MOCK DATA, NÃO O BANCO REAL
require_once 'mock_data.php';
$usuarios = MockData::get('usuarios');

// Busca o usuário no mock
$usuario = null;
foreach ($usuarios as $u) {
    if ($u['email'] === $email) {
        $usuario = $u;
        break;
    }
}

// Verifica se existe e se a senha bate
if ($usuario && password_verify($senha, $usuario['senha'])) {
    // Login OK — salva na sessão e manda para a área certa
    $_SESSION['usuario_id']   = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['perfil']       = $usuario['perfil_id'] == 1 ? 'cliente' : 'funcionario';

    if ($_SESSION['perfil'] === 'funcionario') {
        header('Location: funcionario/pedidos.php');
    } else {
        header('Location: cliente/pedidos.php');
    }
    exit;
} else {
    // Login falhou — volta com mensagem de erro
    header('Location: login.php?erro=1');
    exit;
}
