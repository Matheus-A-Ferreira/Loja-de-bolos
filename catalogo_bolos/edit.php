<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM cakes WHERE id = $id");
    $cake = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['cake_name']);
        $image_url = trim($_POST['cake_image_url']);
        $price = trim($_POST['cake_price']);

        if (empty($name) || !filter_var($image_url, FILTER_VALIDATE_URL)) {
            echo "Erro: Todos os campos devem estar preenchidos e a URL deve ser válida.";
        } else {
            $stmt = $conn->prepare("UPDATE cakes SET name = ?, image_url = ?, price = ? WHERE id = ?");
            $stmt->bind_param("ssdi", $name, $image_url, $price, $id);
            $stmt->execute();
            echo "Bolo atualizado com sucesso!";
            header("Location: admin.php");
            exit();
        }
    }
} else {
    echo "Bolo não encontrado!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Bolo</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="myCSS/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px; padding: 20px;">
            <h2>Editar Bolo</h2>
            <form method="post" class="shadow p-4 rounded bg-light">
                <div class="form-group">
                    <label for="cake_name">Nome do Bolo:</label>
                    <input type="text" class="form-control" id="cake_name" name="cake_name" value="<?php echo htmlspecialchars($cake['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cake_price">Preço do Bolo:</label>
                    <input type="text" class="form-control" id="cake_price" name="cake_price" step="0.01" required value="<?php echo htmlspecialchars($cake['price']); ?>">
                </div>
                <div class="form-group">
                    <label for="cake_image">URL da Imagem:</label>
                    <input type="url" class="form-control" id="cake_image" name="cake_image_url" value="<?php echo htmlspecialchars($cake['image_url']); ?>" required oninput="updateImage()">
                </div>
                <div class="mt-3 text-center">
                    <img id="preview_image" src="<?php echo htmlspecialchars($cake['image_url']); ?>" alt="Pré-visualização do bolo" class="img-fluid" style="max-height: 300px; display: <?php echo empty($cake['image_url']) ? 'none' : 'block'; ?>; border: 1px solid #ccc; padding: 10px;">
                </div>
                <div class="d-flex mt-3 options">
                    <button type="submit" class="btn btn-primary">Atualizar Bolo</button>
                    <a href="admin.php" class="btn btn-secondary back">Voltar ao Catálogo</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Função para atualizar a pré-visualização da imagem
        function updateImage() {
            const imageUrl = document.getElementById('cake_image').value;
            const previewImage = document.getElementById('preview_image');
            
            if (imageUrl) {
                previewImage.src = imageUrl;
                previewImage.style.display = 'block';
            } else {
                previewImage.style.display = 'none';
            }
        }

        // Atualizar a imagem inicial ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            updateImage();
        });
    </script>
</body>
</html>
