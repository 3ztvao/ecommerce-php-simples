<?php
session_start();

$produtos = [
    1 => ['id' => 1, 'nome' => 'Tênis de Corrida', 'preco' => 299.90],
    2 => ['id' => 2, 'nome' => 'Camiseta Dry-fit', 'preco' => 89.90],
    3 => ['id' => 3, 'nome' => 'Garrafa de Água', 'preco' => 45.50],
    4 => ['id' => 4, 'nome' => 'Meia Esportiva (Par)', 'preco' => 19.90]
];
if (isset($_GET['adicionar']) && array_key_exists($_GET['adicionar'], $produtos)) {
    $id_produto = $_GET['adicionar'];

    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    $_SESSION['carrinho'][] = $id_produto;
    header('Location: index.php');
    exit;
}

$total_itens = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .header-carrinho { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .produtos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .produto-item { border: 1px solid #ccc; padding: 15px; border-radius: 8px; }
        .produto-item h3 { margin-top: 0; }
        .produto-item .preco { font-weight: bold; color: #007bff; }
        .adicionar-btn { display: block; text-align: center; background-color: #28a745; color: white; padding: 10px; text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .adicionar-btn:hover { background-color: #218838; }
    </style>
</head>
<body>

    <div class="header-carrinho">
        <h1>Catálogo de Produtos</h1>
        <p>
            <a href="carrinho.php">Ver Carrinho (<?php echo $total_itens; ?> itens)</a>
        </p>
    </div>

    <div class="produtos-grid">
        <?php foreach ($produtos as $produto): ?>
        <div class="produto-item">
            <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
            <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
            <a href="index.php?adicionar=<?php echo $produto['id']; ?>" class="adicionar-btn">Adicionar ao Carrinho</a>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>