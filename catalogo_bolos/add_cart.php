<?php
require 'db.php';

if (isset($_GET['name'], $_GET['image_url'], $_GET['price'])) {
    // Recebe os dados via GET
    $name = trim($_GET['name']);
    $image_url = trim($_GET['image_url']);
    $price = trim($_GET['price']);

    // Validação básica
    if (empty($name) || !filter_var($image_url, FILTER_VALIDATE_URL) || !is_numeric($price)) {
        echo "Erro: Todos os campos devem estar preenchidos, a URL deve ser válida e o preço deve ser numérico.";
    } else {
        // Insere o item na tabela cart
        $stmt = $conn->prepare("INSERT INTO cart (name, image_url, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $image_url, $price);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Erro ao adicionar o item ao carrinho.";
        }

        $stmt->close();
    }
} else {
    echo "Erro: Parâmetros insuficientes fornecidos!";
}
?>
