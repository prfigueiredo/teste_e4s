<?php
//Exibição
$pdo = new PDO('mysql:host=localhost; dbname=db_teste', 'paulo', '1234567');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->query("SELECT * FROM usuarios");
$pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($usuarios);
?>