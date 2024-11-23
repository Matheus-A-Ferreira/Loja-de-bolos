<?php
require 'db.php';

$successMessage = ""; // Variável para mensagem de sucesso.
$errorMessage = "";   // Variável para mensagem de erro.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verifica se o nome de usuário já existe
    $stmt = $conn->prepare("SELECT COUNT(*) FROM employees WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $errorMessage = "Nome de usuário já existe. Escolha outro.";
    } else {
        // Insere o novo funcionário
        $stmt = $conn->prepare("INSERT INTO employees (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            $successMessage = "Funcionário cadastrado com sucesso.";
        } else {
            $errorMessage = "Erro ao cadastrar o funcionário. Tente novamente.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="myCSS\style.css" rel="stylesheet">
</head>
<body class="row over">
    <div class="col-6">
        <img class="girl" src="assets\happy-birthday-girl-laughs-joyfully-holds-big-tasty-fruit-cake-likes-eating-sweet-food-improves-mood-with-raising-sugar-blood.png" alt="garota com bolo de aniversário - Design by Freepick">
    </div>
    <div class="container col-6">
        <div class="card mx-auto" style="max-width: 400px; padding: 20px;">
            <h2>Cadastro de Funcionário</h2>
            <!-- Exibe mensagens de sucesso ou erro -->
            <?php if ($successMessage): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php elseif ($errorMessage): ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Usuário</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="d-flex mt-3 options">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
        <div class="credits mt-4">Designed by <a href="www.freepik.com">Freepik</a></div>
    </div>
</body>
</html>
