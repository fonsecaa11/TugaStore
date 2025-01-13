<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tuga Store</title>
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
        <section id="login">
            <h2>Login</h2>
            <form action="autenticar.php" method="POST">
                <label for="username">Utilizador:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required>
                <br><br><br>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
                }
                ?>
                <button type="submit">Entrar</button>
            </form>

            <p>Não tem uma conta? <a href="registar.php">Registe-se aqui</a>.</p>
        </section>

        <section id="sobre-nos">
            <h2>Sobre Nós</h2>
            <p>A <strong>Roupa Tuga</strong> nasceu da paixão pela moda tradicional portuguesa, valorizando a herança cultural com peças contemporâneas inspiradas nas nossas raízes.</p>
        </section>

        <section id="contactos">
            <h2>Contactos</h2>
            <form id="contact-form">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" required></textarea>

                <button type="submit">Enviar</button>
            </form>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Roupa Tuga. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
