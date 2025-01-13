<?php
session_start();
include('conn.php');


// Obter os produtos da base de dados
$query = "SELECT id_produto, nome, preco, imagem FROM produto";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Tuga Store</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php"><img class="logo" src="image/logo.png" alt="Logo"></a>
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
    <h1>Catálogo de Produtos</h1>
    <div class="produtos">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="produto">
                <a href="detalhes.php?id_produto=<?php echo $row['id_produto']; ?>">
                    <img src="<?php echo $row['imagem']; ?>" alt="<?php echo htmlspecialchars($row['nome']); ?>">
                </a>
                <h2><?php echo htmlspecialchars($row['nome']); ?></h2>
                <p>€<?php echo number_format($row['preco'], 2, ',', '.'); ?></p>
                <?php if ($row['desconto'] > 0): ?>
                    <p><strong>Desconto:</strong> <?php echo $row['desconto']; ?>%</p>
                <?php endif; ?>
                <form action="adicionar_ao_carrinho.php" method="POST">
                    <input type="hidden" name="id_produto" value="<?php echo $row['id_produto']; ?>">
                    <button type="submit">Adicionar ao Carrinho</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</main>

</body>
</html>
