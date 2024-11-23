<?php
require 'db.php';

try {
    // Deleta todos os itens do carrinho
    $query = "DELETE FROM cart";
    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Erro ao deletar os itens: " . $conn->error);
    }

    // Redireciona de volta para a página do carrinho
    header("Location: cart.php");
    exit();
} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
