<?php
// Conexão com o Banco de Dados
$pdo = new PDO('mysql:host=localhost; dbname=db_teste', 'paulo', '1234567');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Edição de pessoa existente
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Ler os dados da requisição PUT
    parse_str(file_get_contents("php://input"), $dados);

    $id = $dados['id'];
    $nome = $dados['nome'];
    $email = $dados['email'];
    $endereco = $dados['endereco'];
    $usuario_id = $dados['usuario_id'];
    $telefone = $dados['telefone'];

    // Verificar se a pessoa existe
    $verificarPessoa = $pdo->prepare("SELECT id FROM pessoas WHERE id = ?");
    $verificarPessoa->execute([$id]);
    $pessoaExiste = $verificarPessoa->fetchColumn();

    if (!$pessoaExiste) {
        echo 'Pessoa não encontrada.';
        exit; // Termina a execução do script PHP
    }

    $sql = $pdo->prepare("UPDATE pessoas SET nome = ?, email = ?, endereco = ?, usuario_id = ?, telefone = ? WHERE id = ?");
    $sql->execute([$nome, $email, $endereco, $usuario_id, $telefone, $id]);
    echo 'Pessoa atualizada com sucesso!';
    exit; // Termina a execução do script PHP após a atualização do registro
}

// Inclusão de nova pessoa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o usuário existe
    $usuario_id = $_POST['usuario_id'];
    $verificarUsuario = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
    $verificarUsuario->execute([$usuario_id]);
    $usuarioExiste = $verificarUsuario->fetchColumn();

    if (!$usuarioExiste) {
        echo 'Usuário não encontrado.';
        exit; // Termina a execução do script PHP
    }

    $sql = $pdo->prepare("INSERT INTO pessoas VALUES(null,?,?,?,?,?)");
    $sql->execute([$_POST['nome'], $_POST['email'], $_POST['endereco'], $_POST['usuario_id'], $_POST['telefone']]);
    echo 'Pessoa cadastrada com sucesso!';
    exit; // Termina a execução do script PHP após a inclusão do registro
}
?>

