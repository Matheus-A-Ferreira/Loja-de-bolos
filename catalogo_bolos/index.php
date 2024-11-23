<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['cake_name']);
    $image_url = trim($_POST['cake_image_url']);
    $price = trim($_POST['cake_price']);

    if (empty($name) || !filter_var($image_url, FILTER_VALIDATE_URL)) {
        echo "<div class='alert alert-danger'>Erro: Todos os campos devem estar preenchidos e a URL deve ser válida.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (name, image_url, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $image_url, $price);
        $stmt->execute();

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Bolos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="myCSS\style.css">
</head>
<body>
    <?php include "user_header.html" ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Catálogo de Bolos</h2>
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM cakes");

            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' class='card-img-top' style='height: 250px; object-fit: cover;'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                echo "<p class='card-text'>Preço: R$" . number_format($row['price'], 2, ',', '.') . "</p>";
                echo "<div class='d-flex justify-content-center'>"; // Centraliza o botão
                echo "<a href='add_cart.php?name=" . urlencode($row['name']) . "&image_url=" . urlencode($row['image_url']) . "&price=" . $row['price'] . "' 
                         class='btn btn-success' 
                         onclick='return alert(\"adicionado ao carrinho\")'>
                         Adicionar ao carrinho
                      </a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>