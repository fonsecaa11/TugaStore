<?php

require 'conn.php'; // Conexão com a base de dados
$password = $_POST['password'];
$hashed_password = password_hash(password: $password, algo: PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_POST['username'], $_POST['email'], $hashed_password]);

?>
