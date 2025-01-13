<?php
session_start();
include('conn.php');

//Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_utilizador = $_SESSION['user_id'];

// Busca os produtos no carrinho do utilizador
$query = "
    SELECT carrinho.id_carrinho, carrinho.user_id, produto.nome, produto.imagem, produto.descricao, produto.preco, tamanho.descricao, carrinho.quantidade 
    FROM carrinho 
    INNER JOIN produto_tamanho ON carrinho.produto_tamanho_id = produto_tamanho.id_produto_tamanho 
    INNER JOIN produto ON produto_tamanho.produto_id = produto.id_produto 
    INNER JOIN tamanho ON produto_tamanho.tamanho_id = tamanho.id_tamanho 
    WHERE carrinho.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_utilizador);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Tuga Store</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img style="width:170px;height:50px;"g  src="image/logo.png" alt="Logo"></a>
            <ul class="menu">
                <li><a href="catalogo.php">Catálogo</a></li>
                <li><a href="sobre-nos.php">Sobre Nós</a></li>
                <li><a href="contactos.php">Contactos</a></li>
            </ul>
            <div class="login-icon">
                <?php
                session_start(); // Inicia ou retoma a sessão
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                    // Exibe o nome do utilizador logado
                    echo "<a href='carrinho.php'>Carrinho</a>";
                    echo "🔒 Bem-vindo, " . htmlspecialchars($_SESSION['username']) . "!";
                    echo " <a href='logout.php'>Sair</a>"; // Link para logout
                } else {
                    // Exibe o link de login
                    echo '<a href="login.php">🔒 Login</a>';
                }
                ?>
            </div>

        </nav>
    </header>
    <main>
        <h1>Carrinho de Compras</h1>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Imagem</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ação</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nome']; ?></td>
                        <td><img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>" style="width: 100px; height: 100px;"></td>
                        <td>€<?php echo number_format($row['preco'], 2); ?></td>
                        <td><?php echo $row['quantidade']; ?></td>
                        <td>€<?php echo number_format($row['preco'] * $row['quantidade'], 2); ?></td>
                        <td>
                            <form action="remover_do_carrinho.php" method="POST">
                                <input type="hidden" name="id_produto" value="<?php echo $row['id_produto']; ?>">
                                <button type="submit">Remover</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>O seu carrinho está vazio.</p>
        <?php endif; ?>
    </main>
</body>
</html>
