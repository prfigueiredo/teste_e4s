<?php
// Conecte-se ao banco de dados
$servername = "localhost";
$username = "paulo";
$password = "1234567";
$dbname = "db_teste";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifique se o login e a senha foram enviados via POST
if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Consulte o banco de dados para verificar o usuário
    $sql = "SELECT id FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        echo 'pessoas.html';
    } else {
        echo 'Usuário ou senha inválidos.';
    }
} else {
    echo 'Por favor, preencha todos os campos.';
}
$conn->close();
?>
