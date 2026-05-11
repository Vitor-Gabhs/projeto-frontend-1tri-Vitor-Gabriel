<?php
/**
 * =============================================================
 *  MOCK DE DADOS — Sistema de Lavanderia
 *  Arquivo: mock_data.php
 *
 *  Finalidade:
 *    Simular o banco de dados inteiramente em memória (arrays PHP).
 *    Útil para desenvolvimento local sem MySQL ou para testes
 *    isolados de lógica de negócio.
 *
 *  Como usar:
 *    require_once 'mock_data.php';
 *    $dados = MockData::get();               // todos os dados
 *    $pedidos = MockData::get('pedidos');    // apenas pedidos
 *    MockData::salvar('pedidos', $lista);    // sobrescreve a coleção
 * =============================================================
 */

class MockData
{
    // -----------------------------------------------------------
    // Dados em memória (equivalente às tabelas do banco)
    // -----------------------------------------------------------
    private static array $store = [];

    // -----------------------------------------------------------
    // Inicializa o store com os dados do enunciado
    // Chamado automaticamente na primeira vez que get() é usado
    // -----------------------------------------------------------
    private static function init(): void
    {
        // ── Perfis ──────────────────────────────────────────────
        self::$store['perfis'] = [
            ['id' => 1, 'nome' => 'cliente'],
            ['id' => 2, 'nome' => 'funcionario'],
        ];

        // ── Status de Pedido (sequência obrigatória) ────────────
        self::$store['status_pedido'] = [
            ['id' => 1, 'nome' => 'ABERTO', 'sequencia' => 1],
            ['id' => 2, 'nome' => 'RECEBIDO', 'sequencia' => 2],
            ['id' => 3, 'nome' => 'EM_LAVAGEM', 'sequencia' => 3],
            ['id' => 4, 'nome' => 'AGUARDANDO_RETIRADA', 'sequencia' => 4],
            ['id' => 5, 'nome' => 'CONCLUIDO', 'sequencia' => 5],
            ['id' => 6, 'nome' => 'CANCELADO', 'sequencia' => 6], // saída lateral
        ];

        // ── Usuários (funcionários + clientes) ──────────────────
        // Senha padrão de todos: senha123
        // Hash gerado via password_hash('senha123', PASSWORD_BCRYPT)
        $hashPadrao = '$2y$10$Xqnzh5oKsuidkXsCuzpCQ.ab2XVLW0Oks8jI7lyjlcdZ66t3fSMNu';

        self::$store['usuarios'] = [
            // Funcionários
            [
                'id' => 1,
                'nome' => 'Maria Silva',
                'email' => 'maria@lavanderia.com',
                'senha' => $hashPadrao,
                'cpf' => '11111111101',
                'telefone' => '41999990001',
                'perfil_id' => 2,           // funcionario
                'criado_em' => '2025-01-10 08:00:00',
            ],
            [
                'id' => 2,
                'nome' => 'Mário Souza',
                'email' => 'mario@lavanderia.com',
                'senha' => $hashPadrao,
                'cpf' => '11111111102',
                'telefone' => '41999990002',
                'perfil_id' => 2,
                'criado_em' => '2025-01-10 08:05:00',
            ],
            // Clientes
            [
                'id' => 3,
                'nome' => 'João Pereira',
                'email' => 'joao@email.com',
                'senha' => $hashPadrao,
                'cpf' => '22222222201',
                'telefone' => '41988880001',
                'perfil_id' => 1,           // cliente
                'criado_em' => '2025-01-11 09:00:00',
            ],
            [
                'id' => 4,
                'nome' => 'José Oliveira',
                'email' => 'jose@email.com',
                'senha' => $hashPadrao,
                'cpf' => '22222222202',
                'telefone' => '41988880002',
                'perfil_id' => 1,
                'criado_em' => '2025-01-11 09:10:00',
            ],
            [
                'id' => 5,
                'nome' => 'Joana Santos',
                'email' => 'joana@email.com',
                'senha' => $hashPadrao,
                'cpf' => '22222222203',
                'telefone' => '41988880003',
                'perfil_id' => 1,
                'criado_em' => '2025-01-11 09:20:00',
            ],
            [
                'id' => 6,
                'nome' => 'Joaquina Lima',
                'email' => 'joaquina@email.com',
                'senha' => $hashPadrao,
                'cpf' => '22222222204',
                'telefone' => '41988880004',
                'perfil_id' => 1,
                'criado_em' => '2025-01-11 09:30:00',
            ],
        ];

        // ── Peças de roupa ──────────────────────────────────────
        self::$store['pecas'] = [
            ['id' => 1, 'nome' => 'Calça', 'preco_unitario' => 12.00, 'criado_em' => '2025-01-10 08:00:00'],
            ['id' => 2, 'nome' => 'Camisa', 'preco_unitario' => 8.00, 'criado_em' => '2025-01-10 08:00:00'],
            ['id' => 3, 'nome' => 'Camiseta', 'preco_unitario' => 6.00, 'criado_em' => '2025-01-10 08:00:00'],
            ['id' => 4, 'nome' => 'Meia', 'preco_unitario' => 3.00, 'criado_em' => '2025-01-10 08:00:00'],
            ['id' => 5, 'nome' => 'Cueca', 'preco_unitario' => 3.50, 'criado_em' => '2025-01-10 08:00:00'],
        ];

        // ── Pedidos ─────────────────────────────────────────────
        self::$store['pedidos'] = [
            [
                'id' => 1,
                'cliente_id' => 3,       // João
                'status_id' => 1,       // ABERTO
                'valor_total' => 48.00,
                'observacoes' => null,
                'criado_em' => '2025-05-01 10:00:00',
                'atualizado_em' => '2025-05-01 10:00:00',
            ],
            [
                'id' => 2,
                'cliente_id' => 4,       // José
                'status_id' => 3,       // EM_LAVAGEM
                'valor_total' => 56.00,
                'observacoes' => 'Roupa delicada, favor lavar a frio.',
                'criado_em' => '2025-05-02 14:00:00',
                'atualizado_em' => '2025-05-03 08:30:00',
            ],
            [
                'id' => 3,
                'cliente_id' => 5,       // Joana
                'status_id' => 5,       // CONCLUIDO
                'valor_total' => 20.00,
                'observacoes' => null,
                'criado_em' => '2025-04-20 09:00:00',
                'atualizado_em' => '2025-04-22 16:00:00',
            ],
        ];

        // ── Itens do pedido ─────────────────────────────────────
        self::$store['itens_pedido'] = [
            // Pedido 1 — João (2 calças + 3 camisas)
            ['id' => 1, 'pedido_id' => 1, 'peca_id' => 1, 'quantidade' => 2, 'preco_unit' => 12.00, 'subtotal' => 24.00],
            ['id' => 2, 'pedido_id' => 1, 'peca_id' => 2, 'quantidade' => 3, 'preco_unit' => 8.00, 'subtotal' => 24.00],

            // Pedido 2 — José
            ['id' => 3, 'pedido_id' => 2, 'peca_id' => 3, 'quantidade' => 5, 'preco_unit' => 6.00, 'subtotal' => 30.00],
            ['id' => 4, 'pedido_id' => 2, 'peca_id' => 4, 'quantidade' => 4, 'preco_unit' => 3.00, 'subtotal' => 12.00],
            ['id' => 5, 'pedido_id' => 2, 'peca_id' => 5, 'quantidade' => 4, 'preco_unit' => 3.50, 'subtotal' => 14.00],

            // Pedido 3 — Joana
            ['id' => 6, 'pedido_id' => 3, 'peca_id' => 1, 'quantidade' => 1, 'preco_unit' => 12.00, 'subtotal' => 12.00],
            ['id' => 7, 'pedido_id' => 3, 'peca_id' => 2, 'quantidade' => 1, 'preco_unit' => 8.00, 'subtotal' => 8.00],
        ];
    }

    // -----------------------------------------------------------
    // Retorna uma coleção ou todas as coleções
    // -----------------------------------------------------------
    public static function get(?string $tabela = null): array
    {
        if (empty(self::$store)) {
            self::init();
        }

        if ($tabela !== null) {
            return self::$store[$tabela] ?? [];
        }

        return self::$store;
    }

    // -----------------------------------------------------------
    // Sobrescreve uma coleção (simula UPDATE / INSERT / DELETE)
    // -----------------------------------------------------------
    public static function salvar(string $tabela, array $dados): void
    {
        if (empty(self::$store)) {
            self::init();
        }
        self::$store[$tabela] = $dados;
    }

    // -----------------------------------------------------------
    // Retorna o próximo ID disponível para uma coleção
    // -----------------------------------------------------------
    public static function proximoId(string $tabela): int
    {
        $colecao = self::get($tabela);
        if (empty($colecao)) {
            return 1;
        }
        return max(array_column($colecao, 'id')) + 1;
    }

    // -----------------------------------------------------------
    // Busca um registro pelo id
    // -----------------------------------------------------------
    public static function encontrar(string $tabela, int $id): ?array
    {
        foreach (self::get($tabela) as $row) {
            if ($row['id'] === $id) {
                return $row;
            }
        }
        return null;
    }

    // -----------------------------------------------------------
    // Helpers para simular JOINs
    // -----------------------------------------------------------

    /** Retorna pedidos com nome do cliente e nome do status */
    public static function pedidosDetalhados(): array
    {
        $pedidos = self::get('pedidos');
        $usuarios = self::get('usuarios');
        $status = self::get('status_pedido');

        $result = [];
        foreach ($pedidos as $p) {
            $cliente = current(array_filter($usuarios, fn($u) => $u['id'] === $p['cliente_id']));
            $st = current(array_filter($status, fn($s) => $s['id'] === $p['status_id']));

            $result[] = array_merge($p, [
                'cliente' => $cliente['nome'] ?? '—',
                'status_nome' => $st['nome'] ?? '—',
                'status_seq' => $st['sequencia'] ?? 0,
            ]);
        }

        return $result;
    }

    /** Retorna itens de um pedido com nome da peça */
    public static function itensPedido(int $pedidoId): array
    {
        $itens = array_filter(self::get('itens_pedido'), fn($i) => $i['pedido_id'] === $pedidoId);
        $pecas = self::get('pecas');

        $result = [];
        foreach ($itens as $item) {
            $peca = current(array_filter($pecas, fn($p) => $p['id'] === $item['peca_id']));
            $result[] = array_merge($item, [
                'peca_nome' => $peca['nome'] ?? '—',
            ]);
        }

        return array_values($result);
    }

    /**
     * Valida se a transição de status é permitida.
     *
     * Regras:
     *  - Funcionário avança um degrau na sequência (1→2, 2→3, 3→4, 4→5)
     *  - Cliente pode cancelar somente pedidos com status ABERTO (seq=1)
     *  - CANCELADO (seq=6) é uma saída lateral, não sequencial
     */
    public static function transicaoValida(int $statusAtualId, int $novoStatusId, string $perfil): bool
    {
        $status = self::get('status_pedido');
        $atual = current(array_filter($status, fn($s) => $s['id'] === $statusAtualId));
        $novo = current(array_filter($status, fn($s) => $s['id'] === $novoStatusId));

        if (!$atual || !$novo) {
            return false;
        }

        $seqAtual = $atual['sequencia'];
        $seqNovo = $novo['sequencia'];

        // Cancelamento: somente clientes, somente quando ABERTO
        if ($novo['nome'] === 'CANCELADO') {
            return $perfil === 'cliente' && $atual['nome'] === 'ABERTO';
        }

        // Funcionários avançam exatamente um degrau
        if ($perfil === 'funcionario') {
            return $seqNovo === $seqAtual + 1 && $seqNovo <= 5;
        }

        return false;
    }
}


// =============================================================
//  EXEMPLOS DE USO (remova em produção)
// =============================================================
if (php_sapi_name() === 'cli') {

    echo "=== Peças disponíveis ===\n";
    foreach (MockData::get('pecas') as $p) {
        printf("  [%d] %-10s R$ %.2f\n", $p['id'], $p['nome'], $p['preco_unitario']);
    }

    echo "\n=== Pedidos detalhados (com JOIN simulado) ===\n";
    foreach (MockData::pedidosDetalhados() as $p) {
        printf(
            "  Pedido #%d | Cliente: %-15s | Status: %-20s | Total: R$ %.2f\n",
            $p['id'],
            $p['cliente'],
            $p['status_nome'],
            $p['valor_total']
        );
    }

    echo "\n=== Itens do Pedido #2 ===\n";
    foreach (MockData::itensPedido(2) as $item) {
        printf(
            "  %-10s  qtd: %d  unit: R$ %.2f  subtotal: R$ %.2f\n",
            $item['peca_nome'],
            $item['quantidade'],
            $item['preco_unit'],
            $item['subtotal']
        );
    }

    echo "\n=== Teste de transição de status ===\n";
    $casos = [
        ['de' => 1, 'para' => 2, 'perfil' => 'funcionario', 'esperado' => true],
        ['de' => 1, 'para' => 3, 'perfil' => 'funcionario', 'esperado' => false],
        ['de' => 1, 'para' => 6, 'perfil' => 'cliente', 'esperado' => true],  // cancelar
        ['de' => 3, 'para' => 6, 'perfil' => 'cliente', 'esperado' => false], // não pode cancelar em lavagem
    ];
    foreach ($casos as $c) {
        $ok = MockData::transicaoValida($c['de'], $c['para'], $c['perfil']) ? 'SIM' : 'NÃO';
        $esperado = $c['esperado'] ? 'SIM' : 'NÃO';
        $icon = $ok === $esperado ? '✓' : '✗';
        printf("  %s  status %d → %d (%s): %s\n", $icon, $c['de'], $c['para'], $c['perfil'], $ok);
    }
}