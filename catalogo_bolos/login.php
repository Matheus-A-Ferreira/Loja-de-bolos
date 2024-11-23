<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM employees WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['employee_id'] = $id;
        header("Location: admin.php");
    } else {
        echo "Login inválido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="myCSS\style.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="card mx-auto" style="max-width: 400px; padding: 20px;">
            <h2>Login de Administrador</h2>
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
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
            <div id="register">
                <p>Não é adminstrador? <span><a href="index.php">Voltar ao catálogo</a></span></p>
            </div>
        </div>
    </div>
</body>
</html>
