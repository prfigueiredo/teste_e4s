<?php
//Exibição
$pdo = new PDO('mysql:host=localhost; dbname=db_teste', 'paulo', '1234567');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT * FROM pessoas");
$pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($pessoas);

//Edição
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Obter os dados da pessoa a ser editada
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verificar se todos os campos necessários estão presentes
    if (isset($data['id']) && isset($data['nome']) && isset($data['idade'])) {
        $id = $data['id'];
        $nome = $data['nome'];
        $idade = $data['idade'];

        // Atualizar os dados da pessoa no banco de dados
        $stmt = $pdo->prepare("UPDATE pessoas SET nome = :nome, idade = :idade WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->execute();

        // Verificar se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Pessoa atualizada com sucesso.'));
        } else {
            echo json_encode(array('message' => 'Nenhuma pessoa encontrada com o ID especificado.'));
        }
    } else {
        echo json_encode(array('message' => 'Dados incompletos. É necessário fornecer o ID, nome e idade da pessoa.'));
    }
}

//Exclusão
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Obter o ID da pessoa a ser excluída
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verificar se o ID está presente
    if (isset($data['id'])) {
        $id = $data['id'];

        // Excluir a pessoa do banco de dados
        $stmt = $pdo->prepare("DELETE FROM pessoas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Verificar se a exclusão foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Pessoa excluída com sucesso.'));
        } else {
            echo json_encode(array('message' => 'Nenhuma pessoa encontrada com o ID especificado.'));
        }
    } else {
        echo json_encode(array('message' => 'ID da pessoa não fornecido.'));
    }
}
?>

