<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deleta o bolo do banco de dados
    $stmt = $conn->prepare("DELETE FROM cakes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "Bolo excluído com sucesso!";
    header("Location: admin.php");
    exit();
} else {
    echo "Erro: Bolo não encontrado!";
}
?>
