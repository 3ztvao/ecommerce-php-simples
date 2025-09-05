<?php
session_start();


$produtos = [
    1 => ['id' => 1, 'nome' => 'Tênis de Corrida', 'preco' => 299.90],
    2 => ['id' => 2, 'nome' => 'Camiseta Dry-fit', 'preco' => 89.90],
    3 => ['id' => 3, 'nome' => 'Garrafa de Água', 'preco' => 45.50],
    4 => ['id' => 4, 'nome' => 'Meia Esportiva (Par)', 'preco' => 19.90]
];

function getProduto($id, $produtos_array) {
    return $produtos_array[$id] ?? null;
}

if (isset($_GET['remover'])) {
    $id_remover = $_GET['remover'];

    if (isset($_SESSION['carrinho'])) {
        $carrinho_atualizado = [];
        $removido = false;
        foreach ($_SESSION['carrinho'] as $item_id) {
            if ($item_id == $id_remover && !$removido) {
                $removido = true;
                continue;
            }
            $carrinho_atualizado[] = $item_id;
        }
        $_SESSION['carrinho'] = $carrinho_atualizado;
    }
    header('Location: carrinho.php');
    exit;
}

if (isset($_GET['limpar'])) {
    if (isset($_SESSION['carrinho'])) {
        unset($_SESSION['carrinho']);
    }
    header('Location: index.php');
    exit;
}

$itens_carrinho = $_SESSION['carrinho'] ?? [];
$valor_total = 0;
$itens_exibicao = [];

if (!empty($itens_carrinho)) {
    foreach ($itens_carrinho as $item_id) {
        $produto = getProduto($item_id, $produtos);
        if ($produto) {
            $itens_exibicao[] = $produto;
            $valor_total += $produto['preco'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .carrinho-vazio { text-align: center; color: #6c757d; margin-top: 50px; }
        .lista-carrinho { list-style: none; padding: 0; }
        .lista-carrinho li { border-bottom: 1px solid #eee; padding: 10px 0; display: flex; justify-content: space-between; align-items: center; }
        .lista-carrinho li:last-child { border-bottom: none; }
        .remover-btn { color: red; text-decoration: none; font-size: 14px; }
        .remover-btn:hover { text-decoration: underline; }
        .total-container { text-align: right; margin-top: 20px; padding-top: 20px; border-top: 2px solid #ccc; }
        .limpar-btn { background-color: #dc3545; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>

    <h1>Meu Carrinho</h1>
    <p>
        <a href="index.php">Voltar ao Catálogo</a>
    </p>

    <?php if (empty($itens_carrinho)): ?>
        <p class="carrinho-vazio">Seu carrinho está vazio.</p>
    <?php else: ?>
        <ul class="lista-carrinho">
            <?php foreach ($itens_exibicao as $item): ?>
                <li>
                    <span><?php echo htmlspecialchars($item['nome']); ?></span>
                    <span>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                    <a href="carrinho.php?remover=<?php echo $item['id']; ?>" class="remover-btn">Remover</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="total-container">
            <h3>Total: R$ <?php echo number_format($valor_total, 2, ',', '.'); ?></h3>
            <p>
                <a href="carrinho.php?limpar=1" class="limpar-btn">Limpar Carrinho</a>
            </p>
        </div>
    <?php endif; ?>

</body>
</html>