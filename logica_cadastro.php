<?php
// Conexão com o Banco de Dados
$pdo = new PDO('mysql:host=localhost; dbname=db_teste', 'paulo', '1234567');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retorna nome, email e status da tabela 'usuarios'
    $sql = $pdo->prepare("SELECT nome, email, status FROM usuarios");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    
    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nome'])) {
        // Inclusão de novo usuário
        $sql = $pdo->prepare("INSERT INTO usuarios VALUES(null,?,?,?,?,?)");
        $sql->execute(array($_POST['nome'], $_POST['email'], $_POST['usuario'], $_POST['senha'], $_POST['status']));
        echo 'Usuário cadastrado com sucesso!';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);

    // Atualização de usuário existente
    $sql = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, usuario = ?, senha = ?, status = ? WHERE id = ?");
    $sql->execute(array($_PUT['nome'], $_PUT['email'], $_PUT['usuario'], $_PUT['senha'], $_PUT['status'], $_PUT['id']));
    echo 'Usuário atualizado com sucesso!';
}
?>

