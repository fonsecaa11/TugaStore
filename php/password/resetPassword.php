<?php

require 'conn.php';
$email = $_POST['email'];

$token = bin2hex(random_bytes(32));
$sql = "UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token, date('Y-m-d H:i:s', strtotime('+1 hour')), $email]);

// Enviar link de redefinição por e-mail
$resetLink = "https://seusite.com/reset_password.php?token=" . $token;
mail($email, "Redefinição de Senha", "Clique aqui para redefinir sua senha: " . $resetLink);

$token = $_GET['token'];
$sql = "SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()";
$stmt = $pdo->prepare($sql);
$stmt->execute([$token]);

if ($user = $stmt->fetch()) {
    // Permitir redefinição
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$new_password, $user['id']]);
    echo "Senha redefinida com sucesso!";
} else {
    echo "Token inválido ou expirado.";
}

?>