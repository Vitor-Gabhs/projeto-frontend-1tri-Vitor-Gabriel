<?php
session_start();  // sempre na primeira linha quando usa sessão

// Validação básica dos campos (evita avisos quando acessado diretamente)
if (empty($_POST['email']) || empty($_POST['senha'])) {
    header('Location: login.php?erro=2');
    exit;
}

// Trim para evitar espaços acidentais
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

// Usar o caminho absoluto para garantir que carregue o arquivo correto
require_once __DIR__ . '/mock_data.php';
$usuarios = MockData::get('usuarios');

// Busca o usuário no mock (comparação case-insensitive para maior tolerância)
$usuario = null;
foreach ($usuarios as $u) {
    if (strtolower($u['email']) === strtolower($email)) {
        $usuario = $u;
        break;
    }
}

// Verifica senha (se usuário encontrado)
$senhaOk = $usuario ? password_verify($senha, $usuario['senha']) : false;

// DEBUG TEMPORÁRIO (remova após depurar) — não loga a senha em texto claro, apenas o comprimento
$debug = [
    'time' => date('c'),
    'post_email' => $email,
    'post_senha_len' => strlen($senha),
    'found_user' => $usuario ? true : false,
    'found_email' => $usuario['email'] ?? null,
    'stored_hash_preview' => $usuario ? substr($usuario['senha'], 0, 12) . '...' : null,
    'password_verify' => $senhaOk ? 'OK' : 'FAIL',
];
file_put_contents(__DIR__ . '/login_debug.log', json_encode($debug, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);

if ($usuario && $senhaOk) {
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
