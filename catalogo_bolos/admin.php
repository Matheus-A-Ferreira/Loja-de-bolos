<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de administração</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="myCSS/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Sua Loja</h1>
                <nav>
                    <ul class="nav gap-5">
                        <li class="nav-item"><a href="register.php" class="nav-link text-white">Novo admninstrador</a></li>
                        <li class="nav-item"><a href="cadastro.php" class="nav-link text-white">Novo bolo</a></li>
                        <li class="nav-item"><a href="logout.php" class="nav-link text-white">Sair</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Painel de administração</h2>
        <div class="row a">
            <?php
            $result = $conn->query("SELECT * FROM cakes");

            while ($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' class='card-img-top' style='height: 250px; object-fit: cover;'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['name']) . "</h5>";
                echo "<div class='d-flex justify-content-center'>";
                echo "<a href='edit.php?id=" . $row['id'] . "' class='btn btn-warning mr-2'>Editar</a>";
                echo "<a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Tem certeza que deseja excluir este bolo?\")'>Excluir</a>";
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
