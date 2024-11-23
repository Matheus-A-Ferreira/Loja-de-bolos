<?php
session_start();
require 'db.php';

$successMessage = ""; // Variável para mensagem de sucesso.
$errorMessage = "";   // Variável para mensagem de erro.

if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['cake_name']);
    $image_url = trim($_POST['cake_image_url']);
    $price = trim($_POST['cake_price']);

    if (empty($name) || !filter_var($image_url, FILTER_VALIDATE_URL)) {
        echo "<div class='alert alert-danger'>Erro: Todos os campos devem estar preenchidos e a URL deve ser válida.</div>";
    } else {
        $stmt = $conn->prepare("INSERT INTO cakes (name, image_url, price) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $name, $image_url, $price);
        if($stmt->execute()){
            $successMessage = "Bolo cadastrado com sucesso.";
        }else{
            $errorMessage = "Erro ao cadastrar o bolo. Tente novamente.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Administração - Cadastro de Bolos</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="myCSS\style.css">
</head>
<body class="row over">
    <div class="col-6">
        <img class="cake" src="assets\close-up-view-chocolate-cake-con.png" alt="Bolo de chocolate - design by freepick">
        <div class="credits mt-4" style="color:white;">Designed by <a href="www.freepik.com">Freepik</a></div>
    </div>
    <div class="container mt-5 new_cake col-6">
        <div class="card mx-auto" style="max-width: 400px; padding: 20px;">
            
            <h2 class="mb-4">Cadastro de Bolos</h2>
            <!-- Exibe mensagens de sucesso ou erro -->
            <?php if($successMessage): ?>
                <div class='alert alert-success'><?php echo $successMessage; ?></div>
            <?php elseif($errorMessage): ?>
                <div class='alert alert-success'><?php echo $errorMessage; ?></div>
                <?php endif; ?>
            <!-- Cadastro dos bolos -->
            <form method="post" class="shadow p-4 rounded bg-light">
                <div class="form-group">
                    <label for="cakeName">Nome do Bolo</label>
                    <input type="text" class="form-control" id="cakeName" name="cake_name" required>
                </div>
                <div class="form-group">
                    <label for="cakePrice">Preço</label>
                    <input type="text" class="form-control" id="cakePrice" name="cake_price" required>
                </div>
                <div class="form-group">
                    <label for="cakeImage">URL da Imagem</label>
                    <input type="url" class="form-control" id="cakeImage" name="cake_image_url" required oninput="updateImage()">
                </div>
                <!-- Elemento da imagem -->
                <div class="mt-3 text-center">
                    <img id="previewImage" src="" alt="Pré-visualização do bolo" class="img-fluid" style="max-height: 300px; display: none; border: 1px solid #ccc; padding: 10px;">
                </div>
                <div class="d-flex mt-3 options">
                    <button type="submit" class="btn btn-primary">Cadastrar Bolo</button>
                    <a href="admin.php" class="btn btn-secondary back">Voltar ao Catálogo</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateImage() {
            const imageUrl = document.getElementById('cakeImage').value;
            const previewImage = document.getElementById('previewImage');
            
            if (imageUrl) {
                previewImage.src = imageUrl;
                previewImage.style.display = 'block';
            } else {
                previewImage.style.display = 'none';
            }
        }
    </script>
</body>
</html>
