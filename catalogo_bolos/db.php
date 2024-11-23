<?php
$servername = "localhost";
$username = "root"; // caso seu usuário não seja "root", edite este campo
$password = ""; //coloque sua senha root
$database = "cake_catalog";

// Ativar relatório de erros detalhados do MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
