<?php
session_start();
require 'db.php';

// Fetch cakes from the database
try {
    $query = "SELECT id, name, image_url, price FROM cart";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Failed to fetch data: " . $conn->error);
    }

    // Check if there are any cakes in the cart
    $isEmpty = $result->num_rows === 0;

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="myCSS\style.css">
</head>
<body>
    <?php include "user_header.html"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Carrinho de Compras</h1>
        <a href="index.php" class="btn btn-primary mb-3">Continuar a comprar</a>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Nome</th>
                    <th>Imagem</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($bolo = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($bolo['name']) ?></td>
                            <td><img src="<?= htmlspecialchars($bolo['image_url']) ?>" width="100"></td>
                            <td>R$<?= htmlspecialchars($bolo['price']) ?></td>
                            <td>
                                <a href="delete_cart.php?id=<?= $bolo['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Nenhum bolo encontrado no carrinho.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a class="btn btn-success" href="buy.php" onclick='return <?= $isEmpty ? "alert(\"O carrinho está vazio! Não há itens para comprar.\"); false" : "alert(\"Obrigado prla preferência!\");" ?>'>Finalizar compra</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
